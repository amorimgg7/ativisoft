<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. PROCESSA A RESPOSTA ENVIADA VIA POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $indice = $_SESSION['indice'] ?? 0;

    if (isset($_SESSION['prova'][$indice])) {
        $q = $_SESSION['prova'][$indice];
        $resposta = isset($_POST['resposta']) ? intval($_POST['resposta']) : -1;

        if (!isset($_SESSION['categorias'][$q['categoria']])) {
            $_SESSION['categorias'][$q['categoria']] = [
                'acertos' => 0,
                'total'   => 0
            ];
        }

        $_SESSION['categorias'][$q['categoria']]['total']++;

        if ($resposta === intval($q['correta'])) {
            $_SESSION['acertos'] = ($_SESSION['acertos'] ?? 0) + 1;
            $_SESSION['categorias'][$q['categoria']]['acertos']++;
        } else {
            $_SESSION['erros'][] = [
                'pergunta'   => $q['pergunta'],
                'resposta'   => $q['opcoes'][$q['correta']] ?? 'Não informada',
                'explicacao' => $q['explicacao'] ?? 'Sem explicação adicional.'
            ];
        }

        $_SESSION['indice']++;
    }

    header('Location: prova.php');
    exit;
}

// 2. VERIFICA SE EXISTE UMA PROVA EM ANDAMENTO / FINALIZADA
if (!isset($_SESSION['prova']) || empty($_SESSION['prova'])) {
    header('Location: index.php');
    exit;
}

// 3. CARREGA CONFIGURAÇÕES DO USUÁRIO (TEMA ATIVO)
$email_raw = $_SESSION['email'] ?? ($_SESSION['google_id'] ?? 'visitante');
$email_proprietario = preg_replace('/[^a-zA-Z0-9_@.-]/', '_', $email_raw);
$config_file = "dados/" . $email_proprietario . "/config.json";

$tema_ativo = "light";
if (file_exists($config_file)) {
    $user_config = json_decode(file_get_contents($config_file), true);
    $tema_ativo = $user_config['configuracoes']['tema'] ?? 'light';
}

// 4. CÁLCULO DE MÉTRICAS DE DESEMPENHO
$total = count($_SESSION['prova']);
$acertos = $_SESSION['acertos'] ?? 0;
$erros = max(0, $total - $acertos);

$percentual = $total > 0 ? round(($acertos / $total) * 100, 1) : 0;
$nota = $total > 0 ? round(($acertos / $total) * 10, 1) : 0;

// Definição de status por aproveitamento
if ($percentual >= 70) {
    $status_classe = "bg-success-subtle text-success border-success-subtle";
    $status_texto = "Excelente Aproveitamento! 🎉";
} elseif ($percentual >= 50) {
    $status_classe = "bg-warning-subtle text-warning-emphasis border-warning-subtle";
    $status_texto = "Bom Desempenho! Continue Praticando 👍";
} else {
    $status_classe = "bg-danger-subtle text-danger border-danger-subtle";
    $status_texto = "Atenção: Necessário Revisão 📚";
}

$listaErros = $_SESSION['erros'] ?? [];
$categorias = $_SESSION['categorias'] ?? [];
?>

<!doctype html>
<html lang="pt-br" data-bs-theme="<?= htmlspecialchars($tema_ativo) ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultado do Simulado</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-body-tertiary py-4">

<div class="container" style="max-width: 850px;">

    <!-- CARD PRINCIPAL: NOTA E STATUS -->
    <div class="card shadow-sm border rounded-4 mb-4">
        <div class="card-body p-4 p-md-5 text-center">
            
            <h2 class="fw-bold mb-3">🥋 Resultado Final</h2>
            
            <div class="mb-3">
                <span class="badge border px-3 py-2 fs-6 rounded-pill <?= $status_classe ?>">
                    <?= $status_texto ?>
                </span>
            </div>

            <!-- EXIBIÇÃO DA NOTA -->
            <div class="display-1 fw-bold text-primary my-2">
                <?= $nota ?> <span class="fs-4 text-muted">/10</span>
            </div>

            <!-- CARDS DE ESTATÍSTICAS -->
            <div class="row mt-4 g-3">
                <div class="col-12 col-md-4">
                    <div class="p-3 border rounded-3 bg-success-subtle text-success-emphasis text-center">
                        <div class="fs-2 fw-bold"><?= $acertos ?></div>
                        <div class="small font-weight-semibold">Acertos</div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="p-3 border rounded-3 bg-danger-subtle text-danger-emphasis text-center">
                        <div class="fs-2 fw-bold"><?= $erros ?></div>
                        <div class="small font-weight-semibold">Erros</div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="p-3 border rounded-3 bg-primary-subtle text-primary-emphasis text-center">
                        <div class="fs-2 fw-bold"><?= $percentual ?>%</div>
                        <div class="small font-weight-semibold">Aproveitamento</div>
                    </div>
                </div>
            </div>

            <!-- BARRA DE PROGRESSO GERAL -->
            <div class="progress mt-4 bg-secondary-subtle" style="height: 18px;">
                <div class="progress-bar <?= $percentual >= 70 ? 'bg-success' : ($percentual >= 50 ? 'bg-warning' : 'bg-danger') ?>" 
                     role="progressbar" 
                     style="width: <?= $percentual ?>%;" 
                     aria-valuenow="<?= $percentual ?>" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                     <?= $percentual ?>%
                </div>
            </div>
        </div>
    </div>

    <!-- DESEMPENHO POR CATEGORIA -->
    <?php if (!empty($categorias)): ?>
        <div class="card shadow-sm border rounded-4 mb-4">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-3">📊 Desempenho por Categoria</h4>

                <div class="d-flex flex-column gap-3">
                    <?php foreach ($categorias as $titulo => $c): ?>
                        <?php
                        $catTotal = $c['total'] > 0 ? $c['total'] : 1;
                        $catPercentual = round(($c['acertos'] / $catTotal) * 100, 1);
                        
                        $barColor = "bg-danger";
                        if ($catPercentual >= 70) {
                            $barColor = "bg-success";
                        } elseif ($catPercentual >= 50) {
                            $barColor = "bg-warning";
                        }
                        ?>
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold text-body"><?= htmlspecialchars($titulo) ?></span>
                                <span class="small text-muted"><?= $c['acertos'] ?> de <?= $c['total'] ?> (<?= $catPercentual ?>%)</span>
                            </div>
                            <div class="progress bg-secondary-subtle" style="height: 10px;">
                                <div class="progress-bar <?= $barColor ?>" style="width: <?= $catPercentual ?>%;"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- SEÇÃO DE REVISÃO DE ERROS -->
    <div class="card shadow-sm border rounded-4 mb-4">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-3">❌ Questões para Revisão</h4>

            <?php if (empty($listaErros)): ?>
                <div class="alert alert-success border-success-subtle mb-0">
                    🌟 <strong>Excelente!</strong> Você acertou todas as questões desta avaliação.
                </div>
            <?php else: ?>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($listaErros as $i => $e): ?>
                        <div class="p-3 rounded-3 border bg-body">
                            <h6 class="fw-bold text-body mb-2">
                                <?= ($i + 1) ?>. <?= htmlspecialchars($e['pergunta']) ?>
                            </h6>
                            <div class="text-success small mb-2">
                                <strong>Resposta Correta:</strong> <?= htmlspecialchars($e['resposta']) ?>
                            </div>
                            <?php if (!empty($e['explicacao'])): ?>
                                <div class="small text-muted border-top pt-2 mt-2">
                                    💡 <strong>Explicação:</strong> <?= htmlspecialchars($e['explicacao']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- BOTÕES DE NAVEGAÇÃO -->
    <div class="d-grid gap-2">
        <a class="btn btn-primary btn-lg fw-bold rounded-3 shadow-sm" href="index.php">
            🔄 Iniciar Novo Simulado
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// LIMPEZA DA SESSÃO DO SIMULADO (PRESERVANDO DADOS DO USUÁRIO LOGADO)
$manter = ['email', 'name', 'picture', 'google_id', 'access_token'];

foreach ($_SESSION as $chave => $valor) {
    if (!in_array($chave, $manter, true)) {
        unset($_SESSION[$chave]);
    }
}
?>