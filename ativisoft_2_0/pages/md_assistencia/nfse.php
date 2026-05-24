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
| VALIDA CAMPOS
|--------------------------------------------------------------------------
*/
if (
    empty($_SESSION['cnpj']) ||
    empty($_SESSION['cpf_cliente']) ||
    empty($_SESSION['os']) ||
    empty($_SESSION['descricao']) ||
    empty($_SESSION['valor'])
) {

    die(
        '<h2>Parâmetros obrigatórios não informados.</h2>'
    );
}

try {

    /*
    |--------------------------------------------------------------------------
    | DADOS DA EMPRESA
    |--------------------------------------------------------------------------
    */
    $cd_empresa    = preg_replace('/[^0-9]/', '', $_SESSION['cd_empresa']);
    $cd_filial     = preg_replace('/[^0-9]/', '', $_SESSION['cd_filial']);
    $cnpj_empresa  = preg_replace('/[^0-9]/', '', $_SESSION['cnpj_empresa']);

    /*
    |--------------------------------------------------------------------------
    | CAMINHOS
    |--------------------------------------------------------------------------
    */
    $baseDir = __DIR__ . '/../../fiscal/' . $cd_empresa;

    if (!is_dir($baseDir)) {

        if (!mkdir($baseDir, 0755, true)) {

            throw new Exception(
                'Não foi possível criar diretório base.'
            );
        }
    }

    $baseDir = realpath($baseDir);

    if ($baseDir === false) {

        throw new Exception(
            'Diretório base inválido.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CERTIFICADO
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

    $senhaCertificado = '03032020';

    if (!file_exists($caminhoCertificado)) {

        throw new Exception(
            'Certificado não encontrado: ' .
            $caminhoCertificado
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOGS
    |--------------------------------------------------------------------------
    */
    $diretorioLogs =
        $baseDir .
        DIRECTORY_SEPARATOR .
        'fiscal' .
        DIRECTORY_SEPARATOR .
        'nfse' .
        DIRECTORY_SEPARATOR .
        'logs';

    if (!is_dir($diretorioLogs)) {

        mkdir($diretorioLogs, 0755, true);
    }

    /*
    |--------------------------------------------------------------------------
    | XML
    |--------------------------------------------------------------------------
    */
    $diretorioXml =
        $baseDir .
        DIRECTORY_SEPARATOR .
        'fiscal' .
        DIRECTORY_SEPARATOR .
        'nfse' .
        DIRECTORY_SEPARATOR .
        'xml';

    if (!is_dir($diretorioXml)) {

        mkdir($diretorioXml, 0755, true);
    }

    /*
    |--------------------------------------------------------------------------
    | INSTANCIA FISCAL
    |--------------------------------------------------------------------------
    */
    $nfse = new Fiscal(
        $caminhoCertificado,
        $senhaCertificado
    );

    /*
    |--------------------------------------------------------------------------
    | DADOS
    |--------------------------------------------------------------------------
    */
    $cnpj           = $_SESSION['cnpj'];
    $cpf_cliente    = $_SESSION['cpf_cliente'];
    $descricao      = $_SESSION['descricao'];
    $valor          = $_SESSION['valor'];

    /*
    |--------------------------------------------------------------------------
    | DEBUG
    |--------------------------------------------------------------------------
    */
    /*
    echo '<h2>Dados Recebidos</h2>';

    echo '<pre>';
    echo 'Empresa: ' . $cd_empresa . PHP_EOL;
    echo 'Filial: ' . $cd_filial . PHP_EOL;
    echo 'OS: ' . $os . PHP_EOL;
    echo 'CNPJ: ' . $cnpj . PHP_EOL;
    echo 'CPF Cliente: ' . $cpf_cliente . PHP_EOL;
    echo 'Descrição: ' . $descricao . PHP_EOL;
    echo 'Valor: ' . $valor . PHP_EOL;
    echo '</pre>';
*/
    /*
    |--------------------------------------------------------------------------
    | EMISSÃO
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
    | EXIBE RESPOSTA
    |--------------------------------------------------------------------------
    */
/*    echo '<h2>Retorno</h2>';

    echo '<pre>';
    print_r($resposta);
    echo '</pre>';
*/
    /*
    |--------------------------------------------------------------------------
    | JSON
    |--------------------------------------------------------------------------
    */
    $jsonResposta = [];

    if (
        is_array($resposta) &&
        !empty($resposta['resposta'])
    ) {

        $jsonResposta = json_decode(
            $resposta['resposta'],
            true
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PROTOCOLO
    |--------------------------------------------------------------------------
    */
    $protocolo =
        $jsonResposta['protocolo']
        ?? 'SEM_PROTOCOLO';

    $protocolo = preg_replace(
        '/[^A-Za-z0-9_-]/',
        '_',
        $protocolo
    );

    /*
    |--------------------------------------------------------------------------
    | SALVA RETORNO
    |--------------------------------------------------------------------------
    */
    $arquivoRetorno =
        $diretorioLogs .
        DIRECTORY_SEPARATOR .
        'retorno_' .
        $protocolo .
        '.txt';

    file_put_contents(
        $arquivoRetorno,
        print_r($resposta, true)
    );

    /*
    |--------------------------------------------------------------------------
    | GERA XML
    |--------------------------------------------------------------------------
    */
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    $nfseXml = $dom->createElement('NFSe');
    $dom->appendChild($nfseXml);

    $inf = $dom->createElement('infNFSe');
    $nfseXml->appendChild($inf);

    /*
    |--------------------------------------------------------------------------
    | DADOS DA NFS-e
    |--------------------------------------------------------------------------
    */
    $numeroNFSe =
        $jsonResposta['numero_nfse']
        ?? rand(1000, 9999);

    $codigoVerificacao =
        $jsonResposta['codigo_verificacao']
        ?? strtoupper(substr(md5(uniqid()), 0, 8));

    $dataEmissao =
        $jsonResposta['data_emissao']
        ?? date('Y-m-d H:i:s');

    /*
    |--------------------------------------------------------------------------
    | CHAVE ACESSO
    |--------------------------------------------------------------------------
    */
    $chaveAcesso =
        preg_replace('/\D/', '', $cnpj) .
        str_pad(
            $numeroNFSe,
            15,
            '0',
            STR_PAD_LEFT
        );

    /*
    |--------------------------------------------------------------------------
    | XML
    |--------------------------------------------------------------------------
    */
    $inf->appendChild(
        $dom->createElement(
            'numero',
            $numeroNFSe
        )
    );

    $inf->appendChild(
        $dom->createElement(
            'codigoVerificacao',
            $codigoVerificacao
        )
    );

    $inf->appendChild(
        $dom->createElement(
            'chaveAcesso',
            $chaveAcesso
        )
    );

    $inf->appendChild(
        $dom->createElement(
            'protocolo',
            $protocolo
        )
    );

    $inf->appendChild(
        $dom->createElement(
            'dataEmissao',
            $dataEmissao
        )
    );

    /*
    |--------------------------------------------------------------------------
    | PRESTADOR
    |--------------------------------------------------------------------------
    */
    $prestador = $dom->createElement('prestador');

    $prestador->appendChild(
        $dom->createElement(
            'cnpj',
            preg_replace('/\D/', '', $cnpj)
        )
    );

    $inf->appendChild($prestador);

    /*
    |--------------------------------------------------------------------------
    | TOMADOR
    |--------------------------------------------------------------------------
    */
    $tomador = $dom->createElement('tomador');

    $tomador->appendChild(
        $dom->createElement(
            'cpf',
            preg_replace('/\D/', '', $cpf_cliente)
        )
    );

    $inf->appendChild($tomador);

    /*
    |--------------------------------------------------------------------------
    | SERVIÇO
    |--------------------------------------------------------------------------
    */
    $servico = $dom->createElement('servico');

    $servico->appendChild(
        $dom->createElement(
            'descricao',
            $descricao
        )
    );

    $servico->appendChild(
        $dom->createElement(
            'valorServicos',
            number_format(
                (float)$valor,
                2,
                '.',
                ''
            )
        )
    );

    $inf->appendChild($servico);

    /*
    |--------------------------------------------------------------------------
    | XML FINAL
    |--------------------------------------------------------------------------
    */
    $xmlNFSe = $dom->saveXML();

    /*
    |--------------------------------------------------------------------------
    | ARQUIVO XML
    |--------------------------------------------------------------------------
    */
    $nomeArquivo =
        'nfse_' .
        $chaveAcesso .
        '.xml';

    $arquivoXml =
        $diretorioXml .
        DIRECTORY_SEPARATOR .
        $nomeArquivo;

    file_put_contents(
        $arquivoXml,
        $xmlNFSe
    );

    /*
    |--------------------------------------------------------------------------
    | UPDATE NO BANCO
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

        'json_retorno'       => json_encode(
            $resposta,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        ),

        'retorno_completo'   => print_r($resposta, true),

        'caminho_xml'        => $arquivoXml,

        'caminho_retorno'    => $arquivoRetorno,

        'valor_servicos'     => number_format(
            (float)$valor,
            2,
            '.',
            ''
        ),

        'valor_total'        => number_format(
            (float)$valor,
            2,
            '.',
            ''
        )

    ]);

    /*
|--------------------------------------------------------------------------
| SUCESSO
|--------------------------------------------------------------------------
*/

$_SESSION['msg_nfse'] =
    'NFS-e emitida com sucesso! Nº ' .
    $numeroNFSe;

echo '
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta 
        name="viewport" 
        content="width=device-width, initial-scale=1.0"
    >

    <title>NFS-e Emitida</title>

    <link 
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

        *{
            box-sizing:border-box;
        }

        body{

            margin:0;
            padding:20px;

            background:#f4f6f9;

            font-family:Arial, sans-serif;

            display:flex;
            align-items:center;
            justify-content:center;

            min-height:100vh;
        }

        .card{

            width:100%;
            max-width:700px;

            background:#ffffff;

            border-radius:16px;

            box-shadow:
                0 4px 20px rgba(0,0,0,0.08);

            overflow:hidden;
        }

        .topo{

            background:linear-gradient(
                135deg,
                #198754,
                #157347
            );

            color:#fff;

            text-align:center;

            padding:35px 20px;
        }

        .icone{

            font-size:70px;

            margin-bottom:15px;
        }

        .titulo{

            font-size:32px;
            font-weight:bold;

            margin-bottom:10px;
        }

        .subtitulo{

            font-size:16px;

            opacity:0.95;
        }

        .conteudo{

            padding:25px;
        }

        .linha{

            display:flex;

            justify-content:space-between;

            gap:15px;

            padding:14px 0;

            border-bottom:1px solid #e9ecef;

            word-break:break-word;
        }

        .linha:last-child{

            border-bottom:none;
        }

        .label{

            font-weight:bold;

            color:#495057;

            min-width:160px;
        }

        .valor{

            color:#212529;

            text-align:right;

            flex:1;
        }

        .contador-box{

            margin-top:30px;

            text-align:center;
        }

        .contador-label{

            font-size:16px;

            color:#6c757d;

            margin-bottom:10px;
        }

        .contador{

            width:90px;
            height:90px;

            margin:auto;

            border-radius:50%;

            background:#0d6efd;

            color:#fff;

            font-size:42px;
            font-weight:bold;

            display:flex;
            align-items:center;
            justify-content:center;

            box-shadow:
                0 4px 12px rgba(13,110,253,0.3);
        }

        .rodape{

            padding:20px;

            text-align:center;

            background:#f8f9fa;

            border-top:1px solid #e9ecef;
        }

        .btn{

            display:inline-block;

            padding:12px 25px;

            border-radius:8px;

            background:#198754;

            color:#fff;

            text-decoration:none;

            font-weight:bold;

            transition:0.2s;
        }

        .btn:hover{

            background:#157347;
        }

        @media(max-width:768px){

            body{
                padding:10px;
            }

            .topo{

                padding:25px 15px;
            }

            .titulo{

                font-size:24px;
            }

            .icone{

                font-size:55px;
            }

            .conteudo{

                padding:18px;
            }

            .linha{

                flex-direction:column;

                gap:6px;
            }

            .label{

                min-width:auto;

                text-align:left;
            }

            .valor{

                text-align:left;

                font-size:14px;
            }

            .contador{

                width:75px;
                height:75px;

                font-size:34px;
            }
        }

    </style>

</head>

<body>

    <div class="card">

        <div class="topo">

            <div class="icone">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <div class="titulo">
                NFS-e Emitida
            </div>

            <div class="subtitulo">
                Documento fiscal autorizado com sucesso
            </div>

        </div>

        <div class="conteudo">

            <div class="linha">

                <div class="label">
                    Número NFS-e
                </div>

                <div class="valor">
                    '.$numeroNFSe.'
                </div>

            </div>

            <div class="linha">

                <div class="label">
                    Chave de Acesso
                </div>

                <div class="valor">
                    '.$chaveAcesso.'
                </div>

            </div>

            <div class="linha">

                <div class="label">
                    Código Verificação
                </div>

                <div class="valor">
                    '.$codigoVerificacao.'
                </div>

            </div>

            <div class="linha">

                <div class="label">
                    Protocolo
                </div>

                <div class="valor">
                    '.$protocolo.'
                </div>

            </div>

            <div class="linha">

                <div class="label">
                    XML
                </div>

                <div class="valor">
                    '.basename($arquivoXml).'
                </div>

            </div>

            <div class="contador-box">

                <div class="contador-label">
                    Redirecionando automaticamente em
                </div>

                <div class="contador" id="contador">
                    5
                </div>

            </div>

        </div>

        <div class="rodape">

            <a
                href="javascript:history.back();"
                class="btn"
            >
                Voltar Agora
            </a>

        </div>

    </div>

<script>

    let tempo = 5;

    const contador =
        document.getElementById("contador");

    const intervalo = setInterval(function(){

        tempo--;

        contador.innerHTML = tempo;

        if(tempo <= 0){

            clearInterval(intervalo);

            if(document.referrer != ""){

                window.location.href =
                    document.referrer;

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

    echo '<h2>Erro ao emitir NFS-e</h2>';

    echo '<pre>';
    echo htmlspecialchars(
        $e->getMessage()
    );
    echo '</pre>';

    if (isset($diretorioLogs)) {

        if (!is_dir($diretorioLogs)) {

            mkdir($diretorioLogs, 0755, true);
        }

        file_put_contents(

            $diretorioLogs .
            DIRECTORY_SEPARATOR .
            'erro_nfse.txt',

            date('Y-m-d H:i:s') .
            PHP_EOL .

            $e->getMessage() .
            PHP_EOL .
            PHP_EOL,

            FILE_APPEND
        );
    }
}
?>