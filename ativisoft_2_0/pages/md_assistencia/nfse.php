
<?php
session_start();

date_default_timezone_set(date_default_timezone_get());

require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    include("../../classes/fiscal.php");
    $u = new Usuario;

/*
|--------------------------------------------------------------------------
| CAPTURAR PARÂMETROS DA URL
|--------------------------------------------------------------------------
| Utilizando os recursos nativos do PHP (Superglobal $_GET)
| Exemplo:
| http://localhost/.../nfse.php?
|   emissor=12345678000195&
|   cliente=11144477735&
|   descricao=Teste%20de%20servico&
|   valor=15
|--------------------------------------------------------------------------
*/
$emissor   = filter_input(INPUT_GET, 'emissor') ?? null;
$cliente   = filter_input(INPUT_GET, 'cliente') ?? null;
$descricao = filter_input(INPUT_GET, 'descricao') ?? null;
$valor     = filter_input(INPUT_GET, 'valor') ?? null;

/*
|--------------------------------------------------------------------------
| SE HOUVER PARÂMETROS NA URL, SALVAR NA SESSÃO
|--------------------------------------------------------------------------
*/
if ($emissor !== null || $cliente !== null || $descricao !== null || $valor !== null) {
    $_SESSION['cnpj']         = $emissor;
    $_SESSION['cpf_cliente']  = $cliente;
    $_SESSION['descricao']    = $descricao;
    $_SESSION['valor']        = $valor;
}

/*
|--------------------------------------------------------------------------
| VALIDAR DADOS OBRIGATÓRIOS
|--------------------------------------------------------------------------
*/
if (
    empty($_SESSION['cnpj']) ||
    empty($_SESSION['cpf_cliente']) ||
    empty($_SESSION['descricao']) ||
    empty($_SESSION['valor'])
) {
    die(
        '<h2>Parâmetros obrigatórios não informados.</h2>' .
        '<p>Exemplo de uso:</p>' .
        '<pre>' .
        htmlspecialchars(
            'http://localhost/ativisoft_1_0/ativisoft_2_0/pages/md_assistencia/nfse.php?' .
            'emissor=12345678000195&' .
            'cliente=11144477735&' .
            'descricao=Teste de servico&' .
            'valor=15'
        ) .
        '</pre>'
    );
}



try {
    /*
    |--------------------------------------------------------------------------
    | DEFINIÇÃO DOS CAMINHOS
    |--------------------------------------------------------------------------
    */
    /*
|--------------------------------------------------------------------------
| DIRETÓRIO BASE DA EMPRESA
|--------------------------------------------------------------------------
| Exemplo final:
| /ativisoft_2_0/empresas/1/
|--------------------------------------------------------------------------
*/

// Remove caracteres perigosos
$cd_empresa = preg_replace('/[^0-9]/', '', $_SESSION['cd_empresa']);
$cnpj_empresa = preg_replace('/[^0-9]/', '', $_SESSION['cnpj_empresa']);

// Caminho físico base
$baseDir = __DIR__ . '/../../fiscal/' . $cd_empresa;

/*
|--------------------------------------------------------------------------
| CRIA A PASTA SE NÃO EXISTIR
|--------------------------------------------------------------------------
*/
if (!is_dir($baseDir)) {
    if (!mkdir($baseDir, 0755, true)) {
        throw new Exception('Não foi possível criar o diretório: ' . $baseDir);
    }
}

/*
|--------------------------------------------------------------------------
| OBTÉM CAMINHO REAL
|--------------------------------------------------------------------------
*/
$baseDir = realpath($baseDir);

if ($baseDir === false) {
    throw new Exception('Não foi possível localizar o diretório base.');
}

/*
|--------------------------------------------------------------------------
| DEBUG
|--------------------------------------------------------------------------
*/
echo '<pre>';
echo 'Diretório base: ' . $baseDir;
echo '</pre>';

/*
|--------------------------------------------------------------------------
| CAMINHO DO CERTIFICADO
|--------------------------------------------------------------------------
*/
// CORRIGIDO: Sintaxe da string e remoção do "fiscal/nfse/../../" que era redundante.
// Isso apontará direto para "fiscal/{cd_empresa}/certificados/certificado_a1_{cnpj}.pfx"
$caminhoCertificado = $baseDir 
    . DIRECTORY_SEPARATOR . 'certificados' 
    . DIRECTORY_SEPARATOR . 'certificado_a1_' . $cnpj_empresa . '.pfx';

/*
|--------------------------------------------------------------------------
| DIRETÓRIO DE LOGS
|--------------------------------------------------------------------------
*/
$diretorioLogs = $baseDir 
    . DIRECTORY_SEPARATOR . 'fiscal' 
    . DIRECTORY_SEPARATOR . 'nfse' 
    . DIRECTORY_SEPARATOR . 'logs';

// Alterado para 0755 (mais seguro que 0777)
if (!is_dir($diretorioLogs)) {
    mkdir($diretorioLogs, 0755, true);
}

    /*
    |--------------------------------------------------------------------------
    | SENHA DO CERTIFICADO
    |--------------------------------------------------------------------------
    | Recomendação: Mover para um arquivo .env no futuro
    */
    $senhaCertificado = '03032020';

    /*
    |--------------------------------------------------------------------------
    | VALIDAR EXISTÊNCIA DO CERTIFICADO
    |--------------------------------------------------------------------------
    */
    if (!file_exists($caminhoCertificado)) {
        throw new Exception(
            "Certificado não encontrado:\n" . $caminhoCertificado
        );
    }

    /*
    |--------------------------------------------------------------------------
    | INSTANCIAR CLASSE FISCAL
    |--------------------------------------------------------------------------
    */
    $nfse = new Fiscal(
        $caminhoCertificado,
        $senhaCertificado
    );

    /*
    |--------------------------------------------------------------------------
    | RECUPERAR DADOS DA SESSÃO
    |--------------------------------------------------------------------------
    */
    $cd_empresa     =   $_SESSION['cd_empresa'];
    $cd_filial      =   $_SESSION['cd_filial'];
    $cnpj           =   $_SESSION['cnpj'];
    $cpf_cliente    =   $_SESSION['cpf_cliente'];
    $descricao      =   $_SESSION['descricao'];
    $valor          =   $_SESSION['valor'];

    /*
    |--------------------------------------------------------------------------
    | EXIBIR DADOS RECEBIDOS
    |--------------------------------------------------------------------------
    */
    echo '<h2>Dados Recebidos</h2>';
    echo '<pre>';
    echo 'CNPJ Emissor: ' . htmlspecialchars($cnpj) . PHP_EOL;
    echo 'CPF Cliente: ' . htmlspecialchars($cpf_cliente) . PHP_EOL;
    echo 'Descrição: ' . htmlspecialchars($descricao) . PHP_EOL;
    echo 'Valor: ' . htmlspecialchars($valor) . PHP_EOL;
    echo '</pre>';

    /*
    |--------------------------------------------------------------------------
    | EMITIR NFS-e
    |--------------------------------------------------------------------------
    */
    $resposta = $nfse->emitirNFSE(
        $cd_empresa,
        $cd_filial,
        $cnpj,
        $cpf_cliente,
        $descricao,
        $valor
    );

    /*
    |--------------------------------------------------------------------------
    | EXIBIR RESULTADO
    |--------------------------------------------------------------------------
    */
    echo '<h2>Resultado da Emissão</h2>';
    echo '<pre>';
    print_r($resposta);
    echo '</pre>';

    /*
    |--------------------------------------------------------------------------
    | OBTER PROTOCOLO PARA O NOME DO ARQUIVO
    |--------------------------------------------------------------------------
    */
    $protocolo = 'SEM_PROTOCOLO';

    // Caso o protocolo esteja diretamente no array
    if (is_array($resposta) && !empty($resposta['protocolo'])) {
        $protocolo = $resposta['protocolo'];
    }
    // Caso o protocolo esteja dentro do JSON em $resposta['resposta']
    elseif (is_array($resposta) && !empty($resposta['resposta'])) {
        $json = json_decode($resposta['resposta'], true);

        if (
            json_last_error() === JSON_ERROR_NONE &&
            is_array($json) &&
            !empty($json['protocolo'])
        ) {
            $protocolo = $json['protocolo'];
        }
    }

    // Remove caracteres inválidos para nome de arquivo
    $protocolo = preg_replace('/[^A-Za-z0-9_-]/', '_', $protocolo);

    /*
    |--------------------------------------------------------------------------
    | SALVAR RETORNO
    |--------------------------------------------------------------------------
    */
    $arquivoRetorno = $diretorioLogs
        . DIRECTORY_SEPARATOR
        . 'retorno_'
        . $protocolo
        . '.txt';

    file_put_contents(
        $arquivoRetorno,
        print_r($resposta, true)
    );

    echo '<p>Arquivo salvo em: '
        . htmlspecialchars($arquivoRetorno)
        . '</p>';


    /*
    |--------------------------------------------------------------------------
    | EXTRAIR OU GERAR XML DA NFS-e
    |--------------------------------------------------------------------------
    */
    $xmlNFSe = null;

    // 1) Tentar localizar XML diretamente na string
    if (is_string($resposta) && strpos(trim($resposta), '<') === 0) {
        $xmlNFSe = $resposta;
    }

    // Tentar localizar em chaves do array
    if ($xmlNFSe === null && is_array($resposta)) {
        $possiveisChaves = [
            'xml_nfse',
            'xml',
            'nfse_xml',
            'conteudoXml',
            'xmlAutorizado',
            'xmlNfse'
        ];

        foreach ($possiveisChaves as $chave) {
            if (!empty($resposta[$chave])) {
                $valorChave = $resposta[$chave];

                if (is_string($valorChave) && strpos(trim($valorChave), '<') === 0) {
                    $xmlNFSe = $valorChave;
                    break;
                }
            }
        }
    }

    // 2) Se não houver XML, gerar XML a partir do JSON de simulação
    if ($xmlNFSe === null && is_array($resposta) && isset($resposta['resposta'])) {
        $json = json_decode($resposta['resposta'], true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
            $dom = new DOMDocument('1.0', 'UTF-8');
            $dom->formatOutput = true;

            $nfseDom = $dom->createElement('NFSe');
            $nfseDom->setAttribute('versao', '1.00');
            $dom->appendChild($nfseDom);

            $inf = $dom->createElement('infNFSe');
            $nfseDom->appendChild($inf);

            // Número da NFS-e
            $inf->appendChild($dom->createElement('numero', $json['numero_nfse'] ?? '0'));

            // Código de verificação
            $inf->appendChild($dom->createElement('codigoVerificacao', $json['codigo_verificacao'] ?? ''));

            // Chave de acesso simulada
            $chaveAcessoStr = ($json['prestador']['cnpj'] ?? '') . str_pad((string)($json['numero_nfse'] ?? '0'), 15, '0', STR_PAD_LEFT);
            $inf->appendChild($dom->createElement('chaveAcesso', $chaveAcessoStr));

            // Data de emissão
            $inf->appendChild($dom->createElement('dataEmissao', $json['data_emissao'] ?? date('Y-m-d H:i:s')));

            // Protocolo
            $inf->appendChild($dom->createElement('protocolo', $json['protocolo'] ?? ''));

            // Prestador
            $prestador = $dom->createElement('prestador');
            $prestador->appendChild($dom->createElement('CNPJ', $json['prestador']['cnpj'] ?? $cnpj));
            $inf->appendChild($prestador);

            // Tomador
            $tomador = $dom->createElement('tomador');
            $tomador->appendChild($dom->createElement('CPF', $json['tomador']['cpf'] ?? $cpf_cliente));
            $inf->appendChild($tomador);

            // Serviço
            $servico = $dom->createElement('servico');
            $servico->appendChild($dom->createElement('descricao', $json['servico']['descricao'] ?? $descricao));
            $servico->appendChild($dom->createElement(
                'valorServicos',
                number_format((float)($json['servico']['valor'] ?? $valor), 2, '.', '')
            ));
            $inf->appendChild($servico);

            // Mensagem
            $inf->appendChild($dom->createElement('mensagem', $json['mensagem'] ?? 'NFS-e emitida com sucesso.'));

            $xmlNFSe = $dom->saveXML();
        }
    }

    // 3) Se ainda não existir XML, gerar erro
    if ($xmlNFSe === null) {
        throw new Exception(
            'Não foi possível obter ou gerar o XML da NFS-e. ' .
            'Verifique o conteúdo de retorno_' . $protocolo . '.txt.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXTRAIR DADOS DO XML PARA EXIBIÇÃO E NOMEAÇÃO DO ARQUIVO
    |--------------------------------------------------------------------------
    */
    libxml_use_internal_errors(true);
    $xmlData = simplexml_load_string($xmlNFSe);

    $numeroNFSe = 'NÃO IDENTIFICADO';
    $chaveAcesso = ''; // Inicializado vazio para fallback
    $dataEmissao = date('d/m/Y H:i:s');

    if ($xmlData !== false) {
        $buscarTag = function ($tag) use ($xmlData) {
            $resultado = $xmlData->xpath("//*[local-name()='{$tag}']");
            if (!empty($resultado)) {
                return (string)$resultado[0];
            }
            return null;
        };

        $numeroNFSe = $buscarTag('nNFSe') ?: $buscarTag('numero') ?: 'NÃO IDENTIFICADO';
        $chaveAcesso = $buscarTag('chNFSe') ?: $buscarTag('chaveAcesso') ?: '';
        $dataEmissao = $buscarTag('dhEmi') ?: $buscarTag('dataEmissao') ?: $dataEmissao;
    }

    /*
    |--------------------------------------------------------------------------
    | CRIAR DIRETÓRIO DE XML
    |--------------------------------------------------------------------------
    */
    $diretorioXml = $baseDir
        . DIRECTORY_SEPARATOR . 'fiscal'
        . DIRECTORY_SEPARATOR . 'nfse'
        . DIRECTORY_SEPARATOR . 'xml';

    // Alterado para 0755
    if (!is_dir($diretorioXml)) {
        mkdir($diretorioXml, 0755, true);
    }

    /*
    |--------------------------------------------------------------------------
    | SALVAR XML AUTORIZADO COM A CHAVE DE ACESSO
    |--------------------------------------------------------------------------
    */
    // Extrai apenas números da chave (por segurança)
    $nomeArquivoFinal = preg_replace('/[^0-9]/', '', $chaveAcesso);
    
    // Fallback: se não tiver chave, salva com data/hora para não gerar erro
    if (empty($nomeArquivoFinal)) {
        $nomeArquivoFinal = 'nfse_sem_chave_' . date('YmdHis');
    }

    $arquivoXml = $diretorioXml . DIRECTORY_SEPARATOR . 'nfse_'.$nomeArquivoFinal . '.xml';
    file_put_contents($arquivoXml, $xmlNFSe);

    echo '<p>XML da Nota salvo em: ' . htmlspecialchars($arquivoXml) . '</p>';

    /*
    |--------------------------------------------------------------------------
    | TESTE DE CONECTIVIDADE
    |--------------------------------------------------------------------------
    */
    echo '<hr>';
    echo '<h2>Teste de Conectividade com ADN NFS-e</h2>';

    $ch = curl_init('https://adn.nfse.gov.br/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, false);
    
    // Nota: Para autenticar via cURL com o SEFAZ/ADN, geralmente é necessário
    // um certificado em formato PEM. O Fiscal.php provavelmente faz isso.
    // curl_setopt($ch, CURLOPT_SSLCERT, $caminhoCertificadoEmPem);
    // curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $senhaCertificado);

    $html = curl_exec($ch);

    if ($html === false) {
        echo '<pre>Erro cURL: ' . curl_error($ch) . '</pre>';
    } else {
        $httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $urlFinal    = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        echo '<pre>';
        echo "HTTP Code: " . $httpCode . PHP_EOL;
        echo "URL Final: " . $urlFinal . PHP_EOL;
        echo "Content-Type: " . $contentType . PHP_EOL;
        echo '</pre>';

        if ($httpCode == 496) {
            echo '<p><strong>Aviso: O servidor exige certificado digital do cliente (HTTP 496). Isso é normal se o cURL de teste não estiver enviando o certificado.</strong></p>';
        }
    }

    curl_close($ch);

    /*
    |--------------------------------------------------------------------------
    | EXIBIR CAMINHOS
    |--------------------------------------------------------------------------
    */
    echo '<hr>';
    echo '<h2>Validação dos Caminhos</h2>';
    echo '<pre>';
    echo "Base do projeto: " . $baseDir . PHP_EOL;
    echo "Certificado: " . $caminhoCertificado . PHP_EOL;
    echo "Logs: " . $diretorioLogs . PHP_EOL;
    echo '</pre>';

} catch (Exception $e) {
    echo '<h2>Erro ao emitir NFS-e</h2>';
    echo '<pre>';
    echo htmlspecialchars($e->getMessage());
    echo '</pre>';

    if (isset($diretorioLogs)) {
        if (!is_dir($diretorioLogs)) {
            @mkdir($diretorioLogs, 0755, true);
        }

        @file_put_contents(
            $diretorioLogs . DIRECTORY_SEPARATOR . 'erro_nfse.txt',
            date('Y-m-d H:i:s') . PHP_EOL .
            $e->getMessage() . PHP_EOL,
            FILE_APPEND
        );
    }
}
?>

