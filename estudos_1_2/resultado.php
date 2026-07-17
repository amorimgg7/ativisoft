<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $indice = $_SESSION['indice'];

    $q = $_SESSION['prova'][$indice];

    $resposta = intval(
        $_POST['resposta']
    );

    if (!isset(
        $_SESSION['categorias'][$q['categoria']]
    )) {
        $_SESSION['categorias'][$q['categoria']] = [
            'acertos'=>0,
            'total'=>0
        ];
    }

    $_SESSION['categorias'][$q['categoria']]['total']++;

    if ($resposta == $q['correta']) {

        $_SESSION['acertos']++;

        $_SESSION['categorias'][$q['categoria']]['acertos']++;
    }
    else {

        $_SESSION['erros'][] = [
            'pergunta'=>$q['pergunta'],
            'resposta'=>$q['opcoes'][$q['correta']],
            'explicacao'=>$q['explicacao']
        ];
    }

    $_SESSION['indice']++;

    header('Location: prova.php');
    exit;
}

if (!isset($_SESSION['prova'])) {
    header('Location:index.php');
    exit;
}

$total = count($_SESSION['prova']);

$acertos = $_SESSION['acertos'];

$percentual =
    round(
        ($acertos/$total)*100,
        1
    );

$nota =
    round(
        ($acertos/$total)*10,
        1
    );
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Resultado</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

<h1>Resultado Final</h1>

<h2><?= $nota ?>/10</h2>

<p>
Acertos:
<?= $acertos ?>
</p>

<p>
Erros:
<?= $total-$acertos ?>
</p>

<p>
Aproveitamento:
<?= $percentual ?>%
</p>

<hr>

<h2>Desempenho por categoria</h2>

<?php foreach ($_SESSION['categorias'] as $titulo=>$c): ?>

<p>

<b><?= $titulo ?></b>

-

<?= round(
($c['acertos']/$c['total'])*100,
1
) ?>%

</p>

<?php endforeach; ?>

<hr>

<h2>Questões Erradas</h2>

<?php foreach ($_SESSION['erros'] as $e): ?>

<div class="erro">

<h3>
<?= $e['pergunta'] ?>
</h3>

<p>

<b>Resposta correta:</b>

<?= $e['resposta'] ?>

</p>

<p>

<b>Explicação:</b>

<?= $e['explicacao'] ?>

</p>

</div>

<?php endforeach; ?>

<a class="btn" href="index.php">
Novo Simulado
</a>

</div>

</body>
</html>

<?php
session_destroy();
?>