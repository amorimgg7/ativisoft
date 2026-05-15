
<!DOCTYPE html>
<html lang="pt-br">

<head>
<?php 
    if(isset($_SESSION['bloqueado'])){
      if($_SESSION['bloqueado'] == 1){
        //echo "<meta http-equiv='refresh' content='15;url=../auto_pagamento/payment.php'>";
      }else if($_SESSION['bloqueado'] == 2){
        echo "<meta http-equiv='refresh' content='1;url=../auto_pagamento/payment.php'>";
      }
    }
  ?>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cadastro Servico</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/custom.css">
  
  <link rel='shortcut icon' href='https://lh3.googleusercontent.com/pw/AP1GczOReqQClzL-PZkykfOwgmMyVzQgx27DTp783MI7iwKuKSv-6P6V7KOEbCC74sGdK3DEV3O88CsBLeIvOaQwGT3x4bqCTPRtyV9zcODbYVDRxAF8zf8Uev7geh4ONPdl3arNhnSDPvbQfMdpFRPM263V9A=w250-h250-s-no-gm?authuser=0' />
  <!-- endinject -->
  <script src="../../js/functions.js"></script>
  
</head>

<!--<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">-->

<body>

</body>
<?php

set_time_limit(0);

/* CONFIG ORIGEM */
/*
$db_origem = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "db"   => "assistent_master"
];
*/
/*
$db_origem = [
    "host" => "ass_geral.mysql.dbaas.com.br",
    "user" => "ass_geral",
    "pass" => "GGA@20002021g",
    "db"   => "ass_geral"
];*/



/* CONFIG DESTINO */

/*
$db_destino = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "db"   => "assistent_master_copy"
];

*/
/*
$db_destino = [
    "host" => "ass_geral.mysql.dbaas.com.br",
    "user" => "ass_geral",
    "pass" => "GGA@20002021g",
    "db"   => "ass_geral"
];*/
/*
$db_destino = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "db"   => "assistent_63349722"
];*/
$cnpj_destino = '633497220001-76';
/*
$cnpj_destino = '633497220001-76';
$host_destino       = "ass_".substr($cnpj_destino, 0, 8).".mysql.dbaas.com.br";
$usuario_destino    = "ass_".substr($cnpj_destino, 0, 8);
$senha_destino      = 'GGA@20002021g';
$nome_destino       = "ass_".substr($cnpj_destino, 0, 8); // Extrai os primeiros 8 dígitos
   

$db_destino = [
    "host" => $host_destino,
    "user" => $usuario_destino,
    "pass" => $senha_destino,
    "db"   => $nome_destino
];
*/

session_start();
if (isset($_POST['grava_origem_destino'])) {

    $_SESSION['host_origem'] = $_POST['host_origem'];
    $_SESSION['user_origem'] = $_POST['user_origem'];
    $_SESSION['pass_origem'] = $_POST['pass_origem'];
    $_SESSION['db_origem']   = $_POST['db_origem'];

    $_SESSION['host_destino'] = $_POST['host_destino'];
    $_SESSION['user_destino'] = $_POST['user_destino'];
    $_SESSION['pass_destino'] = $_POST['pass_destino'];
    $_SESSION['db_destino']   = $_POST['db_destino'];

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}


$db_origem = [
    "host" => $_SESSION['host_origem'],
    "user" => $_SESSION['user_origem'],
    "pass" => $_SESSION['pass_origem'],
    "db"   => $_SESSION['db_origem']
];

$db_destino = [
    "host" => $_SESSION['host_destino'],
    "user" => $_SESSION['user_destino'],
    "pass" => $_SESSION['pass_destino'],
    "db"   => $_SESSION['db_destino']
];

if (empty($db_origem['db']) && empty($db_destino['db'])) {
    ?>
    <div class="container mt-5">
    <form method="post" class="card shadow p-4">

        <h4 class="mb-4 text-center">Configuração dos Bancos de Dados</h4>

        <div class="row">
            <!-- ORIGEM -->
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Banco de Origem</h5>

                <div class="mb-3">
                    <label class="form-label">Host</label>
                    <input type="text" name="host_origem" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Usuário</label>
                    <input type="text" name="user_origem" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="pass_origem" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Banco de Dados</label>
                    <input type="text" name="db_origem" class="form-control" required>
                </div>
            </div>

            <!-- DESTINO -->
            <div class="col-md-6">
                <h5 class="text-success mb-3">Banco de Destino</h5>

                <div class="mb-3">
                    <label class="form-label">Host</label>
                    <input type="text" name="host_destino" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Usuário</label>
                    <input type="text" name="user_destino" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="pass_destino" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Banco de Dados</label>
                    <input type="text" name="db_destino" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit"
                    name="grava_origem_destino"
                    id="grava_origem_destino"
                    class="btn btn-primary px-5">
                Salvar Configuração
            </button>
        </div>

    </form>
</div>

    <?php
    exit; // impede o resto do script de rodar
}else{


/* CONEXÕES */
$conn_origem = new mysqli($db_origem["host"], $db_origem["user"], $db_origem["pass"], $db_origem["db"]);
if ($conn_origem->connect_error) die("Erro origem: " . $conn_origem->connect_error);

$conn_destino = new mysqli($db_destino["host"], $db_destino["user"], $db_destino["pass"], $db_destino["db"]);
if ($conn_destino->connect_error) die("Erro destino: " . $conn_destino->connect_error);

/* BOTÃO LIMPAR CACHE */
echo '<button onclick="location.href=location.pathname+\'?t=\'+Date.now()" 
        style="padding:6px 12px;background:#ffc107;border:0;border-radius:4px;margin-bottom:15px;cursor:pointer;">
        🧹 Limpar Cache da Tela
      </button>';

/* BOTÃO EXECUTAR + MOSTRAR SQL */
function btn($sql) {
    return "
        <div style='margin:8px 0;padding:10px;background:#f7f7f7;border:1px solid #ccc;border-radius:6px'>
            <div style='font-size:13px;color:#000;margin-bottom:6px'>
                <b>SQL manual (copie e cole no phpMyAdmin):</b><br>
                <code style='white-space:pre-wrap;font-size:13px;color:#444'>" . htmlspecialchars($sql) . "</code>
            </div>

            <form method='post' style='display:inline-block;margin-top:8px'>
                <input type='hidden' name='sql' value=\"" . htmlspecialchars($sql) . "\">
                <button style='padding:6px 12px;background:#007bff;border:0;color:white;border-radius:4px;cursor:pointer;'>
                    Executar pelo sistema
                </button>
            </form>
        </div>
    ";
}

/* EXECUTAR SQL */
if (isset($_POST["sql"])) {
    $sql = $_POST["sql"];
    if ($conn_destino->query($sql)) {
        echo "<div style='padding:10px;background:#c8ffc8;border:1px solid #070'>
                ✔ Executado:<br><code>$sql</code>
              </div><br>";
    } else {
        echo "<div style='padding:10px;background:#ffc8c8;border:1px solid #700'>
                ❌ Erro:<br>" . $conn_destino->error . "<br><code>$sql</code>
              </div><br>";
    }
}

/* MENU */
$etapa = $_GET['etapa'] ?? '';

echo "<h1>Sincronizador de Estruturas</h1>";
echo "
    <h3>De: ".$db_origem['db']." Para ".$db_destino['db']." </h3>
";

echo "
<div style='margin-bottom:20px;padding:10px;background:#eee;border-radius:6px;'>
    <form method='get'>
        <label><b>Selecione a etapa:</b></label><br><br>
        <select name='etapa' style='padding:6px;border-radius:4px;'>
    <option value=''>-- Escolher --</option>
    <option value='tabelas_faltando' <?=($etapa=='tabelas_faltando'?'selected':'')?>>
        1) Criar tabelas faltantes (sem FK)
    </option>
    <option value='foreign_keys' <?=($etapa=='foreign_keys'?'selected':'')?>>
        2) Criar chaves estrangeiras
    </option>
    <option value='tabelas_remover' <?=($etapa=='tabelas_remover'?'selected':'')?>>
        3) Remover tabelas extras
    </option>
    <option value='colunas_faltando' <?=($etapa=='colunas_faltando'?'selected':'')?>>
        4) Colunas faltando
    </option>
    <option value='colunas_remover' <?=($etapa=='colunas_remover'?'selected':'')?>>
        5) Remover colunas extras
    </option>
    <option value='dados' <?=($etapa=='dados'?'selected':'')?>>
        6) Sincronizar dados
    </option>
    <option value='acessos_permissoes' <?=($etapa=='acessos_permissoes'?'selected':'')?>
        7) Acessos e Permissões
    </option>
</select>


        <button style='padding:6px 12px;margin-left:10px;background:#007bff;border:0;color:white;border-radius:4px;cursor:pointer;'>
            Ir
        </button>
    </form>
</div>
";

/* VERIFICAÇÃO SEGURA DE COLUNA */
function colunaExiste($conn, $banco, $tabela, $coluna) {
    $sql = "SELECT COUNT(*) AS total
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = ?
              AND TABLE_NAME = ?
              AND COLUMN_NAME = ?";
    $st = $conn->prepare($sql);
    $st->bind_param("sss", $banco, $tabela, $coluna);
    $st->execute();
    $res = $st->get_result();
    $row = $res->fetch_assoc();
    return (int)$row['total'] > 0;
}

/* PADRÃO DEFAULT */
function tratar_default($type, $default, $col = "") {
    $type = strtolower($type);

    if (in_array($col, ["cd_empresa","cd_filial","cd_matriz"])) return " DEFAULT 1";
    if ($default === null || $default === "") {
        if (preg_match('/int|decimal|float|double/', $type)) return " DEFAULT 0";
        if (strpos($type,"date")!==false) return " DEFAULT NULL";
        return "";
    }

    if (strpos($type,"text")!==false || strpos($type,"blob")!==false) return "";
    if (preg_match('/int|decimal|float|double/', $type)) return " DEFAULT " . $default;

    return " DEFAULT '" . addslashes($default) . "'";
}

/* TABELA EXISTE */
function tabela_existe($conn, $db, $tabela) {
    $sql = "SELECT 1 FROM information_schema.tables 
            WHERE table_schema=? 
            AND table_name=? LIMIT 1";
    $st = $conn->prepare($sql);
    $st->bind_param("ss", $db, $tabela);
    $st->execute();
    $st->store_result();
    return $st->num_rows > 0;
}

/* -------------------------- */
/*        ETAPA 1             */
/* -------------------------- */
/*
if ($etapa == "tabelas_faltando") {

    echo "<h2>📌 Tabelas faltando</h2>";

    $q = "SELECT table_name FROM information_schema.tables WHERE table_schema = ?";
    $st = $conn_origem->prepare($q);
    $st->bind_param("s", $db_origem['db']);
    $st->execute();
    $res = $st->get_result();

    while ($r = $res->fetch_assoc()) {
        $t = $r['table_name'];

        if (tabela_existe($conn_destino, $db_destino['db'], $t)) continue;

        $show = $conn_origem->query("SHOW CREATE TABLE `$t`");
        $row = $show->fetch_assoc();
        $sql = $row['Create Table'] . ";";

        echo "<p>➕ Criar tabela <b>$t</b></p>" . btn($sql);
    }
}
*/


if ($etapa == "tabelas_faltando") {

    echo "<h2>📌 Criar tabelas faltantes (sem FK)</h2>";

    $q = "SELECT table_name FROM information_schema.tables WHERE table_schema = ?";
    $st = $conn_origem->prepare($q);
    $st->bind_param("s", $db_origem['db']);
    $st->execute();
    $res = $st->get_result();

    while ($r = $res->fetch_assoc()) {
        $t = $r['table_name'];

        if (tabela_existe($conn_destino, $db_destino['db'], $t)) continue;

        $show = $conn_origem->query("SHOW CREATE TABLE `$t`");
        $row = $show->fetch_assoc();
        $create = $row['Create Table'];

        // remove FOREIGN KEY e CONSTRAINT
        // separa header, corpo e footer do CREATE TABLE
preg_match('/^(CREATE TABLE.+?\()\s*(.+)\s*(\)\s*ENGINE=.*)$/s', $create, $m);

$header = $m[1];
$body   = $m[2];
$footer = $m[3];

// quebra linhas internas
$defs = explode(",\n", $body);

$clean_defs = [];

foreach ($defs as $d) {
    if (
        stripos($d, 'CONSTRAINT') !== false ||
        stripos($d, 'FOREIGN KEY') !== false
    ) continue;

    $clean_defs[] = trim($d);
}

// recompõe com vírgulas CORRETAS
$sql = $header . "\n  " .
       implode(",\n  ", $clean_defs) .
       "\n" . $footer . ";";

// força PK começar do 1
$sql = preg_replace('/AUTO_INCREMENT=\d+/', 'AUTO_INCREMENT=1', $sql);

echo "<p>➕ Criar tabela <b>$t</b></p>" . btn($sql);

    }
}


if ($etapa == "foreign_keys") {

    echo "<h2>🔗 Criar chaves estrangeiras</h2>";

    $sql = "
        SELECT
            kcu.TABLE_NAME,
            kcu.CONSTRAINT_NAME,
            kcu.COLUMN_NAME,
            kcu.REFERENCED_TABLE_NAME,
            kcu.REFERENCED_COLUMN_NAME,
            rc.UPDATE_RULE,
            rc.DELETE_RULE
        FROM information_schema.KEY_COLUMN_USAGE kcu
        JOIN information_schema.REFERENTIAL_CONSTRAINTS rc
            ON rc.CONSTRAINT_NAME = kcu.CONSTRAINT_NAME
            AND rc.CONSTRAINT_SCHEMA = kcu.TABLE_SCHEMA
        WHERE kcu.TABLE_SCHEMA = ?
        AND kcu.REFERENCED_TABLE_NAME IS NOT NULL
    ";

    $st = $conn_origem->prepare($sql);
    $st->bind_param("s", $db_origem['db']);
    $st->execute();
    $res = $st->get_result();

    while ($fk = $res->fetch_assoc()) {

        $table = $fk['TABLE_NAME'];
        $name  = $fk['CONSTRAINT_NAME'];

        // verifica se FK já existe no destino
        $check = "
            SELECT 1 FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = ?
            AND TABLE_NAME = ?
            AND CONSTRAINT_NAME = ?
        ";

        $c = $conn_destino->prepare($check);
        $c->bind_param("sss", $db_destino['db'], $table, $name);
        $c->execute();
        $c->store_result();

        if ($c->num_rows > 0) continue;

        $sql_fk = "
            ALTER TABLE `$table`
            ADD CONSTRAINT `$name`
            FOREIGN KEY (`{$fk['COLUMN_NAME']}`)
            REFERENCES `{$fk['REFERENCED_TABLE_NAME']}` (`{$fk['REFERENCED_COLUMN_NAME']}`)
            ON DELETE {$fk['DELETE_RULE']}
            ON UPDATE {$fk['UPDATE_RULE']};
        ";

        echo "<p>🔗 $table → FK <b>$name</b></p>" . btn(trim($sql_fk));
    }
}


/* -------------------------- */
/*        ETAPA 2             */
/* -------------------------- */
if ($etapa == "tabelas_remover") {

    echo "<h2>🗑️ Tabelas a remover</h2>";

    $q2 = "SELECT table_name FROM information_schema.tables WHERE table_schema = ?";
    $s2 = $conn_destino->prepare($q2);
    $s2->bind_param("s", $db_destino['db']);
    $s2->execute();
    $rd = $s2->get_result();

    while ($r = $rd->fetch_assoc()) {
        $t = $r['table_name'];

        if (tabela_existe($conn_origem, $db_origem['db'], $t)) continue;

        echo "<p>🗑️ Remover tabela <b>$t</b></p>" . btn("DROP TABLE `$t`;");
    }
}

/* -------------------------- */
/*        ETAPA 3             */
/* -------------------------- */
if ($etapa == "colunas_faltando") {

    echo "<h2>📌 Colunas faltando</h2>";

    $q3 = "
        SELECT o.table_name, o.column_name, o.column_type, o.is_nullable,
               o.column_default, o.extra
        FROM information_schema.columns o
        WHERE o.table_schema = ? LIMIT 100 
    ";
    $s3 = $conn_origem->prepare($q3);
    $s3->bind_param("s", $db_origem['db']);
    $s3->execute();
    $r3 = $s3->get_result();

    $contador = 0;
$limite = 5; // Mostra apenas 2 resultados


    while ($c = $r3->fetch_assoc()) {

    if ($contador >= $limite) break;  // <-- limite de exibição

    $t  = $c["table_name"];
    $col = $c["column_name"];

    if (!tabela_existe($conn_destino, $db_destino['db'], $t)) continue;
    if (colunaExiste($conn_destino, $db_destino['db'], $t, $col)) continue;

    $contador++; // <-- incrementa após achar coluna faltando

    $type = $c["column_type"];
    $null = $c["is_nullable"];
    $def = $c["column_default"];
    $extra = $c["extra"];

    $sql = "ALTER TABLE `$t` ADD COLUMN `$col` $type";
    $sql .= ($null == "NO" ? " NOT NULL" : " NULL");

    if (stripos($extra, "auto_increment") === false)
        $sql .= tratar_default($type, $def, $col);

    if ($extra !== "") $sql .= " $extra";

    $sql .= ";";

    echo "<p>➕ $t → adicionar coluna <b>$col</b></p>" . btn($sql);
}

}


/* -------------------------- */
/*        ETAPA 4             */
/* -------------------------- */
if ($etapa == "colunas_remover") {

    echo "<h2>🗑️ Colunas a remover</h2>";

    $q4 = "
    SELECT table_name, column_name 
    FROM information_schema.columns 
    WHERE table_schema = ?
    ";
    $s4 = $conn_destino->prepare($q4);
    $s4->bind_param("s", $db_destino['db']);
    $s4->execute();
    $r4 = $s4->get_result();

    while ($c = $r4->fetch_assoc()) {
        $t = $c["table_name"];
        $col = $c["column_name"];

        if (!tabela_existe($conn_origem, $db_origem['db'], $t)) continue;
        if (colunaExiste($conn_origem, $db_origem['db'], $t, $col)) continue;

        echo "<p>🗑️ Remover coluna <b>$t.$col</b></p>" . btn("ALTER TABLE `$t` DROP COLUMN `$col`;");
    }
}

if ($etapa == "dados") {

    // ===============================
    // 1) Tabelas a sincronizar
    // ===============================
    $sync_tables = [
        "tb_acesso",
        "acesso_modulo",
        //"rel_master",
        //"tb_pessoa",
        //"tb_empresa",
        //"tb_caixa",
        //"tb_servico",
        "tb_estilo"
    ];

    echo "<h2>📌 Sincronizar Dados (" . implode(", ", $sync_tables) . ")</h2>";

    // ===============================
    // 2) Percorre cada tabela
    // ===============================
    foreach ($sync_tables as $tabela) {

        // segurança básica
        if (!tabela_existe($conn_origem,  $db_origem['db'],  $tabela)) continue;
        if (!tabela_existe($conn_destino, $db_destino['db'], $tabela)) continue;

        /* =====================================================
         * 3) Descobrir PK da tabela (pela origem)
         * ===================================================== */
        $pk_q = "
            SELECT column_name
            FROM information_schema.key_column_usage
            WHERE table_schema = ?
              AND table_name = ?
              AND constraint_name = 'PRIMARY'
        ";

        $spk = $conn_origem->prepare($pk_q);
        $spk->bind_param("ss", $db_origem['db'], $tabela);
        $spk->execute();
        $rpk = $spk->get_result();

        // tabela sem PK → ignora
        if ($rpk->num_rows == 0) continue;

        $pk = $rpk->fetch_assoc()['column_name'];

        /* =====================================================
         * 4) Buscar TODAS as PKs da ORIGEM
         * ===================================================== */
        $ids_origem = [];

        $ro = $conn_origem->query("
            SELECT `$pk`
            FROM `{$db_origem['db']}`.`$tabela`
        ");

        while ($r = $ro->fetch_assoc()) {
            $ids_origem[] = $r[$pk];
        }

        if (empty($ids_origem)) continue;

        /* =====================================================
         * 5) Buscar TODAS as PKs do DESTINO
         * ===================================================== */
        $ids_destino = [];

        $rd = $conn_destino->query("
            SELECT `$pk`
            FROM `{$db_destino['db']}`.`$tabela`
        ");

        while ($r = $rd->fetch_assoc()) {
            $ids_destino[] = $r[$pk];
        }

        /* =====================================================
         * 6) Descobrir registros faltantes (PHP)
         * ===================================================== */
        $faltantes = array_diff($ids_origem, $ids_destino);

        if (empty($faltantes)) continue;

        /* =====================================================
         * 7) Buscar dados completos da ORIGEM
         * ===================================================== */
        $lista = implode(",", array_map('intval', $faltantes));

        $rdiff = $conn_origem->query("
            SELECT *
            FROM `{$db_origem['db']}`.`$tabela`
            WHERE `$pk` IN ($lista)
        ");

        if (!$rdiff || $rdiff->num_rows == 0) continue;

        /* =====================================================
         * 8) Montar INSERT (multi-row)
         * ===================================================== */
        $cols_arr   = [];
        $values_sql = [];

        while ($row = $rdiff->fetch_assoc()) {

            if (!is_array($row)) continue;

            // captura colunas uma única vez
            if (empty($cols_arr)) {
                $cols_arr = array_keys($row);
            }

            $vals = [];
            foreach ($row as $v) {
                if ($v === null) {
                    $vals[] = "NULL";
                } else {
                    $vals[] = "'" . $conn_destino->real_escape_string($v) . "'";
                }
            }

            $values_sql[] = "(" . implode(",", $vals) . ")";
        }

        if (empty($values_sql)) continue;

        $cols = "`" . implode("`,`", $cols_arr) . "`";

        $sql_insert = "
            INSERT INTO `$tabela` ($cols)
            VALUES
            " . implode(",\n", $values_sql) . ";
        ";

        /* =====================================================
         * 9) Exibir botão (dry-run)
         * ===================================================== */
        echo "<p>➕ Inserir registros faltantes da tabela <b>$tabela</b></p>";
        echo btn(trim($sql_insert));
    }
}


if ($etapa == "acessos_permissoes") {

    echo "<h2>🪞 Espelhamento da tb_empresa (por CNPJ)</h2>";

    $tabela = "tb_empresa";
    $ignore_cols = ['cd_proprietario', 'cd_cliente_padrao'];

    if (!tabela_existe($conn_origem,  $db_origem['db'],  $tabela)) return;
    if (!tabela_existe($conn_destino, $db_destino['db'], $tabela)) return;

    /* =====================================================
     * 1) Descobrir PK
     * ===================================================== */
    $pk_q = "
        SELECT column_name
        FROM information_schema.key_column_usage
        WHERE table_schema = ?
          AND table_name = ?
          AND constraint_name = 'PRIMARY'
    ";
    $spk = $conn_destino->prepare($pk_q);
    $spk->bind_param("ss", $db_destino['db'], $tabela);
    $spk->execute();
    $pk = $spk->get_result()->fetch_assoc()['column_name'];

    /* =====================================================
     * 2) Buscar empresa na ORIGEM
     * ===================================================== */
    $cnpj = $conn_origem->real_escape_string($cnpj_destino);

    $ro = $conn_origem->query("
        SELECT *
        FROM {$db_origem['db']}.$tabela
        WHERE cnpj_empresa = '$cnpj'
        LIMIT 1
    ");

    if (!$ro || $ro->num_rows == 0) {
        echo "<p>❌ Empresa não encontrada na origem</p>";
        return;
    }

    $origem = $ro->fetch_assoc();

    /* =====================================================
     * 3) Verificar se existe no DESTINO
     * ===================================================== */
    $rd = $conn_destino->query("
        SELECT *
        FROM {$db_destino['db']}.$tabela
        WHERE cnpj_empresa = '$cnpj'
        LIMIT 1
    ");

    $destino = ($rd && $rd->num_rows) ? $rd->fetch_assoc() : null;

    /* =====================================================
     * 4) Coletar metadados de colunas
     * ===================================================== */
    $cols = [];
    $qcols = "
        SELECT column_name
        FROM information_schema.columns
        WHERE table_schema = ?
          AND table_name = ?
    ";

    $s = $conn_origem->prepare($qcols);
    $s->bind_param("ss", $db_origem['db'], $tabela);
    $s->execute();
    $r = $s->get_result();

    while ($c = $r->fetch_assoc())
        $cols[] = $c['column_name'];

    /* =====================================================
     * 5) GERAR INSERT ou UPDATE
     * ===================================================== */

    // ---------- INSERT ----------
    if (!$destino) {

        $fields = [];
        $values = [];

        foreach ($cols as $col) {
            if ($col === $pk || in_array($col, $ignore_cols)) continue;

            $fields[] = "`$col`";

            $v = $origem[$col];
            $values[] = ($v === null)
                ? "NULL"
                : "'" . $conn_destino->real_escape_string($v) . "'";
        }

        $sql = "
            INSERT INTO `$tabela`
            (" . implode(", ", $fields) . ")
            VALUES
            (" . implode(", ", $values) . ");
        ";

        echo "<p>➕ Inserir empresa no destino</p>";
        echo btn(trim($sql));
        return;
    }

    // ---------- UPDATE ----------
    $set = [];

    foreach ($cols as $col) {

        if ($col === $pk || in_array($col, $ignore_cols)) continue;

        $vo = $origem[$col];
        $vd = $destino[$col];

        if (
            ($vo === null && $vd !== null) ||
            ($vo !== null && $vd === null) ||
            ((string)$vo !== (string)$vd)
        ) {
            $set[] = ($vo === null)
                ? "`$col` = NULL"
                : "`$col` = '" . $conn_destino->real_escape_string($vo) . "'";
        }
    }

    if (empty($set)) {
        echo "<p>✅ Empresa já está sincronizada</p>";
        return;
    }

    $sql = "
        UPDATE `$tabela`
        SET
            " . implode(",\n            ", $set) . "
        WHERE cnpj_empresa = '$cnpj';
    ";

    echo "<p>🔄 Atualizar empresa existente</p>";
    echo btn(trim($sql));
}


if ($etapa == "rel_master") {

    echo "<h2>🪞 Espelhamento da rel_master (empresa existente em ambas as bases)</h2>";

    $tabela = "rel_master";
    $ignore_cols = ['cd_proprietario', 'cd_cliente_padrao']; // Colunas que não quer atualizar

    // Segurança: verifica se as tabelas existem
    if (!tabela_existe($conn_origem,  $db_origem['db'],  $tabela)) return;
    if (!tabela_existe($conn_destino, $db_destino['db'], $tabela)) return;

    /* =====================================================
     * 1) Descobrir PK da tabela rel_master
     * ===================================================== */
    $pk_q = "
        SELECT column_name
        FROM information_schema.key_column_usage
        WHERE table_schema = ?
          AND table_name = ?
          AND constraint_name = 'PRIMARY'
    ";
    $spk = $conn_destino->prepare($pk_q);
    $spk->bind_param("ss", $db_destino['db'], $tabela);
    $spk->execute();
    $rpk = $spk->get_result();
    if ($rpk->num_rows == 0) return;

    $pk = $rpk->fetch_assoc()['column_name'];

    /* =====================================================
     * 2) Buscar os registros existentes no destino
     * ===================================================== */
    $res_dest = $conn_destino->query("SELECT `$pk`, cd_empresa FROM `$tabela` LIMIT 1");
    if (!$res_dest || $res_dest->num_rows == 0) return;

    $row_dest   = $res_dest->fetch_assoc();
    $registro_id = $row_dest[$pk];
    $cd_empresa  = $row_dest['cd_empresa'];

    echo "<p>🏢 Registro destino: <b>$pk = $registro_id</b><br>cd_empresa: <b>$cd_empresa</b></p>";

    /* =====================================================
     * 3) Validar estrutura (ALTER TABLE)
     * ===================================================== */
    $qcols = "
        SELECT column_name, column_type, is_nullable,
               column_default, extra
        FROM information_schema.columns
        WHERE table_schema = ?
          AND table_name = ?
    ";

    // colunas origem
    $so = $conn_origem->prepare($qcols);
    $so->bind_param("ss", $db_origem['db'], $tabela);
    $so->execute();
    $ro = $so->get_result();

    // colunas destino
    $sd = $conn_destino->prepare($qcols);
    $sd->bind_param("ss", $db_destino['db'], $tabela);
    $sd->execute();
    $rd = $sd->get_result();

    $cols_origem  = [];
    $cols_destino = [];

    while ($c = $ro->fetch_assoc())
        $cols_origem[$c['column_name']] = $c;

    while ($c = $rd->fetch_assoc())
        $cols_destino[$c['column_name']] = $c;

    $alter = [];

    foreach ($cols_origem as $col => $o) {

        $null  = ($o['is_nullable'] == 'NO') ? 'NOT NULL' : 'NULL';
        $def   = tratar_default($o['column_type'], $o['column_default'], $col);
        $extra = $o['extra'];

        if (!isset($cols_destino[$col])) {
            $alter[] = "ADD `$col` {$o['column_type']} $null $def $extra";
            continue;
        }

        $d = $cols_destino[$col];

        if (
            $o['column_type']    !== $d['column_type'] ||
            $o['is_nullable']    !== $d['is_nullable'] ||
            $o['column_default'] != $d['column_default']
        ) {
            $alter[] = "MODIFY `$col` {$o['column_type']} $null $def $extra";
        }
    }

    if (!empty($alter)) {
        $sql = "ALTER TABLE `$tabela`\n" . implode(",\n", $alter) . ";";
        echo "<p>🧱 Ajustar estrutura da rel_master</p>";
        echo btn($sql);
    }

    /* =====================================================
     * 4) Validar dados (UPDATE apenas se diferente, pelo cd_empresa)
     * ===================================================== */
    $sql_origem = "
        SELECT *
        FROM {$db_origem['db']}.$tabela
        WHERE cd_empresa = '{$conn_origem->real_escape_string($cd_empresa)}'
        LIMIT 1
    ";

    $sql_destino = "
        SELECT *
        FROM {$db_destino['db']}.$tabela
        WHERE `$pk` = '$registro_id'
    ";

    $ro = $conn_origem->query($sql_origem);
    $rd = $conn_destino->query($sql_destino);

    if (!$ro || !$rd || $ro->num_rows == 0 || $rd->num_rows == 0) {
        echo "<p>❌ Registro correspondente NÃO encontrado na origem</p>";
        return;
    }

    $origem  = $ro->fetch_assoc();
    $destino = $rd->fetch_assoc();

    $set = [];

    foreach ($cols_origem as $col => $meta) {

        if ($col === $pk || in_array($col, $ignore_cols)) continue;

        $vo = $origem[$col];
        $vd = $destino[$col];

        if (
            ($vo === null && $vd !== null) ||
            ($vo !== null && $vd === null) ||
            ((string)$vo !== (string)$vd)
        ) {
            if ($vo === null)
                $set[] = "`$col` = NULL";
            else
                $set[] = "`$col` = '" . $conn_destino->real_escape_string($vo) . "'";
        }
    }

    if (empty($set)) {
        echo "<p>✅ Dados da rel_master já estão espelhados</p>";
        return;
    }

    $sql_up = "
        UPDATE `$tabela`
        SET
            " . implode(",\n            ", $set) . "
        WHERE `$pk` = '$registro_id';
    ";

    echo "<p>🔄 Atualizar dados do registro <b>$registro_id</b></p>";
    echo btn(trim($sql_up));
}


if ($etapa == "merge_rel_master_") {

    echo "<h2>🔄 Merge de rel_master do destino para a origem</h2>";

    $tabela = "rel_master";
    $ignore_cols = ['cd_rel_seq_1']; // Coluna que será preenchida com cd_rel do destino

    // Segurança: verifica se as tabelas existem
    if (!tabela_existe($conn_origem,  $db_origem['db'],  $tabela)) return;
    if (!tabela_existe($conn_destino, $db_destino['db'], $tabela)) return;

    /* =====================================================
     * 1) Descobrir PK da tabela
     * ===================================================== */
    $pk_q = "
        SELECT column_name
        FROM information_schema.key_column_usage
        WHERE table_schema = ?
          AND table_name = ?
          AND constraint_name = 'PRIMARY'
    ";
    $spk = $conn_origem->prepare($pk_q);
    $spk->bind_param("ss", $db_origem['db'], $tabela);
    $spk->execute();
    $rpk = $spk->get_result();
    if ($rpk->num_rows == 0) return;

    $pk = $rpk->fetch_assoc()['column_name'];

    /* =====================================================
     * 2) Buscar todos os registros do destino
     * ===================================================== */
    $sql_dest = "SELECT * FROM {$db_destino['db']}.$tabela";
    $res_dest = $conn_destino->query($sql_dest);

    if (!$res_dest || $res_dest->num_rows == 0) {
        echo "<p>❌ Nenhum registro encontrado no destino</p>";
        return;
    }

    echo "<p>📥 Total de registros no destino: {$res_dest->num_rows}</p>";

    /* =====================================================
     * 3) Buscar estrutura das colunas
     * ===================================================== */
    $qcols = "
        SELECT column_name, column_type, is_nullable,
               column_default, extra
        FROM information_schema.columns
        WHERE table_schema = ?
          AND table_name = ?
    ";

    $so = $conn_origem->prepare($qcols);
    $so->bind_param("ss", $db_origem['db'], $tabela);
    $so->execute();
    $ro = $so->get_result();

    $cols_origem = [];
    while ($c = $ro->fetch_assoc())
        $cols_origem[$c['column_name']] = $c;

    /* =====================================================
     * 4) Loop para inserir ou atualizar cada registro
     * ===================================================== */
    while ($row_dest = $res_dest->fetch_assoc()) {

        // Mapeamento especial: cd_rel do destino → cd_rel_seq_1 da origem
        $row_origem = [];
        foreach ($cols_origem as $col => $meta) {
            if ($col === 'cd_rel_seq_1') {
                $row_origem[$col] = $row_dest['cd_rel'];
            } elseif (isset($row_dest[$col])) {
                $row_origem[$col] = $row_dest[$col];
            } else {
                $row_origem[$col] = null;
            }
        }

        // Determinar se já existe na origem (vamos usar cd_empresa + algum critério se necessário)
        $where = "cd_empresa = '" . $conn_origem->real_escape_string($row_origem['cd_empresa']) . "'";
        $check_sql = "SELECT `$pk` FROM {$db_origem['db']}.$tabela WHERE $where LIMIT 1";
        $res_check = $conn_origem->query($check_sql);

        if ($res_check && $res_check->num_rows > 0) {
            // UPDATE
            $dest_row = $res_check->fetch_assoc();
            $set = [];
            foreach ($row_origem as $col => $val) {
                if ($col === $pk) continue; // não atualiza PK
                if ($val === null) {
                    $set[] = "`$col` = NULL";
                } else {
                    $set[] = "`$col` = '" . $conn_origem->real_escape_string($val) . "'";
                }
            }
            if (!empty($set)) {
                $sql_up = "UPDATE {$db_origem['db']}.$tabela SET " . implode(", ", $set) . " WHERE `$pk` = '{$dest_row[$pk]}'";
                $conn_origem->query($sql_up);
                echo "<p>✏️ Atualizado registro {$dest_row[$pk]}</p>";
            }
        } else {
            // INSERT
            $cols = array_keys($row_origem);
            $vals = array_map(function($v) use ($conn_origem) {
                return $v === null ? "NULL" : "'" . $conn_origem->real_escape_string($v) . "'";
            }, array_values($row_origem));

            $sql_in = "INSERT INTO {$db_origem['db']}.$tabela (`" . implode("`,`", $cols) . "`) VALUES (" . implode(",", $vals) . ")";
            $conn_origem->query($sql_in);
            echo "<p>➕ Inserido registro cd_empresa={$row_origem['cd_empresa']}</p>";
        }
    }

    echo "<p>✅ Merge concluído!</p>";
}



if ($etapa == "merge_rel_master") {

    echo "<h2>🔄 Merge de rel_master (Preview SQL)</h2>";

    $tabela = "rel_master";
    $ignore_cols = ['cd_rel_seq_1']; // Coluna que será preenchida com cd_rel do destino

    if (!tabela_existe($conn_origem,  $db_origem['db'],  $tabela)) return;
    if (!tabela_existe($conn_destino, $db_destino['db'], $tabela)) return;

    // Descobrir PK
    $pk_q = "
        SELECT column_name
        FROM information_schema.key_column_usage
        WHERE table_schema = ?
          AND table_name = ?
          AND constraint_name = 'PRIMARY'
    ";
    $spk = $conn_origem->prepare($pk_q);
    $spk->bind_param("ss", $db_origem['db'], $tabela);
    $spk->execute();
    $rpk = $spk->get_result();
    if ($rpk->num_rows == 0) return;
    $pk = $rpk->fetch_assoc()['column_name'];

    // Buscar todos registros do destino
    $res_dest = $conn_destino->query("SELECT * FROM {$db_destino['db']}.$tabela");
    if (!$res_dest || $res_dest->num_rows == 0) {
        echo "<p>❌ Nenhum registro encontrado no destino</p>";
        return;
    }

    echo "<p>📥 Total de registros no destino: {$res_dest->num_rows}</p>";

    // Estrutura da tabela na origem
    $qcols = "
        SELECT column_name, column_type, is_nullable, column_default, extra
        FROM information_schema.columns
        WHERE table_schema = ?
          AND table_name = ?
    ";
    $so = $conn_origem->prepare($qcols);
    $so->bind_param("ss", $db_origem['db'], $tabela);
    $so->execute();
    $ro = $so->get_result();
    $cols_origem = [];
    while ($c = $ro->fetch_assoc())
        $cols_origem[$c['column_name']] = $c;

    // Loop nos registros do destino
    while ($row_dest = $res_dest->fetch_assoc()) {

        // Preparar dados para origem
        $row_origem = [];
        foreach ($cols_origem as $col => $meta) {
            if ($col === 'cd_rel_seq_1') {
                $row_origem[$col] = $row_dest['cd_rel']; // Mapeamento especial
            } elseif (isset($row_dest[$col])) {
                $row_origem[$col] = $row_dest[$col];
            } else {
                $row_origem[$col] = null;
            }
        }

        // Checar se já existe na origem
        $where = "cd_empresa = '" . $conn_origem->real_escape_string($row_origem['cd_empresa']) . "'";
        $check_sql = "SELECT `$pk` FROM {$db_origem['db']}.$tabela WHERE $where LIMIT 1";
        $res_check = $conn_origem->query($check_sql);

        if ($res_check && $res_check->num_rows > 0) {
            // UPDATE
            $dest_row = $res_check->fetch_assoc();
            $set = [];
            foreach ($row_origem as $col => $val) {
                if ($col === $pk) continue;
                $set[] = $val === null ? "`$col` = NULL" : "`$col` = '" . $conn_origem->real_escape_string($val) . "'";
            }
            if (!empty($set)) {
                $sql_up = "UPDATE {$db_origem['db']}.$tabela SET " . implode(", ", $set) . " WHERE `$pk` = '{$dest_row[$pk]}'";
                echo "<p>✏️ SQL UPDATE para registro cd_empresa={$row_origem['cd_empresa']}</p>";
                echo btn(trim($sql_up)); // botão para executar
            }
        } else {
            // INSERT
            $cols = array_keys($row_origem);
            $vals = array_map(function($v) use ($conn_origem) {
                return $v === null ? "NULL" : "'" . $conn_origem->real_escape_string($v) . "'";
            }, array_values($row_origem));

            $sql_in = "INSERT INTO {$db_origem['db']}.$tabela (`" . implode("`,`", $cols) . "`) VALUES (" . implode(",", $vals) . ")";
            echo "<p>➕ SQL INSERT para registro cd_empresa={$row_origem['cd_empresa']}</p>";
            echo btn(trim($sql_in)); // botão para executar
        }
    }

    echo "<p>✅ Preview SQL completo!</p>";
}




if ($etapa == "acessos_rel_master") {

    echo "<h2>🔐 Espelhamento de acessos (rel_master.acesso_*)</h2>";

    $tabela = "rel_master";

    if (!tabela_existe($conn_origem,  $db_origem['db'],  $tabela)) return;
    if (!tabela_existe($conn_destino, $db_destino['db'], $tabela)) return;

    /* =====================================================
     * 1) Descobrir cd_empresa pela tb_empresa
     * ===================================================== */
    $cnpj = preg_replace('/\D/', '', $cnpj_destino);

    $qe = "
        SELECT cd_empresa
        FROM {$db_origem['db']}.tb_empresa
        WHERE REPLACE(REPLACE(REPLACE(cnpj_empresa,'.',''),'-',''),'/','') = '$cnpj'
        LIMIT 1
    ";

    $re = $conn_origem->query($qe);

    if (!$re || $re->num_rows == 0) {
        echo "<p>❌ cd_empresa não encontrado na origem</p>";
        return;
    }

    $cd_empresa = $re->fetch_assoc()['cd_empresa'];

    /* =====================================================
     * 2) Buscar rel_master na ORIGEM
     * ===================================================== */
    $ro = $conn_origem->query("
        SELECT *
        FROM {$db_origem['db']}.$tabela
        WHERE cd_empresa = '$cd_empresa'
        LIMIT 1
    ");

    if (!$ro || $ro->num_rows == 0) {
        echo "<p>❌ rel_master não encontrado na origem</p>";
        return;
    }

    $origem = $ro->fetch_assoc();

    /* =====================================================
     * 3) Buscar rel_master no DESTINO
     * ===================================================== */
    $rd = $conn_destino->query("
        SELECT *
        FROM {$db_destino['db']}.$tabela
        WHERE cd_empresa = '$cd_empresa'
        LIMIT 1
    ");

    if (!$rd || $rd->num_rows == 0) {
        echo "<p>❌ rel_master não encontrado no destino</p>";
        return;
    }

    $destino = $rd->fetch_assoc();

    /* =====================================================
     * 4) Descobrir colunas acesso_*
     * ===================================================== */
    $cols = [];

    $qcols = "
        SELECT column_name
        FROM information_schema.columns
        WHERE table_schema = ?
          AND table_name = ?
          AND column_name LIKE 'acesso_%'
    ";

    $s = $conn_origem->prepare($qcols);
    $s->bind_param("ss", $db_origem['db'], $tabela);
    $s->execute();
    $r = $s->get_result();

    while ($c = $r->fetch_assoc())
        $cols[] = $c['column_name'];

    if (empty($cols)) {
        echo "<p>⚠️ Nenhuma coluna acesso_* encontrada</p>";
        return;
    }

    /* =====================================================
     * 5) Gerar UPDATE apenas do que está vazio no destino
     * ===================================================== */
    $set = [];

    foreach ($cols as $col) {

        $vo = $origem[$col] ?? null;
        $vd = $destino[$col] ?? null;

        $destino_vazio = ($vd === null || $vd === '');

        if ($destino_vazio && $vo !== null && $vo !== '') {

            $set[] = "`$col` = '" . $conn_destino->real_escape_string($vo) . "'";
        }
    }

    if (empty($set)) {
        echo "<p>✅ Todos os acessos já estão preenchidos</p>";
        return;
    }

    $sql = "
        UPDATE `$tabela`
        SET
            " . implode(",\n            ", $set) . "
        WHERE cd_empresa = '$cd_empresa';
    ";

    echo "<p>🪞 Completar acessos faltantes no destino</p>";
    echo btn(trim($sql));
}




echo "<br><hr><p style='color:#555'>✓ Sistema de Sincronização ativo.</p>";
}
?>
