<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv='refresh' content='2000'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dados do Sistema</title>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Informações em Memória</h2>
            </div>
        </div>

        <?php
            session_start();
            ksort($_SESSION); // ordena as chaves em ordem alfabética

            echo '<pre>';
            print_r($_SESSION);
            echo '</pre>';

        ?>
    </div>
</body>