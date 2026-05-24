<?php
session_start();

date_default_timezone_set('America/Sao_Paulo');

require_once '../../classes/conn.php';

header('Content-Type: text/html; charset=UTF-8');

/*
|--------------------------------------------------------------------------
| VALIDA NÚMERO DA NFS-e
|--------------------------------------------------------------------------
*/
$numero_nfse = $_GET['numero_nfse'] ?? '';

$numero_nfse = trim($numero_nfse);

if (empty($numero_nfse)) {

    die('Número da NFS-e não informado.');
}

/*
|--------------------------------------------------------------------------
| BUSCA DADOS
|--------------------------------------------------------------------------
*/
$sql = "
    SELECT *
    FROM tb_dados_nfse
    WHERE numero_nfse = ?
    LIMIT 1
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "s",
    $numero_nfse
);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows <= 0) {

    die('NFS-e não encontrada.');
}

$row = $result->fetch_assoc();

/*
|--------------------------------------------------------------------------
| CANCELAR
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $motivo = trim($_POST['motivo_cancelamento'] ?? '');

    if (empty($motivo)) {

        $erro = 'Informe o motivo do cancelamento.';

    } else {

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */
        $sqlUpdate = "
            UPDATE tb_dados_nfse
            SET
                cancelada = 1,
                status_nfse = 'CANCELADA',
                data_cancelamento = NOW(),
                motivo_cancelamento = ?,
                dt_atualizacao = NOW()
            WHERE id_nfse = ?
        ";

        $stmtUpdate = $conn->prepare($sqlUpdate);

        $stmtUpdate->bind_param(
            "si",
            $motivo,
            $row['id_nfse']
        );

        if ($stmtUpdate->execute()) {

            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>

                <meta charset="UTF-8">

                <meta
                    name="viewport"
                    content="width=device-width, initial-scale=1.0"
                >

                <title>NFS-e Cancelada</title>

                <style>

                    *{
                        box-sizing:border-box;
                    }

                    body{

                        margin:0;
                        padding:20px;

                        background:#f5f5f5;

                        font-family:Arial,sans-serif;

                        display:flex;
                        justify-content:center;
                        align-items:center;

                        min-height:100vh;
                    }

                    .card{

                        background:#fff;

                        width:100%;
                        max-width:500px;

                        padding:30px;

                        border-radius:12px;

                        box-shadow:0 0 15px rgba(0,0,0,0.1);

                        text-align:center;
                    }

                    h1{

                        color:#dc3545;

                        margin-top:0;
                    }

                    .numero{

                        font-size:22px;
                        font-weight:bold;

                        margin:20px 0;

                        color:#333;
                    }

                    .contador{

                        font-size:60px;
                        font-weight:bold;

                        color:#007bff;

                        margin-top:20px;
                    }

                    .info{

                        margin-top:15px;

                        color:#666;
                    }

                    @media(max-width:600px){

                        .card{

                            padding:20px;
                        }

                        .contador{

                            font-size:45px;
                        }
                    }

                </style>

            </head>

            <body>

                <div class="card">

                    <h1>❌ NFS-e Cancelada</h1>

                    <div class="numero">
                        Nº <?php echo htmlspecialchars($numero_nfse); ?>
                    </div>

                    <div class="info">
                        Redirecionando automaticamente...
                    </div>

                    <div
                        class="contador"
                        id="contador"
                    >
                        5
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

                    },1000);

                </script>

            </body>
            </html>
            <?php

            exit;

        } else {

            $erro = 'Erro ao cancelar a NFS-e.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cancelar NFS-e</title>

    <style>

        *{
            box-sizing:border-box;
        }

        body{

            margin:0;
            padding:20px;

            background:#f5f5f5;

            font-family:Arial,sans-serif;
        }

        .container{

            width:100%;
            max-width:600px;

            margin:auto;

            background:#fff;

            padding:30px;

            border-radius:12px;

            box-shadow:0 0 15px rgba(0,0,0,0.1);
        }

        h1{

            margin-top:0;

            color:#dc3545;
        }

        .grupo{

            margin-bottom:20px;
        }

        label{

            display:block;

            margin-bottom:8px;

            font-weight:bold;
        }

        textarea{

            width:100%;

            min-height:140px;

            resize:vertical;

            padding:12px;

            border:1px solid #ccc;

            border-radius:6px;

            font-size:15px;
        }

        .dados{

            background:#f8f8f8;

            padding:15px;

            border-radius:6px;

            margin-bottom:20px;

            line-height:1.7;
        }

        .btn{

            width:100%;

            border:none;

            padding:15px;

            border-radius:6px;

            cursor:pointer;

            font-size:16px;

            font-weight:bold;
        }

        .btn-cancelar{

            background:#dc3545;

            color:#fff;
        }

        .btn-cancelar:hover{

            background:#c82333;
        }

        .erro{

            background:#ffe5e5;

            color:#b00000;

            padding:12px;

            border-radius:6px;

            margin-bottom:20px;
        }

        @media(max-width:600px){

            .container{

                padding:20px;
            }
        }

    </style>

</head>

<body>

    <div class="container">

        <h1>Cancelar NFS-e</h1>

        <?php if(!empty($erro)){ ?>

            <div class="erro">

                <?php echo htmlspecialchars($erro); ?>

            </div>

        <?php } ?>

        <div class="dados">

            <strong>Número:</strong>
            <?php echo htmlspecialchars($row['numero_nfse']); ?>
            <br>

            <strong>Protocolo:</strong>
            <?php echo htmlspecialchars($row['protocolo']); ?>
            <br>

            <strong>Valor:</strong>
            R$
            <?php echo number_format($row['valor_total'],2,',','.'); ?>
            <br>

            <strong>Status:</strong>
            <?php echo htmlspecialchars($row['status_nfse']); ?>

        </div>

        <form method="POST">

            <div class="grupo">

                <label>
                    Motivo do cancelamento
                </label>

                <textarea
                    name="motivo_cancelamento"
                    required
                ></textarea>

            </div>

            <button
                type="submit"
                class="btn btn-cancelar"
            >
                ❌ CONFIRMAR CANCELAMENTO
            </button>

        </form>

    </div>

</body>
</html>