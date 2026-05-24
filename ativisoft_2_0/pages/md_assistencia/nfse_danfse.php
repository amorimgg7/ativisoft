<?php
session_start();

date_default_timezone_set('America/Sao_Paulo');

header('Content-Type: text/html; charset=UTF-8');

/*
|--------------------------------------------------------------------------
| VALIDA PARÂMETRO
|--------------------------------------------------------------------------
*/
if (!isset($_GET['arquivo'])) {

    die('Arquivo não informado.');
}

/*
|--------------------------------------------------------------------------
| DIRETÓRIO BASE
|--------------------------------------------------------------------------
*/
$cd_empresa = preg_replace(
    '/[^0-9]/',
    '',
    $_SESSION['cd_empresa']
);

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
| ARQUIVO
|--------------------------------------------------------------------------
*/
$arquivoNome = basename($_GET['arquivo']);

$caminhoCompleto =
    $xmlDir .
    DIRECTORY_SEPARATOR .
    $arquivoNome;

if (
    !file_exists($caminhoCompleto) ||
    pathinfo($caminhoCompleto, PATHINFO_EXTENSION) !== 'xml'
) {

    die('XML não encontrado.');
}

/*
|--------------------------------------------------------------------------
| CARREGA XML
|--------------------------------------------------------------------------
*/
libxml_use_internal_errors(true);

$xmlData = simplexml_load_file($caminhoCompleto);

if ($xmlData === false) {

    die('Erro ao ler XML.');
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
        ? trim((string)$resultado[0])
        : '';
};

/*
|--------------------------------------------------------------------------
| DADOS
|--------------------------------------------------------------------------
*/
$numeroNFSe =
    $buscarTag('nNFSe');

if (empty($numeroNFSe)) {

    $numeroNFSe =
        $buscarTag('numero');
}

$chaveAcesso =
    $buscarTag('chNFSe');

if (empty($chaveAcesso)) {

    $chaveAcesso =
        $buscarTag('chaveAcesso');
}

$dataEmissao =
    $buscarTag('dhEmi');

if (empty($dataEmissao)) {

    $dataEmissao =
        $buscarTag('dataEmissao');
}

if (!empty($dataEmissao)) {

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

$descricaoServico =
    $buscarTag('descricao');

$valorServicos =
    $buscarTag('valorServicos');

$statusNota =
    strtoupper(
        $buscarTag('status_nfse')
    );

$cancelada =
    (
        strpos($statusNota, 'CANCEL') !== false
    );

/*
|--------------------------------------------------------------------------
| LINK CONSULTA PÚBLICA
|--------------------------------------------------------------------------
*/
$linkConsulta =
    'https://www.nfse.gov.br/consultapublica?tpc=1&chave=' .
    urlencode($chaveAcesso);

/*
|--------------------------------------------------------------------------
| QR CODE
|--------------------------------------------------------------------------
*/
$qrcode =
    'https://chart.googleapis.com/chart?chs=220x220&cht=qr&chl=' .
    urlencode($linkConsulta);

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
        DANFSE
    </title>

    <style>

        body{

            margin:0;
            padding:10px;
            background:#efefef;

            font-family:
                Arial,
                sans-serif;
        }

        .danfse{

            width:100%;
            max-width:820px;

            margin:auto;

            background:#fff;

            border:1px solid #000;

            position:relative;

            overflow:hidden;
        }

        .watermark{

            position:absolute;

            top:40%;

            left:50%;

            transform:
                translate(-50%, -50%)
                rotate(-30deg);

            font-size:80px;

            color:rgba(255,0,0,0.12);

            font-weight:bold;

            z-index:1;

            white-space:nowrap;
        }

        .conteudo{

            position:relative;

            z-index:2;
        }

        .topo{

            display:flex;

            justify-content:space-between;

            align-items:flex-start;

            border-bottom:2px solid #000;

            padding:15px;
        }

        .empresa{

            width:70%;
        }

        .empresa h2{

            margin:0 0 5px 0;

            font-size:22px;
        }

        .empresa p{

            margin:3px 0;

            font-size:13px;
        }

        .nfse-box{

            width:220px;

            border:1px solid #000;

            text-align:center;

            padding:10px;
        }

        .nfse-box h3{

            margin:0;

            font-size:20px;
        }

        .nfse-box .numero{

            font-size:28px;

            font-weight:bold;

            margin-top:10px;
        }

        .secao{

            padding:15px;

            border-bottom:1px solid #ccc;
        }

        .titulo{

            font-size:15px;

            font-weight:bold;

            margin-bottom:10px;

            text-transform:uppercase;
        }

        .linha{

            display:flex;

            flex-wrap:wrap;

            margin-bottom:10px;
        }

        .campo{

            flex:1;

            min-width:220px;

            margin-right:10px;

            margin-bottom:10px;
        }

        .campo strong{

            display:block;

            font-size:12px;

            margin-bottom:4px;
        }

        .campo span{

            font-size:14px;
        }

        .valor-total{

            font-size:26px;

            font-weight:bold;

            text-align:right;

            color:#000;
        }

        .rodape{

            padding:20px;

            text-align:center;
        }

        .rodape img{

            width:180px;
        }

        .consulta-link{

            margin-top:10px;

            word-break:break-all;

            font-size:12px;
        }

        .acoes{

            max-width:820px;

            margin:15px auto;

            text-align:center;
        }

        .btn{

            display:inline-block;

            padding:12px 20px;

            margin:5px;

            border:none;

            border-radius:5px;

            text-decoration:none;

            cursor:pointer;

            font-size:15px;

            font-weight:bold;
        }

        .btn-print{

            background:#000;

            color:#fff;
        }

        .btn-voltar{

            background:#007bff;

            color:#fff;
        }

        @media(max-width:768px){

            .topo{

                flex-direction:column;
            }

            .empresa{

                width:100%;
            }

            .nfse-box{

                width:100%;

                margin-top:15px;
            }

            .watermark{

                font-size:45px;
            }

            .valor-total{

                text-align:left;
            }
        }

        @media print{

            @page{

                margin:8mm;
            }

            body{

                background:#fff;

                padding:0;
            }

            .acoes{

                display:none;
            }

            .danfse{

                border:none;
            }
        }

    </style>

</head>

<body>

    <div class="acoes">

        <button
            class="btn btn-print"
            onclick="window.print();"
        >
            🖨️ IMPRIMIR DANFSE
        </button>

        <a
            href="listar_nfse.php"
            class="btn btn-voltar"
        >
            ← VOLTAR
        </a>

    </div>

    <div class="danfse">

        <?php if($cancelada){ ?>

            <div class="watermark">
                CANCELADA
            </div>

        <?php } ?>

        <div class="conteudo">

            <div class="topo">

                <div class="empresa">

                    <h2>
                        DOCUMENTO AUXILIAR DA NFS-e
                    </h2>

                    <p>
                        Documento gerado eletronicamente
                    </p>

                    <p>
                        Consulte autenticidade pelo portal nacional
                    </p>

                </div>

                <div class="nfse-box">

                    <h3>NFS-e</h3>

                    <div class="numero">
                        <?php echo htmlspecialchars($numeroNFSe); ?>
                    </div>

                    <hr>

                    <strong>Emissão</strong>

                    <div>
                        <?php echo htmlspecialchars($dataEmissao); ?>
                    </div>

                </div>

            </div>

            <div class="secao">

                <div class="titulo">
                    Prestador do Serviço
                </div>

                <div class="linha">

                    <div class="campo">

                        <strong>
                            CNPJ
                        </strong>

                        <span>
                            <?php echo htmlspecialchars($cnpjPrestador); ?>
                        </span>

                    </div>

                </div>

            </div>

            <div class="secao">

                <div class="titulo">
                    Tomador do Serviço
                </div>

                <div class="linha">

                    <div class="campo">

                        <strong>
                            CPF/CNPJ
                        </strong>

                        <span>
                            <?php echo htmlspecialchars($cpfTomador); ?>
                        </span>

                    </div>

                </div>

            </div>

            <div class="secao">

                <div class="titulo">
                    Serviço Prestado
                </div>

                <div class="linha">

                    <div class="campo">

                        <strong>
                            Descrição
                        </strong>

                        <span>
                            <?php echo nl2br(htmlspecialchars($descricaoServico)); ?>
                        </span>

                    </div>

                </div>

            </div>

            <div class="secao">

                <div class="titulo">
                    Valores
                </div>

                <div class="valor-total">

                    R$
                    <?php echo number_format(
                        (float)$valorServicos,
                        2,
                        ',',
                        '.'
                    ); ?>

                </div>

            </div>

            <div class="rodape">

                <img
                    src="<?php echo $qrcode; ?>"
                    alt="QR Code"
                >

                <div class="consulta-link">

                    <strong>
                        Consulta Pública:
                    </strong>

                    <br>

                    <a
                        href="<?php echo htmlspecialchars($linkConsulta); ?>"
                        target="_blank"
                    >
                        <?php echo htmlspecialchars($linkConsulta); ?>
                    </a>

                </div>

                <br>

                <div>

                    <strong>
                        Chave de Acesso
                    </strong>

                    <br>

                    <?php echo htmlspecialchars($chaveAcesso); ?>

                </div>

            </div>

        </div>

    </div>

</body>
</html>