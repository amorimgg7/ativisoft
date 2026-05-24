<?php
session_start();

date_default_timezone_set('America/Sao_Paulo');

header('Content-Type: text/html; charset=UTF-8');

/*
|--------------------------------------------------------------------------
| CONFIGURAÇÕES
|--------------------------------------------------------------------------
*/

$cd_empresa = preg_replace('/[^0-9]/', '', $_SESSION['cd_empresa'] ?? '');

$baseDir =
    __DIR__ .
    '/../../fiscal/' .
    $cd_empresa;

$xmlDir =
    $baseDir .
    DIRECTORY_SEPARATOR .
    'fiscal' .
    DIRECTORY_SEPARATOR .
    'nfse' .
    DIRECTORY_SEPARATOR .
    'xml';

/*
|--------------------------------------------------------------------------
| VISUALIZAR NFS-e
|--------------------------------------------------------------------------
*/

if (isset($_GET['arquivo'])) {

    $arquivoNome = basename($_GET['arquivo']);

    $caminhoCompleto =
        $xmlDir .
        DIRECTORY_SEPARATOR .
        $arquivoNome;

    if (
        !file_exists($caminhoCompleto) ||
        pathinfo($caminhoCompleto, PATHINFO_EXTENSION) !== 'xml'
    ) {

        die("
            <h3>
                Arquivo XML não encontrado ou inválido.
            </h3>

            <a href='listar_nfse.php'>
                Voltar
            </a>
        ");
    }

    libxml_use_internal_errors(true);

    $xmlData = simplexml_load_file($caminhoCompleto);

    if ($xmlData === false) {

        die("
            <h3>
                Erro ao ler XML.
            </h3>

            <a href='listar_nfse.php'>
                Voltar
            </a>
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | FUNÇÃO AUXILIAR
    |--------------------------------------------------------------------------
    */

    $buscarTag = function ($tag) use ($xmlData) {

        $resultado =
            $xmlData->xpath(
                "//*[local-name()='{$tag}']"
            );

        return !empty($resultado)
            ? (string)$resultado[0]
            : 'N/A';
    };

    /*
    |--------------------------------------------------------------------------
    | DADOS
    |--------------------------------------------------------------------------
    */

    $numeroNFSe =
        $buscarTag('nNFSe') !== 'N/A'
            ? $buscarTag('nNFSe')
            : $buscarTag('numero');

    $chaveAcesso =
        $buscarTag('chNFSe') !== 'N/A'
            ? $buscarTag('chNFSe')
            : $buscarTag('chaveAcesso');

    $dataEmissao =
        $buscarTag('dhEmi') !== 'N/A'
            ? $buscarTag('dhEmi')
            : $buscarTag('dataEmissao');

    if (
        $dataEmissao !== 'N/A' &&
        strtotime($dataEmissao)
    ) {

        $dataEmissao =
            date(
                'd/m/Y H:i:s',
                strtotime($dataEmissao)
            );
    }

    $cnpjPrestador =
        $buscarTag('cnpj');

    $cpfTomador =
        $buscarTag('cpf');

    $descricaoServ =
        $buscarTag('descricao');

    $valorServicos =
        $buscarTag('valorServicos');

    /*
    |--------------------------------------------------------------------------
    | CANCELAMENTO
    |--------------------------------------------------------------------------
    */

    $statusNFSe =
        strtoupper(
            trim(
                $buscarTag('status_nfse')
            )
        );

    $cancelada = false;

    if (
        strpos($statusNFSe, 'CANCEL') !== false
    ) {

        $cancelada = true;
    }

    /*
    |--------------------------------------------------------------------------
    | LINK CONSULTA
    |--------------------------------------------------------------------------
    |
    | Ajuste conforme prefeitura/portal
    |--------------------------------------------------------------------------
    */


    /*
|--------------------------------------------------------------------------
| CHAVE NFS-e PADRÃO NACIONAL
|--------------------------------------------------------------------------
*/

$codigoMunicipio = '3304557'; // IBGE Rio de Janeiro
$ambiente        = '2'; // 1=municipal | 2=ADN Nacional
$tipoInscricao   = '2'; // 1=CPF | 2=CNPJ

$cnpjLimpo =
    str_pad(
        preg_replace('/\D/', '', $cnpjPrestador),
        14,
        '0',
        STR_PAD_LEFT
    );

/*
|--------------------------------------------------------------------------
| NÚMERO NFS-e
|--------------------------------------------------------------------------
|
| 13 posições
|
|--------------------------------------------------------------------------
*/

$numeroNFSeFormatado =
    str_pad(
        preg_replace('/\D/', '', $numeroNFSe),
        13,
        '0',
        STR_PAD_LEFT
    );

/*
|--------------------------------------------------------------------------
| ANO/MÊS
|--------------------------------------------------------------------------
*/

$anoMes =
    date('ym');

/*
|--------------------------------------------------------------------------
| CÓDIGO NUMÉRICO
|--------------------------------------------------------------------------
|
| 9 dígitos aleatórios
|
|--------------------------------------------------------------------------
*/

$codigoNumerico =
    str_pad(
        rand(0, 999999999),
        9,
        '0',
        STR_PAD_LEFT
    );

/*
|--------------------------------------------------------------------------
| CHAVE BASE
|--------------------------------------------------------------------------
|
| Sem DV
|
|--------------------------------------------------------------------------
*/

$chaveSemDV =
      $codigoMunicipio
    . $ambiente
    . $tipoInscricao
    . $cnpjLimpo
    . $numeroNFSeFormatado
    . $anoMes
    . $codigoNumerico;

/*
|--------------------------------------------------------------------------
| DV MOD11
|--------------------------------------------------------------------------
*/

function gerarDV($chave){

    $multiplicador = 2;
    $soma = 0;

    for(
        $i = strlen($chave) - 1;
        $i >= 0;
        $i--
    ){

        $soma +=
            intval($chave[$i]) *
            $multiplicador;

        $multiplicador++;

        if($multiplicador > 9){
            $multiplicador = 2;
        }
    }

    $resto = $soma % 11;

    $dv = 11 - $resto;

    if($dv >= 10){
        $dv = 0;
    }

    return $dv;
}

/*
|--------------------------------------------------------------------------
| CHAVE FINAL 44 DÍGITOS
|--------------------------------------------------------------------------
*/

$dv =
    gerarDV($chaveSemDV);

$chaveAcesso =
    $chaveSemDV . $dv;

/*
|--------------------------------------------------------------------------
| URL CONSULTA
|--------------------------------------------------------------------------
*/

$urlConsulta =
    'https://www.nfse.gov.br/consultapublica?chave=' .
    $chaveAcesso .
    '&tpc=1';


    //$urlConsulta =
    //  'https://www.nfse.gov.br/ConsultaPublica?tpc=1&chave='.$chaveAcesso;
    //  'https://www.nfse.gov.br/ConsultaPublica?tpc=1&chave=33045572228856198000129000000000025026032729210348';
        

    /*
    |--------------------------------------------------------------------------
    | QR CODE
    |--------------------------------------------------------------------------
    */

    $qrCodeUrl =
        'https://chart.googleapis.com/chart?chs=220x220&cht=qr&chl=' .
        urlencode($urlConsulta);

    ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        NFS-e <?php echo htmlspecialchars($numeroNFSe); ?>
    </title>

    <style>

        *{
            box-sizing:border-box;
        }

        body{

            margin:0;
            padding:15px;

            background:#e9ecef;

            font-family:
                'Courier New',
                Courier,
                monospace;
        }

        .recibo{

            width:100%;
            max-width:380px;

            margin:auto;

            background:#fff;

            padding:18px;

            position:relative;

            box-shadow:
                0 0 15px rgba(0,0,0,0.15);

            overflow:hidden;
        }

        .marca-cancelada{

            position:absolute;

            top:45%;

            left:-20px;

            width:140%;

            text-align:center;

            font-size:42px;

            font-weight:bold;

            color:rgba(255,0,0,0.12);

            transform:rotate(-25deg);

            z-index:1;

            pointer-events:none;
        }

        .conteudo{

            position:relative;

            z-index:2;
        }

        h2{

            margin:0 0 15px 0;

            text-align:center;

            font-size:24px;
        }

        .status{

            margin-bottom:15px;

            text-align:center;

            font-size:14px;

            font-weight:bold;

            padding:8px;

            border-radius:4px;
        }

        .status-ok{

            background:#d4edda;

            color:#155724;
        }

        .status-cancelada{

            background:#f8d7da;

            color:#721c24;
        }

        .info{

            margin-bottom:10px;

            word-break:break-word;

            font-size:14px;
        }

        .info strong{

            display:block;

            margin-bottom:3px;
        }

        hr{

            border:none;

            border-top:1px dashed #000;

            margin:12px 0;
        }

        .valor{

            text-align:right;

            font-size:22px;

            font-weight:bold;
        }

        .qr{

            text-align:center;

            margin-top:20px;
        }

        .qr img{

            width:160px;
            height:160px;
        }

        .consulta-link{

            text-align:center;

            margin-top:10px;

            font-size:12px;

            word-break:break-all;
        }

        .consulta-link a{

            color:#000;
        }

        .acoes{

            margin-top:20px;
        }

        .btn{

            display:block;

            width:100%;

            border:none;

            border-radius:5px;

            padding:14px;

            margin-bottom:10px;

            font-size:15px;

            font-weight:bold;

            cursor:pointer;

            text-decoration:none;

            text-align:center;
        }

        .btn-imprimir{

            background:#000;
            color:#fff;
        }

        .btn-cancelar{

            background:#dc3545;
            color:#fff;
        }

        .btn-voltar{

            background:#6c757d;
            color:#fff;
        }

        .btn:hover{

            opacity:0.92;
        }

        @media(max-width:480px){

            body{
                padding:5px;
            }

            .recibo{

                max-width:100%;

                padding:14px;
            }

            h2{
                font-size:20px;
            }

            .valor{
                font-size:20px;
            }

            .marca-cancelada{

                font-size:32px;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | IMPRESSÃO TÉRMICA
        |--------------------------------------------------------------------------
        */

        @media print{

            @page{
                margin:0;
            }

            body{

                background:#fff;

                margin:0;
                padding:0;
            }

            .recibo{

                width:80mm;
                max-width:80mm;

                box-shadow:none;

                margin:0;

                padding:2mm;
            }

            .acoes{

                display:none !important;
            }

            .marca-cancelada{

                color:rgba(255,0,0,0.20);

                font-size:38px;
            }
        }

    </style>

</head>

<body>

    <div class="recibo">

        <?php if ($cancelada): ?>

            <div class="marca-cancelada">
                CANCELADA
            </div>

        <?php endif; ?>

        <div class="conteudo">

            <h2>
                NFS-e
            </h2>

            <?php if ($cancelada): ?>

                <div class="status status-cancelada">
                    ❌ NOTA FISCAL CANCELADA
                </div>

            <?php else: ?>

                <div class="status status-ok">
                    ✅ NFS-e AUTORIZADA
                </div>

            <?php endif; ?>

            <div class="info">
                <strong>Número:</strong>
                <?php echo htmlspecialchars($numeroNFSe); ?>
            </div>

            <div class="info">
                <strong>Chave de Acesso:</strong>
                <?php echo htmlspecialchars($chaveAcesso); ?>
            </div>

            <div class="info">
                <strong>Data Emissão:</strong>
                <?php echo htmlspecialchars($dataEmissao); ?>
            </div>

            <hr>

            <div class="info">
                <strong>CNPJ Prestador:</strong>
                <?php echo htmlspecialchars($cnpjPrestador); ?>
            </div>

            <div class="info">
                <strong>CPF/CNPJ Tomador:</strong>
                <?php echo htmlspecialchars($cpfTomador); ?>
            </div>

            <hr>

            <div class="info">
                <strong>Descrição:</strong>
                <?php echo nl2br(htmlspecialchars($descricaoServ)); ?>
            </div>

            <hr>

            <div class="valor">
                R$
                <?php echo htmlspecialchars($valorServicos); ?>
            </div>

            <div class="qr">

                <img
                    src="<?php echo $qrCodeUrl; ?>"
                    alt="QR Code"
                >

            </div>

            <div class="consulta-link">

                Consulte a autenticidade:

                <br>

                <a
                    href="<?php echo $urlConsulta; ?>"
                    target="_blank"
                >
                    <?php echo $urlConsulta; ?>
                </a>

            </div>

            <div class="acoes">

                <button
                    class="btn btn-imprimir"
                    onclick="window.print();"
                >
                    🖨️ IMPRIMIR
                </button>

                <?php if (!$cancelada): ?>

                    <button
                        class="btn btn-cancelar"
                        onclick="
                            if(confirm('Deseja cancelar esta NFS-e?')){

                                window.location.href =
                                'nfse_cancela.php?numero_nfse=<?php echo urlencode($numeroNFSe); ?>';
                            }
                        "
                    >
                        ❌ CANCELAR NFS-e
                    </button>

                <?php endif; ?>

                <a
                    href="listar_nfse.php"
                    class="btn btn-voltar"
                >
                    ⬅ VOLTAR
                </a>

            </div>

        </div>

    </div>

</body>

</html>

<?php
    exit;
}

/*
|--------------------------------------------------------------------------
| LISTAGEM
|--------------------------------------------------------------------------
*/

$arquivosXML = [];

if (is_dir($xmlDir)) {

    $arquivosXML =
        glob(
            $xmlDir .
            DIRECTORY_SEPARATOR .
            '*.xml'
        );

    if (!empty($arquivosXML)) {

        array_multisort(

            array_map(
                'filemtime',
                $arquivosXML
            ),

            SORT_DESC,

            $arquivosXML
        );
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Gerenciador NFS-e
    </title>

    <style>

        body{

            margin:0;
            padding:10px;

            background:#f5f5f5;

            font-family:Arial;
        }

        .container{

            max-width:1000px;

            margin:auto;

            background:#fff;

            padding:20px;

            border-radius:8px;

            box-shadow:
                0 2px 10px rgba(0,0,0,0.1);
        }

        h2{

            margin-top:0;
        }

        .table-responsive{

            overflow:auto;
        }

        table{

            width:100%;

            border-collapse:collapse;
        }

        th, td{

            padding:12px;

            border-bottom:1px solid #ddd;

            text-align:left;
        }

        th{

            background:#f1f1f1;
        }

        .btn-ver{

            display:inline-block;

            background:#28a745;

            color:#fff;

            text-decoration:none;

            padding:8px 14px;

            border-radius:4px;
        }

        .btn-ver:hover{

            background:#218838;
        }

    </style>

</head>

<body>

<div class="container">

    <h2>
        📄 Notas Fiscais XML
    </h2>

    <?php if (empty($arquivosXML)): ?>

        <p>
            Nenhuma NFS-e encontrada.
        </p>

    <?php else: ?>

        <div class="table-responsive">

            <table>

                <thead>

                    <tr>

                        <th>
                            Arquivo
                        </th>

                        <th>
                            Data
                        </th>

                        <th>
                            Ação
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($arquivosXML as $arquivo):

                        $nomeArquivo =
                            basename($arquivo);

                        $dataArquivo =
                            date(
                                'd/m/Y H:i',
                                filemtime($arquivo)
                            );

                    ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($nomeArquivo); ?>
                        </td>

                        <td>
                            <?php echo $dataArquivo; ?>
                        </td>

                        <td>

                            <a
                                class="btn-ver"
                                href="
                                listar_nfse.php?arquivo=<?php echo urlencode($nomeArquivo); ?>
                                "
                            >
                                Visualizar
                            </a>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</div>

</body>

</html>