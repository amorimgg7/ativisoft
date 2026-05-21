<?php
require_once '../../classes/conn.php';
require_once '../../classes/fiscal.php';

try {

    /*
    |--------------------------------------------------------------------------
    | DEFINIÇÃO DOS CAMINHOS
    |--------------------------------------------------------------------------
    | __DIR__ = C:\xampp\htdocs\ativisoft_1_0\ativisoft_2_0\pages\md_assistencia
    |
    | ../../  => volta para:
    | C:\xampp\htdocs\ativisoft_1_0\ativisoft_2_0
    |--------------------------------------------------------------------------
    */
    $baseDir = realpath(__DIR__ . '/../../');

    if ($baseDir === false) {
        throw new Exception('Não foi possível localizar o diretório base do projeto.');
    }

    /*
    |--------------------------------------------------------------------------
    | CAMINHO DO CERTIFICADO
    |--------------------------------------------------------------------------
    | Estrutura esperada:
    | ativisoft_2_0/
    | └── fiscal/
    |     └── nfse/
    |         └── certificados/
    |             └── certificado_g5.pfx
    |--------------------------------------------------------------------------
    */
    $caminhoCertificado = $baseDir
        . DIRECTORY_SEPARATOR . 'fiscal'
        . DIRECTORY_SEPARATOR . 'nfse'
        . DIRECTORY_SEPARATOR . 'certificados'
        . DIRECTORY_SEPARATOR . 'certificado_g5.pfx';

    /*
    |--------------------------------------------------------------------------
    | DIRETÓRIO DE LOGS
    |--------------------------------------------------------------------------
    */
    $diretorioLogs = $baseDir
        . DIRECTORY_SEPARATOR . 'fiscal'
        . DIRECTORY_SEPARATOR . 'nfse'
        . DIRECTORY_SEPARATOR . 'logs';

    // Cria a pasta de logs se não existir
    if (!is_dir($diretorioLogs)) {
        mkdir($diretorioLogs, 0777, true);
    }

    /*
    |--------------------------------------------------------------------------
    | SENHA DO CERTIFICADO
    |--------------------------------------------------------------------------
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
    | DADOS DE TESTE
    |--------------------------------------------------------------------------
    */
    $cnpj = '12345678000195';
    $cpf_cliente = '11144477735';
    $descricao = 'Serviço de suporte técnico em informática - TESTE';
    $valor = 150.00;

    $_SESSION['toEncoding'] = 'ISO-8859-1';
    $_SESSION['fromEncoding'] = 'UTF-8';
        
    global $pdo;
    $u = new Usuario();
        
    //$u->loadModulos2('', '');

    $conNFSE = $pdo->prepare("SELECT * FROM tb_dados_nfse WHERE chave_acesso = :cac AND protocolo = :prt");
    $conNFSE->bindValue(":cac", $chave_acesso);
    $conNFSE->bindValue(":prt", $protocolo);
    $conNFSE->execute();
    //echo "<script>window.alert('Area do cliente');</script>";

    if($loginCliente->rowCount() > 0){

    }


    /*
    |--------------------------------------------------------------------------
    | EMITIR NFS-e (SIMULAÇÃO OU TESTE)
    |--------------------------------------------------------------------------
    */
    $resposta = $nfse->emitirNFSE(
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
    | SALVAR RETORNO
    |--------------------------------------------------------------------------
    */
    file_put_contents(
        $diretorioLogs . DIRECTORY_SEPARATOR . 'retorno_nfse.txt',
        print_r($resposta, true)
    );

    echo '<p>Arquivo salvo em: '
        . htmlspecialchars(
            $diretorioLogs . DIRECTORY_SEPARATOR . 'retorno_nfse.txt'
        )
        . '</p>';

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

    $html = curl_exec($ch);

    if ($html === false) {
        echo '<pre>Erro cURL: ' . curl_error($ch) . '</pre>';
    } else {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $urlFinal = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        echo '<pre>';
        echo "HTTP Code: " . $httpCode . PHP_EOL;
        echo "URL Final: " . $urlFinal . PHP_EOL;
        echo "Content-Type: " . $contentType . PHP_EOL;
        echo '</pre>';

        if ($httpCode == 496) {
            echo '<p><strong>O servidor exige certificado digital do cliente (HTTP 496).</strong></p>';
        }
    }

    curl_close($ch);

    /*
    |--------------------------------------------------------------------------
    | EXIBIR INFORMAÇÕES DOS CAMINHOS
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
    echo $e->getMessage();
    echo '</pre>';

    // Tenta salvar o erro no arquivo de log
    if (isset($diretorioLogs)) {
        if (!is_dir($diretorioLogs)) {
            @mkdir($diretorioLogs, 0777, true);
        }

        @file_put_contents(
            $diretorioLogs . DIRECTORY_SEPARATOR . 'erro_nfse.txt',
            date('Y-m-d H:i:s') . PHP_EOL .
            $e->getMessage() . PHP_EOL
        );
    }
}
?>