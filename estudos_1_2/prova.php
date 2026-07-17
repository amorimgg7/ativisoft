<?php
session_start();

if (!isset($_SESSION['prova'])) {
    header('Location:index.php');
    exit;
}

$indice = $_SESSION['indice'];

if ($indice >= count($_SESSION['prova'])) {
    header('Location:resultado.php');
    exit;
}

$questao = $_SESSION['prova'][$indice];


// ===============================
// NOME DO SIMULADO PELO JSON
// ===============================

function gerarNomeSimulado()
{
    if (!isset($_SESSION['arquivo_simulado'])) {
        return "Simulado Taekwon-Do";
    }

    $nomeArquivo = $_SESSION['arquivo_simulado'];

    // remove extensão .json
    $nomeArquivo = str_replace(".json", "", $nomeArquivo);

    // separa por _
    $faixas = explode("_", $nomeArquivo);

    // primeira letra maiúscula
    foreach ($faixas as &$faixa) {
        $faixa = ucfirst(strtolower($faixa));
    }

    return "Simulado (" . implode(" → ", $faixas) . ")";
}


$nomeSimulado = gerarNomeSimulado();


// ===============================
// EMBARALHAR OPÇÕES MANTENDO A CORRETA
// ===============================

$opcoesEmbaralhadas = [];

foreach ($questao['opcoes'] as $index => $texto) {

    $opcoesEmbaralhadas[] = [
        "indice_original" => $index,
        "texto" => $texto
    ];

}

shuffle($opcoesEmbaralhadas);

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Simulado</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="container">

    <div class="card">


        <h1 class="titulo-simulado">
            <?= htmlspecialchars($nomeSimulado) ?>
        </h1>


        <h2>
            Pergunta <?= $indice + 1 ?>
            de <?= count($_SESSION['prova']) ?>
        </h2>


        <div class="categoria">
            <?= htmlspecialchars($questao['categoria']) ?>
        </div>


        <h3>
            <?= htmlspecialchars($questao['pergunta']) ?>
        </h3>


        <form action="resultado.php" method="post">


            <?php foreach ($opcoesEmbaralhadas as $opcao): ?>

                <label class="opcao">

                    <input
                        type="radio"
                        name="resposta"
                        value="<?= $opcao['indice_original'] ?>"
                        required
                    >

                    <?= htmlspecialchars($opcao['texto']) ?>

                </label>


            <?php endforeach; ?>


            <button class="btn">
                Próxima
            </button>


        </form>


    </div>

</div>

</body>
</html>