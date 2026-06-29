<?php
session_start();

date_default_timezone_set(date_default_timezone_get());

require_once '../../classes/conn.php';
include("../../classes/functions.php");
include("../../classes/fiscal.php");

$u = new Usuario;

/*
|--------------------------------------------------------------------------
| CAPTURA PARÂMETROS
|--------------------------------------------------------------------------
*/
$emissor    = filter_input(INPUT_GET, 'emissor') ?? null;
$cliente    = filter_input(INPUT_GET, 'cliente') ?? null;
$os         = filter_input(INPUT_GET, 'os') ?? null;
$descricao  = filter_input(INPUT_GET, 'descricao') ?? null;
$valor      = filter_input(INPUT_GET, 'valor') ?? null;

/*
|--------------------------------------------------------------------------
| SALVA NA SESSÃO
|--------------------------------------------------------------------------
*/
if (
    $emissor !== null ||
    $cliente !== null ||
    $os !== null ||
    $descricao !== null ||
    $valor !== null
) {
    $_SESSION['cnpj']           = $emissor;
    $_SESSION['cpf_cliente']    = $cliente;
    $_SESSION['os']             = $os;
    $_SESSION['descricao']      = $descricao;
    $_SESSION['valor']          = $valor;
}

/*
|--------------------------------------------------------------------------
| VALIDA CAMPOS OBRIGATÓRIOS
|--------------------------------------------------------------------------
*/
if (
    empty($_SESSION['cnpj']) ||
    empty($_SESSION['cpf_cliente']) ||
    empty($_SESSION['os']) ||
    empty($_SESSION['descricao']) ||
    empty($_SESSION['valor'])
) {
    die('<h2>Parâmetros obrigatórios não informados.</h2>');
}

try {
    /*
    |--------------------------------------------------------------------------
    | DADOS DA EMPRESA
    |--------------------------------------------------------------------------
    */
    if (empty($_SESSION['cd_empresa']) || empty($_SESSION['cnpj_empresa'])) {
        throw new Exception('Dados de identificação da empresa/filial ausentes na sessão.');
    }

    $cd_empresa    = preg_replace('/[^0-9]/', '', $_SESSION['cd_empresa']);
    $cd_filial     = preg_replace('/[^0-9]/', '', $_SESSION['cd_filial']);
    $cnpj_empresa  = preg_replace('/[^0-9]/', '', $_SESSION['cnpj_empresa']);

    /*
    |--------------------------------------------------------------------------
    | CAMINHOS DE DIRETÓRIOS
    |--------------------------------------------------------------------------
    */
    $baseDir = __DIR__ . '/../../fiscal/' . $cd_empresa;

    if (!is_dir($baseDir)) {
        if (!mkdir($baseDir, 0755, true)) {
            throw new Exception('Não foi possível criar o diretório base fiscal.');
        }
    }

    $baseDir = realpath($baseDir);
    if ($baseDir === false) {
        throw new Exception('Diretório base inválido ou sem permissão de leitura.');
    }

    /*
    |--------------------------------------------------------------------------
    | CERTIFICADO DIGITAL (PRODUÇÃO)
    |--------------------------------------------------------------------------
    */
    $caminhoCertificado =
        $baseDir .
        DIRECTORY_SEPARATOR .
        'certificados' .
        DIRECTORY_SEPARATOR .
        'certificado_a1_' .
        $cnpj_empresa .
        '.pfx';

    // ATENÇÃO: Substitua pela senha real do certificado A1 de produção se for diferente
    $senhaCertificado = '03032020'; 

    if (!file_exists($caminhoCertificado)) {
        throw new Exception('Certificado digital de produção não localizado no servidor.');
    }

    /*
    |--------------------------------------------------------------------------
    | PREPARA DIRETÓRIOS DE INFRAESTRUTURA
    |--------------------------------------------------------------------------
    */
    $diretorioLogs = $baseDir . DIRECTORY_SEPARATOR . 'fiscal' . DIRECTORY_SEPARATOR . 'nfse' . DIRECTORY_SEPARATOR . 'logs';
    if (!is_dir($diretorioLogs)) {
        mkdir($diretorioLogs, 0755, true);
    }

    $diretorioXml = $baseDir . DIRECTORY_SEPARATOR . 'fiscal' . DIRECTORY_SEPARATOR . 'nfse' . DIRECTORY_SEPARATOR . 'xml';
    if (!is_dir($diretorioXml)) {
        mkdir($diretorioXml, 0755, true);
    }

    /*
    |--------------------------------------------------------------------------
    | INSTANCIA A CLASSE FISCAL
    |--------------------------------------------------------------------------
    | Nota: Garanta que internamente a classe Fiscal esteja apontando para os 
    | endpoints de Produção das prefeituras/provedores.
    |--------------------------------------------------------------------------
    */
    $nfse = new Fiscal($caminhoCertificado, $senhaCertificado);

    $cnpj           = $_SESSION['cnpj'];
    $cpf_cliente    = $_SESSION['cpf_cliente'];
    $descricao      = $_SESSION['descricao'];
    $valor          = $_SESSION['valor'];

    /*
    |--------------------------------------------------------------------------
    | EXECUTA A EMISSÃO
    |--------------------------------------------------------------------------
    */
    $resposta = $nfse->emitirNFSE(
        $cd_empresa,
        $cd_filial,
        $cnpj,
        $cpf_cliente,
        $os,
        $descricao,
        $valor
    );

    /*
    |--------------------------------------------------------------------------
    | TRATAMENTO DO RETORNO DA API
    |--------------------------------------------------------------------------
    */
    $jsonResposta = [];
    if (is_array($resposta) && !empty($resposta['resposta'])) {
        $jsonResposta = json_decode($resposta['resposta'], true);
    }

    // Validação Crítica de Produção: Se a resposta for inválida ou contiver erro, interrompe antes de salvar falso sucesso
    if (empty($jsonResposta)) {
        throw new Exception('A API de envio não retornou um JSON válido ou respondeu em branco.');
    }
    
    if (isset($jsonResposta['erro']) || isset($jsonResposta['error'])) {
        $msgErro = $jsonResposta['mensagem'] ?? $jsonResposta['erro'] ?? 'Erro desconhecido informado pela API.';
        throw new Exception('A API de Produção barrou o envio: ' . $msgErro);
    }

    /*
    |--------------------------------------------------------------------------
    | PROTOCOLO DE AUTORIZAÇÃO
    |--------------------------------------------------------------------------
    */
    $protocolo = $jsonResposta['protocolo'] ?? null;
    if (empty($protocolo)) {
        throw new Exception('A nota não retornou um Protocolo válido da Prefeitura. Processamento abortado.');
    }

    $protocolo = preg_replace('/[^A-Za-z0-9_-]/', '_', $protocolo);

    /*
    |--------------------------------------------------------------------------
    | SALVA LOG DO RETORNO COMPLETO
    |--------------------------------------------------------------------------
    */
    $arquivoRetorno = $diretorioLogs . DIRECTORY_SEPARATOR . 'retorno_' . $protocolo . '.txt';
    file_put_contents($arquivoRetorno, print_r($resposta, true));

    /*
    |--------------------------------------------------------------------------
    | DADOS DE SUCESSO DA NFS-e
    |--------------------------------------------------------------------------
    */
    // Em produção, se a prefeitura não retornou o número correto da nota, gera erro para não corromper o banco
    if (empty($jsonResposta['numero_nfse'])) {
        throw new Exception('O número oficial da NFS-e não foi enviado de volta pela prefeitura.');
    }
    $numeroNFSe = $jsonResposta['numero_nfse'];

    $codigoVerificacao = $jsonResposta['codigo_verificacao'] ?? null;
    if (empty($codigoVerificacao)) {
        throw new Exception('O código de verificação da NFS-e não foi informado.');
    }

    $dataEmissao = $jsonResposta['data_emissao'] ?? date('Y-m-d H:i:s');

    /*
    |--------------------------------------------------------------------------
    | CAPTURA OU GERAÇÃO DA CHAVE DE ACESSO
    |--------------------------------------------------------------------------
    */
    $chaveAcesso = $jsonResposta['chave']
                ?? $jsonResposta['chave_nfse']
                ?? $jsonResposta['chave_acesso']
                ?? $jsonResposta['chNFSe']
                ?? null;

    if (empty($chaveAcesso)) {
        // Fallback estruturado baseado no padrão manual nacional se a API não entregar a string da chave montada
        $cnpjPrestador       = preg_replace('/\D/', '', $cnpj);
        $numeroNFSeLimpo     = preg_replace('/\D/', '', $numeroNFSe);
        $codigoMunicipio     = '3304557'; // Exemplo: Rio de Janeiro. Atualize se variar por empresa.

        /*
        |--------------------------------------------------------------------------
        | CONFIGURAÇÃO DO AMBIENTE: 1 = Produção
        |--------------------------------------------------------------------------
        */
        $ambiente            = '1'; // ALTERADO DE '2' PARA '1' (PRODUÇÃO)
        $tipoInscricao       = '2'; // 2 = CNPJ

        $cnpjPrestador       = str_pad($cnpjPrestador, 14, '0', STR_PAD_LEFT);
        $numeroNFSeFormatado = str_pad($numeroNFSeLimpo, 13, '0', STR_PAD_LEFT);
        $anoMes              = date('ym');
        $codigoNumerico      = str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);

        $chaveSemDV = $codigoMunicipio . $ambiente . $tipoInscricao . $cnpjPrestador . $numeroNFSeFormatado . $anoMes . $codigoNumerico;

        if (!function_exists('gerarDVNFSe')) {
            function gerarDVNFSe($chave) {
                $multiplicador = 2;
                $soma = 0;
                for ($i = strlen($chave) - 1; $i >= 0; $i--) {
                    $soma += intval($chave[$i]) * $multiplicador;
                    $multiplicador++;
                    if ($multiplicador > 9) { $multiplicador = 2; }
                }
                $resto = $soma % 11;
                $dv = 11 - $resto;
                return ($dv >= 10) ? 0 : $dv;
            }
        }

        $dv          = gerarDVNFSe($chaveSemDV);
        $chaveAcesso = $chaveSemDV . $dv;
    }

    $chaveAcesso = preg_replace('/[^0-9]/', '', $chaveAcesso);

    /*
    |--------------------------------------------------------------------------
    | CONSTRUÇÃO E GRAVAÇÃO DO DOCUMENTO XML
    |--------------------------------------------------------------------------
    */
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    $nfseXml = $dom->createElement('NFSe');
    $dom->appendChild($nfseXml);

    $inf = $dom->createElement('infNFSe');
    $nfseXml->appendChild($inf);

    $inf->appendChild($dom->createElement('numero', $numeroNFSe));
    $inf->appendChild($dom->createElement('codigoVerificacao', $codigoVerificacao));
    $inf->appendChild($dom->createElement('chaveAcesso', $chaveAcesso));
    $inf->appendChild($dom->createElement('protocolo', $protocolo));
    $inf->appendChild($dom->createElement('dataEmissao', $dataEmissao));

    $prestador = $dom->createElement('prestador');
    $prestador->appendChild($dom->createElement('cnpj', preg_replace('/\D/', '', $cnpj)));
    $inf->appendChild($prestador);

    $tomador = $dom->createElement('tomador');
    $tomador->appendChild($dom->createElement('cpf', preg_replace('/\D/', '', $cpf_cliente)));
    $inf->appendChild($tomador);

    $servico = $dom->createElement('servico');
    $servico->appendChild($dom->createElement('descricao', $descricao));
    $servico->appendChild($dom->createElement('valorServicos', number_format((float)$valor, 2, '.', '')));
    $inf->appendChild($servico);

    $xmlNFSe = $dom->saveXML();

    $nomeArquivo = 'nfse_' . $chaveAcesso . '.xml';
    $arquivoXml  = $diretorioXml . DIRECTORY_SEPARATOR . $nomeArquivo;
    file_put_contents($arquivoXml, $xmlNFSe);

    /*
    |--------------------------------------------------------------------------
    | PERSISTÊNCIA DOS DADOS NO BANCO DE DADOS
    |--------------------------------------------------------------------------
    */
    $nfse->atualizarNFSE($os, [
        'status_nfse'        => 'AUTORIZADA',
        'sucesso'            => 1,
        'numero_nfse'        => $numeroNFSe,
        'codigo_verificacao' => $codigoVerificacao,
        'chave_acesso'       => $chaveAcesso,
        'protocolo'          => $protocolo,
        'data_autorizacao'   => date('Y-m-d H:i:s'),
        'data_processamento' => date('Y-m-d H:i:s'),
        'data_emissao'       => $dataEmissao,
        'xml_nfse'           => $xmlNFSe,
        'json_retorno'       => json_encode($resposta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        'retorno_completo'   => print_r($resposta, true),
        'caminho_xml'        => $arquivoXml,
        'caminho_retorno'    => $arquivoRetorno,
        'valor_servicos'     => number_format((float)$valor, 2, '.', ''),
        'valor_total'        => number_format((float)$valor, 2, '.', '')
    ]);

    /*
    |--------------------------------------------------------------------------
    | INTERFACE VISUAL DE REDIRECIONAMENTO (SUCESSO)
    |--------------------------------------------------------------------------
    */
    $_SESSION['msg_nfse'] = 'NFS-e emitida com sucesso! Nº ' . $numeroNFSe;

    echo '
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>NFS-e Emitida</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <style>
            *{box-sizing:border-box;}
            body{margin:0;padding:20px;background:#f4f6f9;font-family:Arial, sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;}
            .card{width:100%;max-width:700px;background:#ffffff;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.08);overflow:hidden;}
            .topo{background:linear-gradient(135deg, #198754, #157347);color:#fff;text-align:center;padding:35px 20px;}
            .icone{font-size:70px;margin-bottom:15px;}
            .titulo{font-size:32px;font-weight:bold;margin-bottom:10px;}
            .subtitulo{font-size:16px;opacity:0.95;}
            .conteudo{padding:25px;}
            .linha{display:flex;justify-content:space-between;gap:15px;padding:14px 0;border-bottom:1px solid #e9ecef;word-break:break-word;}
            .linha:last-child{border-bottom:none;}
            .label{font-weight:bold;color:#495057;min-width:160px;}
            .valor{color:#212529;text-align:right;flex:1;}
            .contador-box{margin-top:30px;text-align:center;}
            .contador-label{font-size:16px;color:#6c757d;margin-bottom:10px;}
            .contador{width:90px;height:90px;margin:auto;border-radius:50%;background:#0d6efd;color:#fff;font-size:42px;font-weight:bold;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(13,110,253,0.3);}
            .rodape{padding:20px;text-align:center;background:#f8f9fa;border-top:1px solid #e9ecef;}
            .btn{display:inline-block;padding:12px 25px;border-radius:8px;background:#198754;color:#fff;text-decoration:none;font-weight:bold;transition:0.2s;}
            .btn:hover{background:#157347;}
            @media(max-width:768px){
                body{padding:10px;}
                .topo{padding:25px 15px;}
                .titulo{font-size:24px;}
                .icone{font-size:55px;}
                .conteudo{padding:18px;}
                .linha{flex-direction:column;gap:6px;}
                .label{min-width:auto;text-align:left;}
                .valor{text-align:left;font-size:14px;}
                .contador{width:75px;height:75px;font-size:34px;}
            }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="topo">
                <div class="icone"><i class="fa-solid fa-circle-check"></i></div>
                <div class="titulo">NFS-e Emitida</div>
                <div class="subtitulo">Documento fiscal autorizado com sucesso</div>
            </div>
            <div class="conteudo">
                <div class="linha">
                    <div class="label">Número NFS-e</div>
                    <div class="valor">'.$numeroNFSe.'</div>
                </div>
                <div class="linha">
                    <div class="label">Chave de Acesso</div>
                    <div class="valor">'.$chaveAcesso.'</div>
                </div>
                <div class="linha">
                    <div class="label">Código Verificação</div>
                    <div class="valor">'.$codigoVerificacao.'</div>
                </div>
                <div class="linha">
                    <div class="label">Protocolo</div>
                    <div class="valor">'.$protocolo.'</div>
                </div>
                <div class="linha">
                    <div class="label">XML</div>
                    <div class="valor">'.basename($arquivoXml).'</div>
                </div>
                <div class="contador-box">
                    <div class="contador-label">Redirecionando automaticamente em</div>
                    <div class="contador" id="contador">5</div>
                </div>
            </div>
            <div class="rodape">
                <a href="javascript:history.back();" class="btn">Voltar Agora</a>
            </div>
        </div>
    <script>
        let tempo = 5;
        const contador = document.getElementById("contador");
        const intervalo = setInterval(function(){
            tempo--;
            contador.innerHTML = tempo;
            if(tempo <= 0){
                clearInterval(intervalo);
                if(document.referrer != ""){
                    window.location.href = document.referrer;
                }else{
                    window.history.back();
                }
            }
        }, 1000);
    </script>
    </body>
    </html>
    ';
    exit;

} catch (Exception $e) {
    /*
    |--------------------------------------------------------------------------
    | TRATAMENTO DE ERRO SEGURO EM PRODUÇÃO (INFORMATION DISCLOSURE)
    |--------------------------------------------------------------------------
    | Em produção, ocultamos os caminhos físicos e a stack trace do usuário final.
    | O erro completo com a linha exata é salvo no arquivo oculto de logs.
    |--------------------------------------------------------------------------
    */
    echo '<h2>Erro ao processar NFS-e</h2>';
    echo '<p>Não foi possível concluir a emissão da Nota Fiscal. A falha foi registrada no sistema interno e nossa equipe técnica monitora os incidentes. Por favor, revise os dados ou tente novamente em instantes.</p>';

    if (isset($diretorioLogs)) {
        if (!is_dir($diretorioLogs)) {
            mkdir($diretorioLogs, 0755, true);
        }

        $logData = '[' . date('Y-m-d H:i:s') . '] ERRO EMISSÃO PRODUÇÃO' . PHP_EOL .
                   'Mensagem: ' . $e->getMessage() . PHP_EOL .
                   'Arquivo: ' . $e->getFile() . ' na Linha: ' . $e->getLine() . PHP_EOL .
                   'Trace: ' . $e->getTraceAsString() . PHP_EOL .
                   str_repeat('-', 50) . PHP_EOL . PHP_EOL;

        file_put_contents(
            $diretorioLogs . DIRECTORY_SEPARATOR . 'erro_nfse.txt',
            $logData,
            FILE_APPEND
        );
    }
}
?>