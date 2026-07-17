<?php
require 'functions.php';

$simulados = carregarSimulados();
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Administração - Simulados</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">

    <div class="topo">
        <h1>🥋 Administração de Simulados</h1>

        <a class="btn" href="?novo=1">
            + Novo Simulado
        </a>
    </div>

    <?php if (isset($_GET['novo'])): ?>

        <div class="card">

            <h2>Novo Simulado</h2>

            <form method="post"
                  action="salvar_simulado.php">

                <div class="form-group">
                    <label>titulo</label>

                    <input
                        type="text"
                        name="titulo"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>ID</label>

                    <input
                        type="text"
                        name="id"
                        placeholder="ex: vermelha_preta"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Questões por prova</label>

                    <input
                        type="number"
                        name="total_perguntas"
                        value="20"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Tempo (min)</label>

                    <input
                        type="number"
                        name="tempo"
                        value="30"
                        required
                    >
                </div>

                <button class="btn">
                    Salvar Simulado
                </button>

            </form>

        </div>

    <?php endif; ?>

    <?php foreach ($simulados as $s): ?>

        <div class="card">

            <h2><?= $s['titulo'] ?></h2>

            <div class="info">
                <span>📚 <?= $s['total_perguntas'] ?> perguntas</span>
                <span>⏱️ <?= $s['tempo_minutos'] ?> min</span>
                <span>📝 <?= $s['total_perguntas'] ?> por prova</span>
            </div>

            <div class="acoes">
                <a class="btn" href="perguntas.php?id=<?= $s['id'] ?>">
                    Perguntas
                </a>

                <a class="btn btn-danger"
                   onclick="return confirm('Excluir simulado?')"
                   href="excluir_simulado.php?id=<?= $s['id'] ?>">
                    Excluir
                </a>
            </div>

        </div>

    <?php endforeach; ?>

    

</div>

</body>
</html>