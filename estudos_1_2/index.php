<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logado = false;
$email_raw = "visitante";

// Mantém a sessão do usuário ativa
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $logado = true;
    $email_raw = $_SESSION['email'];
} elseif (isset($_SESSION['google_id']) && !empty($_SESSION['google_id'])) {
    $logado = true;
    $email_raw = $_SESSION['email'] ?? $_SESSION['google_id'];
}

// Sanitiza o e-mail/diretório para evitar caracteres inválidos
$email_proprietario = preg_replace('/[^a-zA-Z0-9_@.-]/', '_', $email_raw);

// Diretório base do usuário logado
$user_base_dir = "dados/" . $email_proprietario;

// Garante a criação da pasta base
if (!is_dir($user_base_dir)) {
    mkdir($user_base_dir, 0777, true);
    mkdir($user_base_dir . '/saladeestudos', 0777, true);
}

// Caminho do arquivo config.json
$config_file = $user_base_dir . "/config.json";

// Estrutura padrão inicial
$config_padrao = [
    "configuracoes" => [
        "tema" => "light",
        "tempo_padrao_minutos" => 30,
        "questoes_por_prova" => 0 // 0 = Todas as questões
    ],
    "compartilhado" => [],
    "agendamentos" => []
];

// Cria o config.json se não existir
if (!file_exists($config_file)) {
    file_put_contents($config_file, json_encode($config_padrao, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// -----------------------------------------------------------------------------
// PROCESSAMENTO DO FORMULÁRIO DE CONFIGURAÇÕES (GERAL E COMPARTILHAMENTO)
// -----------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao_config']) && $logado) {
    $current_config = json_decode(file_get_contents($config_file), true) ?: $config_padrao;

    // 1. Atualizar Parâmetros Gerais
    if ($_POST['acao_config'] === 'salvar_geral') {
        $current_config['configuracoes']['tema'] = $_POST['tema'] ?? 'light';
        $current_config['configuracoes']['tempo_padrao_minutos'] = max(1, intval($_POST['tempo_padrao_minutos'] ?? 30));
        $current_config['configuracoes']['questoes_por_prova'] = max(0, intval($_POST['questoes_por_prova'] ?? 0));
    }
    // 2. Adicionar agendamento de estudos
    elseif ($_POST['acao_config'] === 'adicionar_agendamento') {
        $titulo = trim($_POST['agendamento_titulo'] ?? '');
        $data = trim($_POST['agendamento_data'] ?? '');
        $hora = trim($_POST['agendamento_hora'] ?? '19:00');
        $duracao = max(5, min(1440, intval($_POST['agendamento_duracao'] ?? 60)));
        $frequencia = $_POST['agendamento_frequencia'] ?? 'once';
        $descricao = trim($_POST['agendamento_descricao'] ?? '');
        $dias = $_POST['agendamento_dias'] ?? [];

        $frequencias_validas = ['once', 'daily', 'weekly', 'monthly'];
        if (!in_array($frequencia, $frequencias_validas, true)) {
            $frequencia = 'once';
        }

        if ($titulo !== '' && preg_match('/^\\d{4}-\\d{2}-\\d{2}$/', $data) && preg_match('/^\\d{2}:\\d{2}$/', $hora)) {
            if (!isset($current_config['agendamentos']) || !is_array($current_config['agendamentos'])) {
                $current_config['agendamentos'] = [];
            }

            $current_config['agendamentos'][] = [
                'id' => uniqid('estudo_', true),
                'titulo' => $titulo,
                'data' => $data,
                'hora' => $hora,
                'duracao' => $duracao,
                'frequencia' => $frequencia,
                'dias' => is_array($dias) ? array_values(array_intersect($dias, ['MO','TU','WE','TH','FR','SA','SU'])) : [],
                'descricao' => $descricao
            ];
        }
    }
    // 3. Remover agendamento
    elseif ($_POST['acao_config'] === 'remover_agendamento') {
        $id_remover = $_POST['id_agendamento'] ?? '';
        if (!empty($current_config['agendamentos']) && is_array($current_config['agendamentos'])) {
            $current_config['agendamentos'] = array_values(array_filter(
                $current_config['agendamentos'],
                fn($ag) => ($ag['id'] ?? '') !== $id_remover
            ));
        }
    }
    // 4. Adicionar Regra de Compartilhamento
    elseif ($_POST['acao_config'] === 'adicionar_compartilhamento') {
        $novo_email = strtolower(trim($_POST['email'] ?? ''));
        $nova_sala = strtolower(trim($_POST['sala'] ?? 'all'));
        $nova_prova = strtolower(trim($_POST['prova'] ?? 'all'));
        $nova_permissao = $_POST['permissao'] ?? 'ver';

        // Aceita somente opções que realmente existem na estrutura do usuário.
        $sala_valida = ($nova_sala === 'all') || isset($opcoes_compartilhamento[$nova_sala]);
        $prova_valida = ($nova_prova === 'all');

        if ($sala_valida && $nova_sala !== 'all') {
            $prova_valida = isset($opcoes_compartilhamento[$nova_sala]['provas'][$nova_prova]);
        }

        if (!empty($novo_email) && $sala_valida && $prova_valida) {
            $current_config['compartilhado'][] = [
                "sala" => empty($nova_sala) ? "all" : $nova_sala,
                "prova" => empty($nova_prova) ? "all" : $nova_prova,
                "email" => $novo_email,
                "permissao" => $nova_permissao
            ];
        }
    } 
    // 5. Remover Regra de Compartilhamento
    elseif ($_POST['acao_config'] === 'remover_compartilhamento') {
        $index_remover = intval($_POST['index_remover'] ?? -1);
        if ($index_remover >= 0 && isset($current_config['compartilhado'][$index_remover])) {
            array_splice($current_config['compartilhado'], $index_remover, 1);
        }
    }

    file_put_contents($config_file, json_encode($current_config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: index.php?config_aberto=1");
    exit;
}

// Carrega as configurações do usuário
$meu_config = json_decode(file_get_contents($config_file), true) ?: $config_padrao;

// Garante chaves mínimas caso o arquivo existente seja antigo
$cfg_geral = array_merge($config_padrao['configuracoes'], $meu_config['configuracoes'] ?? []);
$tema_ativo = $cfg_geral['tema'];
$tempo_padrao = $cfg_geral['tempo_padrao_minutos'];
$limite_questoes = $cfg_geral['questoes_por_prova'];
$agendamentos = isset($meu_config['agendamentos']) && is_array($meu_config['agendamentos'])
    ? $meu_config['agendamentos']
    : [];

function googleCalendarUrl($agendamento) {
    $data = $agendamento['data'] ?? date('Y-m-d');
    $hora = $agendamento['hora'] ?? '19:00';
    $duracao = max(5, intval($agendamento['duracao'] ?? 60));

    try {
        $inicio = new DateTime($data . ' ' . $hora . ':00', new DateTimeZone('America/Sao_Paulo'));
    } catch (Exception $e) {
        return '#';
    }

    $fim = clone $inicio;
    $fim->modify('+' . $duracao . ' minutes');

    $params = [
        'action' => 'TEMPLATE',
        'text' => $agendamento['titulo'] ?? 'Estudo',
        'dates' => $inicio->format('Ymd\\THis') . '/' . $fim->format('Ymd\\THis'),
        'details' => $agendamento['descricao'] ?? 'Sessão de estudos',
        'ctz' => 'America/Sao_Paulo'
    ];

    $freq = $agendamento['frequencia'] ?? 'once';

    if ($freq === 'daily') {
        $params['recur'] = 'RRULE:FREQ=DAILY';
    } elseif ($freq === 'weekly') {
        $dias = !empty($agendamento['dias']) ? $agendamento['dias'] : [strtoupper($inicio->format('D'))];
        $map = ['SUN'=>'SU','MON'=>'MO','TUE'=>'TU','WED'=>'WE','THU'=>'TH','FRI'=>'FR','SAT'=>'SA'];
        $dias_google = [];
        foreach ($dias as $dia) {
            $dias_google[] = $map[$dia] ?? $dia;
        }
        $params['recur'] = 'RRULE:FREQ=WEEKLY;BYDAY=' . implode(',', array_unique($dias_google));
    } elseif ($freq === 'monthly') {
        $params['recur'] = 'RRULE:FREQ=MONTHLY';
    }

    return 'https://calendar.google.com/calendar/render?' .
           http_build_query($params, '', '&', PHP_QUERY_RFC3986);
}

$simulados_por_sala = [];

/**
 * Processa e estrutura um arquivo JSON de simulado
 */
function processarArquivoSimulado(&$simulados_por_sala, $arquivo, $dono_folder, $is_compartilhado = false, $permissao = 'dono', $cfg_geral = []) {
    if (basename($arquivo) === 'config.json') {
        return;
    }

    $conteudo = file_get_contents($arquivo);
    $dados = json_decode($conteudo, true);

    if (!is_array($dados) || empty($dados)) {
        return;
    }

    $pasta_pai = basename(dirname($arquivo));
    if ($pasta_pai === $dono_folder) {
        $nome_sala_slug = "geral";
        $nome_sala_formatado = "Geral";
    } else {
        $nome_sala_slug = $pasta_pai;
        $nome_sala_formatado = ucwords(str_replace(['_', '-'], ' ', $pasta_pai));
    }

    if ($is_compartilhado) {
        $nome_sala_formatado .= " (de " . str_replace('_', '.', $dono_folder) . ")";
    }

    $nome_arquivo_prova = pathinfo(basename($arquivo), PATHINFO_FILENAME);
    $titulo_prova_formatado = ucwords(str_replace(['_', '-'], ' ', $nome_arquivo_prova));

    $adicionarSimulado = function($item) use (&$simulados_por_sala, $nome_sala_formatado) {
        if (isset($simulados_por_sala[$nome_sala_formatado])) {
            foreach ($simulados_por_sala[$nome_sala_formatado] as $existente) {
                if ($existente['caminho'] === $item['caminho'] && $existente['id'] === $item['id']) {
                    return;
                }
            }
        }
        $simulados_por_sala[$nome_sala_formatado][] = $item;
    };

    $tempo_sugerido = $cfg_geral['tempo_padrao_minutos'] ?? 30;
    $max_questoes = $cfg_geral['questoes_por_prova'] ?? 0;

    if (isset($dados[0]['pergunta']) || isset($dados[0]['opcoes'])) {
        $totalPerguntas = count($dados);
        $questoes_final = ($max_questoes > 0 && $max_questoes < $totalPerguntas) ? $max_questoes : $totalPerguntas;

        $adicionarSimulado([
            'id' => $nome_arquivo_prova,
            'sala_slug' => $nome_sala_slug,
            'titulo' => $titulo_prova_formatado,
            'total_perguntas' => $questoes_final,
            'total_original' => $totalPerguntas,
            'tempo_minutos' => $tempo_sugerido,
            'caminho' => $arquivo,
            'email_dono' => $dono_folder,
            'compartilhado' => $is_compartilhado,
            'permissao' => $permissao
        ]);
    } else {
        foreach ($dados as $index => $prova) {
            if (is_array($prova)) {
                $total = isset($prova['perguntas']) ? count($prova['perguntas']) : ($prova['total_perguntas'] ?? 0);
                $questoes_final = ($max_questoes > 0 && $max_questoes < $total) ? $max_questoes : $total;
                $id_prova = $prova['id'] ?? ($nome_arquivo_prova . '_' . $index);

                $adicionarSimulado([
                    'id' => $id_prova,
                    'sala_slug' => $nome_sala_slug,
                    'titulo' => $prova['titulo'] ?? ($prova['categoria'] ?? "Prova " . ($index + 1)),
                    'total_perguntas' => $questoes_final,
                    'total_original' => $total,
                    'tempo_minutos' => $prova['tempo_minutos'] ?? $tempo_sugerido,
                    'caminho' => $arquivo,
                    'email_dono' => $dono_folder,
                    'compartilhado' => $is_compartilhado,
                    'permissao' => $permissao
                ]);
            }
        }
    }
}

// 1. CARREGA OS ARQUIVOS DO PRÓPRIO USUÁRIO
$arquivos_subpastas = glob($user_base_dir . '/*/*.json');
$arquivos_raiz = glob($user_base_dir . '/*.json');
$meus_arquivos = array_merge($arquivos_raiz ?: [], $arquivos_subpastas ?: []);

foreach ($meus_arquivos as $arquivo) {
    processarArquivoSimulado($simulados_por_sala, $arquivo, $email_proprietario, false, 'dono', $cfg_geral);
}

// -----------------------------------------------------------------------------
// OPÇÕES DE COMPARTILHAMENTO: SALAS (PASTAS) E SIMULADOS (ARQUIVOS JSON)
// -----------------------------------------------------------------------------
// Monta a lista diretamente da estrutura de arquivos do usuário para evitar
// digitação manual e garantir que sala/prova realmente existam.
$opcoes_compartilhamento = [
    'geral' => [
        'nome' => 'Geral',
        'provas' => []
    ]
];

foreach ($meus_arquivos as $arquivo) {
    if (basename($arquivo) === 'config.json') {
        continue;
    }

    $pasta_pai = basename(dirname($arquivo));
    $sala_slug = ($pasta_pai === $email_proprietario) ? 'geral' : $pasta_pai;

    if (!isset($opcoes_compartilhamento[$sala_slug])) {
        $opcoes_compartilhamento[$sala_slug] = [
            'nome' => ucwords(str_replace(['_', '-'], ' ', $sala_slug)),
            'provas' => []
        ];
    }

    $prova_slug = pathinfo(basename($arquivo), PATHINFO_FILENAME);
    $opcoes_compartilhamento[$sala_slug]['provas'][$prova_slug] = ucwords(
        str_replace(['_', '-'], ' ', $prova_slug)
    );
}

// Não exibe uma opção "Geral" vazia caso não existam simulados na raiz.
if (empty($opcoes_compartilhamento['geral']['provas'])) {
    unset($opcoes_compartilhamento['geral']);
}

// 2. BUSCA COMPARTILHAMENTOS DE OUTROS USUÁRIOS
$todas_pastas_usuarios = glob('dados/*', GLOB_ONLYDIR);
$meu_email_clean = strtolower(trim($email_raw));
$minha_pasta_clean = strtolower(trim($email_proprietario));

foreach ($todas_pastas_usuarios as $pasta_outro_usuario) {
    $dono_folder = basename($pasta_outro_usuario);
    if ($dono_folder === $email_proprietario) continue;

    $config_outro_path = $pasta_outro_usuario . '/config.json';
    if (!file_exists($config_outro_path)) continue;

    $config_outro = json_decode(file_get_contents($config_outro_path), true);
    if (!isset($config_outro['compartilhado']) || !is_array($config_outro['compartilhado'])) continue;

    foreach ($config_outro['compartilhado'] as $regra) {
        $email_regra = strtolower(trim($regra['email'] ?? ''));
        $email_regra_sanitizado = preg_replace('/[^a-zA-Z0-9_@.-]/', '_', $email_regra);

        if ($email_regra === $meu_email_clean || $email_regra_sanitizado === $minha_pasta_clean) {
            $sala_regra = strtolower(trim($regra['sala'] ?? 'all'));
            $prova_regra = strtolower(trim($regra['prova'] ?? 'all'));
            $permissao = $regra['permissao'] ?? 'ver';

            $outros_subpastas = glob($pasta_outro_usuario . '/*/*.json');
            $outros_raiz = glob($pasta_outro_usuario . '/*.json');
            $todos_outros = array_merge($outros_raiz ?: [], $outros_subpastas ?: []);

            foreach ($todos_outros as $arquivo) {
                if (basename($arquivo) === 'config.json') continue;

                $pasta_pai = basename(dirname($arquivo));
                $sala_slug = ($pasta_pai === $dono_folder) ? "geral" : $pasta_pai;
                $nome_arquivo_prova = pathinfo(basename($arquivo), PATHINFO_FILENAME);

                $match_sala = ($sala_regra === 'all' || $sala_regra === strtolower($sala_slug));
                $match_prova = ($prova_regra === 'all' || $prova_regra === strtolower($nome_arquivo_prova));

                if ($match_sala && $match_prova) {
                    processarArquivoSimulado($simulados_por_sala, $arquivo, $dono_folder, true, $permissao, $cfg_geral);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="<?= htmlspecialchars($tema_ativo) ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plataforma de Estudos & Simulados</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }

        .card-sala {
            cursor: pointer;
            transition: all 0.25s ease-in-out;
            border: 2px solid transparent !important;
        }

        .card-sala:hover {
            transform: translateY(-5px);
            border-color: #0d6efd !important;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.15) !important;
        }

        .icon-sala {
            font-size: 2.2rem;
        }

        .card-simulado {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-simulado:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1) !important;
        }

        /* -----------------------------------------------------------------
           RESPONSIVIDADE
           Mantém a dinâmica existente e apenas adapta tamanhos/espaçamentos.
           ----------------------------------------------------------------- */
        html, body {
            overflow-x: hidden;
        }

        .navbar .container {
            min-width: 0;
        }

        .navbar-brand {
            white-space: nowrap;
        }

        .card-sala,
        .card-simulado {
            min-width: 0;
        }

        .card-sala h5,
        .card-simulado h4 {
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        /* Modal de configurações: aproveita melhor a tela em qualquer tamanho. */
        #modalConfig .modal-dialog {
            width: calc(100% - 1.5rem);
            max-width: 960px;
            margin: .75rem auto;
        }

        #modalConfig .modal-content {
            max-height: calc(100vh - 1.5rem);
            display: flex;
            flex-direction: column;
        }

        #modalConfig .modal-body {
            overflow-y: auto;
            overflow-x: hidden;
        }

        #configTabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            scrollbar-width: thin;
            -webkit-overflow-scrolling: touch;
        }

        #configTabs .nav-item {
            flex: 0 0 auto;
        }

        #configTabs .nav-link {
            white-space: nowrap;
        }

        /* Tabelas continuam completas, mas podem deslizar horizontalmente. */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
            min-width: 620px;
        }

        /* Botões e campos nunca ultrapassam a largura disponível. */
        .form-control,
        .form-select,
        .btn {
            max-width: 100%;
        }

        @media (max-width: 991.98px) {
            .container {
                max-width: 100%;
            }

            .navbar .container {
                gap: .5rem;
            }

            .navbar .navbar-brand {
                font-size: 1rem;
            }

            .navbar .d-flex {
                flex-wrap: wrap;
                justify-content: flex-end;
                gap: .25rem;
            }

            .navbar .d-flex .me-2 {
                margin-right: 0 !important;
            }

            #modalConfig .modal-dialog {
                max-width: calc(100% - 1rem);
                margin: .5rem auto;
            }

            #modalConfig .modal-content {
                max-height: calc(100vh - 1rem);
            }
        }

        @media (max-width: 767.98px) {
            .container.py-5 {
                padding-top: 1.5rem !important;
                padding-bottom: 1.5rem !important;
            }

            .row.g-4 {
                --bs-gutter-x: .75rem;
                --bs-gutter-y: .75rem;
            }

            .card-sala {
                padding: .5rem !important;
            }

            .card-sala .card-body {
                padding: .75rem .35rem;
            }

            .icon-sala {
                font-size: 1.8rem;
            }

            .card-sala h5 {
                font-size: .95rem;
            }

            #containerProvas > .collapse > div {
                padding: 1rem !important;
            }

            #containerProvas .d-flex.align-items-center.justify-content-between {
                gap: .75rem;
                flex-wrap: wrap;
            }

            #containerProvas .d-flex.align-items-center.justify-content-between h3 {
                flex: 1 1 100%;
                font-size: 1.05rem;
            }

            #containerProvas .d-flex.align-items-center.justify-content-between button {
                width: 100%;
            }

            #modalConfig .modal-header {
                padding: .75rem 1rem;
            }

            #modalConfig .modal-body {
                padding: 1rem !important;
            }

            #modalConfig .modal-title {
                font-size: 1rem;
            }

            #modalConfig .nav-tabs {
                margin-bottom: 1rem !important;
            }

            #modalConfig .nav-link {
                padding: .55rem .75rem;
                font-size: .9rem;
            }

            #modalConfig .alert {
                font-size: .9rem;
            }

            #modalConfig .alert .btn {
                display: block;
                width: 100%;
                margin: .75rem 0 0 !important;
            }

            /* Os col-md existentes passam naturalmente para uma coluna. */
            #modalConfig .row.g-3,
            #modalConfig .row.g-2 {
                --bs-gutter-x: .75rem;
                --bs-gutter-y: .75rem;
            }

            #modalConfig .text-end {
                text-align: stretch !important;
            }

            #modalConfig .text-end > .btn,
            #modalConfig form .text-end .btn {
                width: 100%;
            }

            #modalConfig #tab-compartilhar .table-responsive {
                margin-left: -.25rem;
                margin-right: -.25rem;
            }

            #modalConfig #tab-compartilhar .table-responsive table {
                min-width: 650px;
            }

            #modalConfig #tab-compartilhar .btn {
                white-space: nowrap;
            }
        }

        @media (max-width: 575.98px) {
            .navbar .container {
                padding-left: .75rem;
                padding-right: .75rem;
            }

            .navbar .container > div:last-child {
                max-width: 100%;
            }

            .navbar .btn {
                font-size: .78rem;
                padding: .3rem .5rem;
            }

            .navbar .user-avatar {
                width: 32px;
                height: 32px;
            }

            .card-sala .badge {
                font-size: .68rem;
            }

            .card-simulado .card-body {
                padding: 1rem !important;
            }

            .card-simulado .btn-lg {
                font-size: .95rem;
            }

            #modalConfig .modal-dialog {
                width: calc(100% - .5rem);
                margin: .25rem auto;
            }

            #modalConfig .modal-content {
                max-height: calc(100vh - .5rem);
                border-radius: .75rem;
            }

            #modalConfig .modal-body {
                padding: .75rem !important;
            }

            #modalConfig .nav-link {
                font-size: .82rem;
                padding: .5rem .65rem;
            }

            #modalConfig .form-label {
                font-size: .9rem;
            }

            #modalConfig .form-control,
            #modalConfig .form-select {
                font-size: .9rem;
            }
        }

        @media (max-width: 359.98px) {
            .navbar-brand {
                font-size: .9rem !important;
            }

            .navbar .btn {
                font-size: .72rem;
            }

            .card-sala h5 {
                font-size: .85rem;
            }

            .icon-sala {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body class="bg-body-tertiary">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                🎓 Central de Simulados
            </a>

            <div>
                <?php if (!$logado): ?>
                    <div id="g_id_onload"
                        data-client_id="107976644534-8knc18ps4i830labkk0petk6a7doo3pa.apps.googleusercontent.com"
                        data-callback="handleCredentialResponse"
                        data-auto_prompt="false">
                    </div>
                    <div class="g_id_signin" data-type="standard" data-theme="outline" data-size="medium"></div>
                <?php else: ?>
                    <div class="d-flex align-items-center">
                        <img src="<?= htmlspecialchars($_SESSION['picture'] ?? 'https://via.placeholder.com/40') ?>" class="user-avatar me-2" alt="Avatar">
                        <span class="me-3 d-none d-sm-inline fw-semibold">
                            <?= htmlspecialchars($_SESSION['name'] ?? $_SESSION['email']) ?>
                        </span>
                        
                        <button class="btn btn-outline-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalConfig">
                            ⚙️ Configurações
                        </button>

                        <a href="logout_google.php" class="btn btn-outline-danger btn-sm">Sair</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="container py-5">

        <?php if (!$logado): ?>
            <div class="alert alert-warning text-center shadow-sm mb-4">
                🔒 <strong>Modo Visitante:</strong> Conecte-se com o Google para personalizar temas, tempos e acessar suas salas compartilhadas.
            </div>
        <?php endif; ?>

        <?php if (empty($simulados_por_sala)): ?>
            <div class="alert alert-info text-center py-4 shadow-sm">
                📁 <strong>Nenhuma prova encontrada!</strong><br><br>
                Adicione arquivos <code>.json</code> na sua pasta:<br>
                <code>dados/<?= htmlspecialchars($email_proprietario) ?>/<b>NOME_DA_SALA</b>/<b>sua_prova.json</b></code>
            </div>
        <?php else: ?>

            <section class="mb-5" id="secaoSalas">
                <div id="gridSalas">
                    <div class="row g-4">
                        <?php 
                        $i = 0;
                        foreach ($simulados_por_sala as $nome_sala => $provas): 
                            $i++;
                            $target_id = "collapseSala_" . $i;
                            $total_provas = count($provas);
                            $eh_compartilhada = $provas[0]['compartilhado'] ?? false;
                        ?>
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="card card-sala h-100 shadow-sm border text-center p-3"
                                     data-bs-toggle="collapse" 
                                     data-bs-target="#<?= $target_id ?>" 
                                     aria-expanded="false" 
                                     aria-controls="<?= $target_id ?>">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <div class="icon-sala mb-2"><?= $eh_compartilhada ? '🤝' : '🏫' ?></div>
                                        <h5 class="fw-bold mb-2"><?= htmlspecialchars($nome_sala) ?></h5>
                                        <span class="badge <?= $eh_compartilhada ? 'bg-info text-dark' : 'bg-primary' ?> rounded-pill">
                                            <?= $total_provas ?> <?= $total_provas === 1 ? 'prova' : 'provas' ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div id="containerProvas">
                    <?php 
                    $i = 0;
                    foreach ($simulados_por_sala as $nome_sala => $provas): 
                        $i++;
                        $target_id = "collapseSala_" . $i;
                    ?>
                        <div class="collapse" id="<?= $target_id ?>" data-bs-parent="#secaoSalas">
                            <div class="p-4 rounded-4 shadow-sm border bg-body">
                                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                                    <h3 class="h4 fw-bold text-primary m-0">
                                        📍 Provas da Sala: <?= htmlspecialchars($nome_sala) ?>
                                    </h3>
                                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $target_id ?>">
                                        ⬅️ Voltar às Salas
                                    </button>
                                </div>

                                <div class="row g-4">
                                    <?php foreach ($provas as $s): ?>
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="card card-simulado shadow-sm border rounded-4 h-100 bg-body-tertiary">
                                                <div class="card-body d-flex flex-column p-4">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <h4 class="h5 fw-bold m-0">
                                                            <?= htmlspecialchars($s['titulo']) ?>
                                                        </h4>
                                                        <?php if ($s['compartilhado']): ?>
                                                            <span class="badge bg-warning text-dark" title="Permissão: <?= $s['permissao'] ?>">
                                                                🔑 <?= ucfirst($s['permissao']) ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <hr class="text-muted">

                                                    <p class="mb-2 text-secondary">
                                                        📚 <strong><?= $s['total_perguntas'] ?></strong> questões 
                                                        <?php if ($s['total_original'] > $s['total_perguntas']): ?>
                                                            <small class="text-warning">(limitado de <?= $s['total_original'] ?>)</small>
                                                        <?php endif; ?>
                                                    </p>
                                                    <p class="mb-4 text-secondary">
                                                        ⏱️ <strong><?= $s['tempo_minutos'] ?></strong> minutos configurados
                                                    </p>

                                                    <a class="btn btn-primary btn-lg rounded-3 mt-auto w-100 fw-bold"
                                                       href="iniciar.php?sala=<?= urlencode($s['sala_slug']) ?>&id=<?= urlencode($s['id']) ?>&email=<?= urlencode($s['email_dono']) ?>">
                                                        📝 Iniciar Prova
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

        <?php endif; ?>

    </div>

    <!-- MODAL DE CONFIGURAÇÕES -->
    <?php if ($logado): ?>
    <div class="modal fade" id="modalConfig" tabindex="-1" aria-labelledby="modalConfigLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold" id="modalConfigLabel">⚙️ Painel de Configurações</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body p-4">
                    
                    <!-- NAV TABS -->
                    <ul class="nav nav-tabs mb-4" id="configTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold" id="tab-geral-tab" data-bs-toggle="tab" data-bs-target="#tab-geral" type="button" role="tab">
                                🎨 Geral & Execução
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="tab-agenda-tab" data-bs-toggle="tab" data-bs-target="#tab-agenda" type="button" role="tab">
                                📅 Estudos & Lembretes
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold" id="tab-compartilhar-tab" data-bs-toggle="tab" data-bs-target="#tab-compartilhar" type="button" role="tab">
                                🤝 Compartilhamento
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="configTabsContent">
                        
                        <!-- ABA 1: PARÂMETROS GERAIS E TEMA -->
                        <div class="tab-pane fade show active" id="tab-geral" role="tabpanel">
                            <form method="POST" action="index.php">
                                <input type="hidden" name="acao_config" value="salvar_geral">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">🎨 Tema da Interface</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tema" id="temaLight" value="light" <?= $tema_ativo === 'light' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="temaLight">
                                                ☀️ Claro (Light)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tema" id="temaDark" value="dark" <?= $tema_ativo === 'dark' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="temaDark">
                                                🌙 Escuro (Dark)
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">⏱️ Tempo Padrão por Prova (Minutos)</label>
                                        <input type="number" name="tempo_padrao_minutos" class="form-control" value="<?= htmlspecialchars($tempo_padrao) ?>" min="1" required>
                                        <small class="text-muted">Sera aplicado caso a prova não defina um tempo limite.</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">📚 Máximo de Questões por Prova</label>
                                        <input type="number" name="questoes_por_prova" class="form-control" value="<?= htmlspecialchars($limite_questoes) ?>" min="0" required>
                                        <small class="text-muted">Digite <code>0</code> para carregar todas as questões do JSON.</small>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary fw-bold px-4">Salvar Parâmetros</button>
                                </div>
                            </form>
                        </div>

                        <!-- ABA 2: AGENDAMENTO DE ESTUDOS -->
                        <div class="tab-pane fade" id="tab-agenda" role="tabpanel">
                            <div class="alert alert-info">
                                <strong>📚 Organize seus estudos.</strong>
                                Crie lembretes únicos, diários, semanais ou mensais. O botão
                                <strong>Google Agenda</strong> abre o evento já preenchido no seu calendário.
                                <button type="button" class="btn btn-sm btn-outline-dark ms-2" onclick="pedirPermissaoNotificacao()">
                                    🔔 Ativar aviso neste navegador
                                </button>
                            </div>

                            <?php if (!empty($agendamentos)): ?>
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Estudo</th>
                                                <th>Quando</th>
                                                <th>Repetição</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $nomes_freq = [
                                            'once' => 'Uma vez',
                                            'daily' => 'Todos os dias',
                                            'weekly' => 'Semanal',
                                            'monthly' => 'Mensal'
                                        ];
                                        foreach ($agendamentos as $ag):
                                        ?>
                                            <tr>
                                                <td>
                                                    <strong><?= htmlspecialchars($ag['titulo'] ?? 'Estudo') ?></strong>
                                                    <?php if (!empty($ag['descricao'])): ?>
                                                        <br><small class="text-muted"><?= htmlspecialchars($ag['descricao']) ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?= date('d/m/Y', strtotime($ag['data'] ?? date('Y-m-d'))) ?>
                                                    às <?= htmlspecialchars($ag['hora'] ?? '') ?>
                                                    <br><small><?= intval($ag['duracao'] ?? 60) ?> min</small>
                                                </td>
                                                <td><?= htmlspecialchars($nomes_freq[$ag['frequencia'] ?? 'once'] ?? 'Uma vez') ?></td>
                                                <td class="text-nowrap">
                                                    <a href="<?= htmlspecialchars(googleCalendarUrl($ag)) ?>"
                                                       target="_blank" rel="noopener"
                                                       class="btn btn-outline-primary btn-sm">
                                                        📅 Google Agenda
                                                    </a>
                                                    <form method="POST" action="index.php" class="d-inline">
                                                        <input type="hidden" name="acao_config" value="remover_agendamento">
                                                        <input type="hidden" name="id_agendamento" value="<?= htmlspecialchars($ag['id'] ?? '') ?>">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                                onclick="return confirm('Remover este agendamento?')">
                                                            🗑️
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-secondary">Nenhum estudo agendado ainda.</div>
                            <?php endif; ?>

                            <h6 class="fw-bold mb-3">➕ Novo lembrete de estudo</h6>
                            <form method="POST" action="index.php" id="formAgendamento">
                                <input type="hidden" name="acao_config" value="adicionar_agendamento">

                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold">📖 O que estudar?</label>
                                        <input type="text" name="agendamento_titulo" class="form-control"
                                               placeholder="Ex.: Taekwon-Do — Faixa Verde → Azul" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">⏱️ Duração (min)</label>
                                        <input type="number" name="agendamento_duracao" class="form-control"
                                               value="60" min="5" max="1440" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">📅 Data inicial</label>
                                        <input type="date" name="agendamento_data" id="agendamento_data"
                                               class="form-control" value="<?= date('Y-m-d') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">🕐 Horário</label>
                                        <input type="time" name="agendamento_hora" class="form-control"
                                               value="19:00" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">🔁 Repetição</label>
                                        <select name="agendamento_frequencia" id="agendamento_frequencia" class="form-select">
                                            <option value="once">Uma vez</option>
                                            <option value="daily">Todos os dias</option>
                                            <option value="weekly">Toda semana</option>
                                            <option value="monthly">Todo mês</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6" id="diasSemanaContainer" style="display:none;">
                                        <label class="form-label fw-bold">📆 Dias da semana</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php
                                            $dias_nomes = [
                                                'MO' => 'Seg', 'TU' => 'Ter', 'WE' => 'Qua',
                                                'TH' => 'Qui', 'FR' => 'Sex', 'SA' => 'Sáb', 'SU' => 'Dom'
                                            ];
                                            foreach ($dias_nomes as $codigo => $nome):
                                            ?>
                                                <label class="btn btn-outline-secondary btn-sm">
                                                    <input type="checkbox" class="btn-check"
                                                           name="agendamento_dias[]" value="<?= $codigo ?>">
                                                    <?= $nome ?>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">📝 Observação</label>
                                        <textarea name="agendamento_descricao" class="form-control" rows="2"
                                                  placeholder="Ex.: Revisar teoria, fazer 15 questões e corrigir erros."></textarea>
                                    </div>

                                    <div class="col-12">
                                        <div class="alert alert-warning small mb-0">
                                            💡 <strong>Importante:</strong> o lembrete dentro do site funciona enquanto a página estiver aberta.
                                            Para receber notificações mesmo sem abrir a plataforma, adicione o agendamento ao
                                            <strong>Google Agenda</strong>.
                                        </div>
                                    </div>

                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary fw-bold px-4">
                                            📅 Criar agendamento
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- ABA 3: COMPARTILHAMENTO -->
                        <div class="tab-pane fade" id="tab-compartilhar" role="tabpanel">
                            <p class="text-muted small mb-3">
                                Libere o acesso das suas salas para outros e-mails cadastrados. Use <code>all</code> para liberar tudo.
                            </p>

                            <!-- Tabela de Regras -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-hover align-middle text-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>E-mail</th>
                                            <th>Sala</th>
                                            <th>Prova</th>
                                            <th>Permissão</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($meu_config['compartilhado'])): ?>
                                            <tr>
                                                <td colspan="5" class="text-muted py-3">Nenhum compartilhamento ativo.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($meu_config['compartilhado'] as $idx => $rule): ?>
                                                <tr>
                                                    <td><code><?= htmlspecialchars($rule['email']) ?></code></td>
                                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($rule['sala']) ?></span></td>
                                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($rule['prova']) ?></span></td>
                                                    <td><span class="badge bg-info text-dark"><?= ucfirst(htmlspecialchars($rule['permissao'])) ?></span></td>
                                                    <td>
                                                        <form method="POST" action="index.php" class="d-inline">
                                                            <input type="hidden" name="acao_config" value="remover_compartilhamento">
                                                            <input type="hidden" name="index_remover" value="<?= $idx ?>">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm">🗑️ Remover</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Formulário de Adição -->
                            <h6 class="fw-bold mb-3">➕ Adicionar Regra</h6>
                            <form method="POST" action="index.php">
                                <input type="hidden" name="acao_config" value="adicionar_compartilhamento">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="email" name="email" class="form-control" placeholder="E-mail do colega" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold mb-1">🏫 Sala</label>
                                        <select name="sala" id="compartilharSala" class="form-select" required>
                                            <option value="all">📚 Todas as salas</option>
                                            <?php foreach ($opcoes_compartilhamento as $sala_slug => $sala_info): ?>
                                                <option value="<?= htmlspecialchars($sala_slug) ?>">
                                                    📁 <?= htmlspecialchars($sala_info['nome']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="text-muted">Pastas encontradas em sua conta.</small>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold mb-1">📝 Simulado</label>
                                        <select name="prova" id="compartilharProva" class="form-select" required>
                                            <option value="all">📚 Todos os simulados</option>
                                        </select>
                                        <small class="text-muted">Arquivos JSON da sala selecionada.</small>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="permissao" class="form-select">
                                            <option value="ver">Ver</option>
                                            <option value="comentar">Comentar</option>
                                            <option value="editar">Editar</option>
                                        </select>
                                    </div>
                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" class="btn btn-success fw-bold">Adicionar Regra</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        // Estrutura real das pastas/simulados do usuário para os campos de compartilhamento.
        const opcoesCompartilhamento = <?= json_encode($opcoes_compartilhamento, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

        function atualizarSimuladosCompartilhamento() {
            const salaSelect = document.getElementById('compartilharSala');
            const provaSelect = document.getElementById('compartilharProva');

            if (!salaSelect || !provaSelect) return;

            const sala = salaSelect.value;
            provaSelect.innerHTML = '';

            const opcaoTodos = document.createElement('option');
            opcaoTodos.value = 'all';
            opcaoTodos.textContent = sala === 'all' ? '📚 Todos os simulados' : '📚 Todos os simulados desta sala';
            provaSelect.appendChild(opcaoTodos);

            if (sala === 'all') {
                // Ao escolher todas as salas, "todos os simulados" é a opção segura.
                return;
            }

            const provas = opcoesCompartilhamento[sala]?.provas || {};
            Object.entries(provas).forEach(([slug, nome]) => {
                const option = document.createElement('option');
                option.value = slug;
                option.textContent = '📝 ' + nome;
                provaSelect.appendChild(option);
            });
        }

        $(document).ready(function() {
            const salaSelect = document.getElementById('compartilharSala');
            if (salaSelect) {
                salaSelect.addEventListener('change', atualizarSimuladosCompartilhamento);
                atualizarSimuladosCompartilhamento();
            }
            $('#containerProvas .collapse').on('show.bs.collapse', function () {
                $('#gridSalas').slideUp(300);
            });

            $('#containerProvas .collapse').on('hidden.bs.collapse', function () {
                if ($('#containerProvas .collapse.show').length === 0) {
                    $('#gridSalas').slideDown(300);
                }
            });

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('config_aberto')) {
                var modalConfig = new bootstrap.Modal(document.getElementById('modalConfig'));
                modalConfig.show();
            }
        });

        // Exibe os dias da semana somente para agendamento semanal
        function atualizarDiasSemana() {
            const freq = document.getElementById('agendamento_frequencia');
            const box = document.getElementById('diasSemanaContainer');
            if (freq && box) {
                box.style.display = freq.value === 'weekly' ? 'block' : 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const freq = document.getElementById('agendamento_frequencia');
            if (freq) {
                freq.addEventListener('change', atualizarDiasSemana);
                atualizarDiasSemana();
            }

            // Lembrete local enquanto a plataforma estiver aberta.
            if ('Notification' in window && Notification.permission === 'default') {
                // Não pede permissão automaticamente; o navegador decide quando o usuário interagir.
            }
        });

        function pedirPermissaoNotificacao() {
            if ('Notification' in window) {
                Notification.requestPermission().then(function (permission) {
                    if (permission === 'granted') {
                        alert('🔔 Notificações ativadas neste navegador.');
                    }
                });
            } else {
                alert('Seu navegador não suporta notificações.');
            }
        }

        function handleCredentialResponse(response) {
            const data = parseJwt(response.credential);

            fetch("login_google.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    id: data.sub,
                    email: data.email,
                    name: data.name,
                    picture: data.picture
                })
            })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    location.reload();
                } else {
                    alert("Erro ao realizar login.");
                }
            })
            .catch(err => console.error("Erro na autenticação:", err));
        }

        function parseJwt(token) {
            var base64Url = token.split('.')[1];
            var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));

            return JSON.parse(jsonPayload);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>