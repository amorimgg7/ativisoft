<?php
session_start();

// ===============================
// IDENTIFICAR SIMULADO ESCOLHIDO
// ===============================

$id    = $_GET['id'] ?? '';
$sala  = $_GET['sala'] ?? '';
$email_raw = $_GET['email'] ?? ($_SESSION['email'] ?? 'visitante');

// Sanitiza o e-mail/diretório para evitar caracteres inválidos
$email = preg_replace('/[^a-zA-Z0-9_@.-]/', '_', $email_raw);

// Tenta localizar o arquivo JSON na estrutura de subpastas
$arquivo = "";

if ($sala !== '' && $sala !== 'geral' && file_exists("dados/$email/$sala/$id.json")) {
    $arquivo = "dados/$email/$sala/$id.json";
} elseif (file_exists("dados/$email/$id.json")) {
    $arquivo = "dados/$email/$id.json";
} elseif (file_exists("dados/$id.json")) {
    $arquivo = "dados/$id.json";
}

if (empty($arquivo) || !file_exists($arquivo)) {
    die('Simulado não encontrado.');
}

$_SESSION['arquivo_simulado'] = basename($arquivo);

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

// Quantidade de questões da prova (Padrão 10 ou o total disponível)
//$_SESSION['quantidadeQuestoes'] = 3;


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
    if (!isset($q['opcoes']) || !is_array($q['opcoes'])) {
        continue;
    }

    $indices = array_keys($q['opcoes']);

    shuffle($indices);

    $novasOpcoes = [];
    $novaCorreta = 0;

    foreach ($indices as $novoIndice => $indiceOriginal)
    {
        $novasOpcoes[] = $q['opcoes'][$indiceOriginal];

        if (isset($q['correta']) && $indiceOriginal == $q['correta'])
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