<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. VERIFICA SE A PROVA FOI INICIADA
if (!isset($_SESSION['prova']) || empty($_SESSION['prova'])) {
    header('Location: index.php');
    exit;
}

// 2. CARREGA CONFIGURAÇÕES DO USUÁRIO (TEMA E PARÂMETROS)
$email_raw = $_SESSION['email'] ?? ($_SESSION['google_id'] ?? 'visitante');
$email_proprietario = preg_replace('/[^a-zA-Z0-9_@.-]/', '_', $email_raw);
$config_file = "dados/" . $email_proprietario . "/config.json";

$tema_ativo = "light";
$tempo_padrao_minutos = 30;

if (file_exists($config_file)) {
    $user_config = json_decode(file_get_contents($config_file), true);
    $tema_ativo = $user_config['configuracoes']['tema'] ?? 'light';
    $tempo_padrao_minutos = $user_config['configuracoes']['tempo_padrao_minutos'] ?? 30;
    $questoes_por_prova = $user_config['configuracoes']['questoes_por_prova'] ?? 5;
    $_SESSION['quantidadeQuestoes'] = $questoes_por_prova;
}

// 3. CONFIGURAÇÃO DE TEMPO DA PROVA
// Utiliza o tempo definido na sessão (via iniciar.php) ou o padrão do usuário
$tempoTotalSegundos = ($_SESSION['tempo_minutos'] ?? $tempo_padrao_minutos) * 60;

if (!isset($_SESSION['inicio_prova'])) {
    $_SESSION['inicio_prova'] = time();
}

$tempoRestante = $tempoTotalSegundos - (time() - $_SESSION['inicio_prova']);

if ($tempoRestante <= 0) {
    header("Location: resultado.php?motivo=tempo_esgotado");
    exit;
}

// 4. ÍNDICE E QUESTÃO ATUAL
$indice = $_SESSION['indice'] ?? 0;
$totalQuestoes = count($_SESSION['prova']);

if ($indice >= $totalQuestoes) {
    header('Location: resultado.php');
    exit;
}

$questao = $_SESSION['prova'][$indice];

// Nome amigável do simulado
function obterNomeSimulado() {
    if (!isset($_SESSION['arquivo_simulado'])) {
        return "Simulado Geral";
    }
    $nome = pathinfo($_SESSION['arquivo_simulado'], PATHINFO_FILENAME);
    $partes = explode("_", $nome);
    $partes = array_map(function($p) { return ucfirst(strtolower($p)); }, $partes);
    return implode(" → ", $partes);
}

$nomeSimulado = obterNomeSimulado();

// 5. EMBARALHAR OPÇÕES MANTENDO ÍNDICE ORIGINAL
$opcoesEmbaralhadas = [];
if (isset($questao['opcoes']) && is_array($questao['opcoes'])) {
    foreach ($questao['opcoes'] as $index => $texto) {
        $opcoesEmbaralhadas[] = [
            "indice_original" => $index,
            "texto" => $texto
        ];
    }
    shuffle($opcoesEmbaralhadas);
}

// Cálculo da porcentagem de progresso
$progressoPorcentagem = round((($indice + 1) / $totalQuestoes) * 100);
$ehUltimaQuestao = ($indice + 1) === $totalQuestoes;
?>

<!doctype html>
<html lang="pt-br" data-bs-theme="<?= htmlspecialchars($tema_ativo) ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($nomeSimulado) ?> - Questão <?= $indice + 1 ?></title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .opcao-item {
            cursor: pointer;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .opcao-item:hover {
            border-color: #0d6efd !important;
        }

        .opcao-item input[type="radio"]:checked + .opcao-texto {
            font-weight: 600;
        }

        .bar-progresso-container {
            height: 6px;
        }
    </style>
</head>

<body class="bg-body-tertiary d-flex flex-column min-vh-100">

    <!-- CABEÇALHO FIXO COM CRONÔMETRO E NOME DO SIMULADO -->
    <header class="sticky-top bg-body border-bottom shadow-sm">
        <div class="container py-2 d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 fs-6">
                    📚 <?= htmlspecialchars($nomeSimulado) ?>
                </span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="fs-5">⏱️</span>
                <span id="cronometro" class="badge bg-success fs-6 px-3 py-2 font-monospace">
                    00:00
                </span>
            </div>
        </div>

        <!-- Barra de Progresso Superior -->
        <div class="progress rounded-0 bar-progresso-container bg-secondary-subtle">
            <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $progressoPorcentagem ?>%;" aria-valuenow="<?= $progressoPorcentagem ?>" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </header>

    <!-- CONTEÚDO PRINCIPAL DA PROVA -->
    <main class="container py-4 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="card shadow-sm border rounded-4 w-100" style="max-width: 800px;">
            <div class="card-body p-4 p-md-5">

                <!-- CABEÇALHO DA QUESTÃO -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-secondary-subtle text-secondary-emphasis border">
                        🏷️ <?= htmlspecialchars($questao['categoria'] ?? 'Geral') ?>
                    </span>
                    <span class="fw-bold text-muted small">
                        Questão <?= $indice + 1 ?> de <?= $totalQuestoes ?>
                    </span>
                </div>

                <!-- ENUNCIADO DA PERGUNTA -->
                <h4 class="fw-bold text-body mb-4 leading-relaxed">
                    <?= htmlspecialchars($questao['pergunta']) ?>
                </h4>

                <!-- FORMULÁRIO DE RESPOSTAS -->
                <form id="formProva" action="resultado.php" method="post">
                    <div class="d-flex flex-column gap-3 mb-4">
                        <?php foreach ($opcoesEmbaralhadas as $i => $opcao): ?>
                            <label class="opcao-item list-group-item d-flex align-items-center p-3 rounded-3 border bg-body">
                                <input class="form-check-input me-3 mt-0 flex-shrink-0" 
                                       type="radio" 
                                       name="resposta" 
                                       id="opcao_<?= $i ?>" 
                                       value="<?= $opcao['indice_original'] ?>" 
                                       required>
                                <span class="opcao-texto text-body">
                                    <?= htmlspecialchars($opcao['texto']) ?>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <!-- BOTÃO DE AÇÃO -->
                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-3 shadow-sm">
                            <?= $ehUltimaQuestao ? '🏁 Finalizar Simulado' : 'Próxima Questão ➡️' ?>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </main>

    <!-- RODAPÉ COMPACTO -->
    <footer class="py-3 bg-body border-top text-center text-muted small">
        <div class="container">
            Plataforma de Simulados &copy; <?= date('Y') ?>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let tempoRestante = <?= (int)$tempoRestante ?>;
        const cronometro = document.getElementById("cronometro");
        const formProva = document.getElementById("formProva");

        function atualizarRelogio() {
            let minutos = Math.floor(tempoRestante / 60);
            let segundos = tempoRestante % 60;

            cronometro.textContent = 
                String(minutos).padStart(2, "0") + ":" + 
                String(segundos).padStart(2, "0");

            // Atualização de cores do cronômetro conforme o tempo restante
            cronometro.classList.remove("bg-success", "bg-warning", "bg-danger", "text-dark");

            if (tempoRestante > 60) {
                cronometro.classList.add("bg-success");
            } else if (tempoRestante > 20) {
                cronometro.classList.add("bg-warning", "text-dark");
            } else {
                cronometro.classList.add("bg-danger");
            }

            if (tempoRestante <= 0) {
                alert("⏰ O tempo acabou! Suas respostas serão enviadas automaticamente.");
                formProva.submit();
                return;
            }

            tempoRestante--;
        }

        // Inicializa e agenda a contagem regressiva
        atualizarRelogio();
        setInterval(atualizarRelogio, 1000);
    </script>
</body>
</html>