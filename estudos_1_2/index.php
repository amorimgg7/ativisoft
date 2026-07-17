<?php

$simulados = [];

foreach (glob('dados/*.json') as $arquivo)
{
    if (basename($arquivo) === 'simulados.json') {
        continue;
    }

    $perguntas = json_decode(
        file_get_contents($arquivo),
        true
    );

    if (!is_array($perguntas)) {
        continue;
    }

    $total = count($perguntas);

    $nomeArquivo =
        pathinfo(
            basename($arquivo),
            PATHINFO_FILENAME
        );

    $titulo =
        ucwords(
            str_replace(
                '_',
                ' → ',
                $nomeArquivo
            )
        );

    $simulados[] = [
        'id' => $nomeArquivo,
        'titulo' => $titulo,
        'total_perguntas' => $total,
        'tempo_minutos' => max(10, $total),
        'questoes_por_prova' => $total
    ];
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Simulados ITF</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">

    <h1>🥋 Simulados Taekwon-Do ITF</h1>

    <?php if (empty($simulados)): ?>

        <div class="card">
            Nenhum simulado encontrado.
        </div>

    <?php endif; ?>

    <?php foreach ($simulados as $s): ?>

        <div class="card">

            <h2>
                <?= htmlspecialchars($s['titulo']) ?>
            </h2>

            <p>
                📚
                <?= $s['total_perguntas'] ?>
                questões
            </p>

            <p>
                ⏱️
                <?= $s['tempo_minutos'] ?>
                minutos
            </p>

            <a
                class="btn"
                href="iniciar.php?id=<?= urlencode($s['id']) ?>"
            >
                Iniciar
            </a>

        </div>

    <?php endforeach; ?>

</div>

</body>
</html>