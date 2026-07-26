<?php
session_start();

// ===============================
// IDENTIFICAR SIMULADO ESCOLHIDO
// ===============================

if (isset($_GET['id'])) {

    $_SESSION['arquivo_simulado'] = $_GET['id'] . ".json";

}


$id = $_GET['id'] ?? '';

$arquivo = "dados/$id.json";

if (!file_exists($arquivo)) {
    die('Simulado não encontrado.');
}

$perguntas = json_decode(
    file_get_contents($arquivo),
    true
);

if (!$perguntas) {
    die('JSON inválido.');
}

/*
|--------------------------------------------------------------------------
| Embaralha a ordem das perguntas
|--------------------------------------------------------------------------
*/

shuffle($perguntas);

// Quantidade de questões da prova
$_SESSION['quantidadeQuestoes'] = 3;

// Mantém apenas a quantidade desejada
$perguntas = array_slice(
    $perguntas,
    0,
    min($_SESSION['quantidadeQuestoes'], count($perguntas))
);


/*
|--------------------------------------------------------------------------
| Embaralha as alternativas de cada pergunta
|--------------------------------------------------------------------------
*/

foreach ($perguntas as &$q)
{
    $indices = array_keys($q['opcoes']);

    shuffle($indices);

    $novasOpcoes = [];
    $novaCorreta = 0;

    foreach ($indices as $novoIndice => $indiceOriginal)
    {
        $novasOpcoes[] =
            $q['opcoes'][$indiceOriginal];

        if ($indiceOriginal == $q['correta'])
        {
            $novaCorreta = $novoIndice;
        }
    }

    $q['opcoes'] = $novasOpcoes;
    $q['correta'] = $novaCorreta;
}

unset($q);

/*
|--------------------------------------------------------------------------
| Inicia a sessão da prova
|--------------------------------------------------------------------------
*/

$_SESSION['prova'] = $perguntas;
$_SESSION['indice'] = 0;
$_SESSION['acertos'] = 0;
$_SESSION['erros'] = [];

header('Location: prova.php');
exit;