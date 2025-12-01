<?php

/* CONFIG ORIGEM */

$db_origem = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "db"   => "assistent_master"
];

/*
$db_origem = [
    "host" => "as_08057969.mysql.dbaas.com.br",
    "user" => "as_08057969",
    "pass" => "GGA@20002021g",
    "db"   => "as_08057969"
];
*/

/* CONFIG DESTINO */

/*
$db_destino = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "db"   => "ass_08057969"
];
*/

$db_destino = [
    "host" => "ass_08057969.mysql.dbaas.com.br",
    "user" => "ass_08057969",
    "pass" => "GGA@20002021g",
    "db"   => "ass_08057969"
];


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

/* VERIFICAÇÃO SEGURA DE COLUNA EXISTENTE */
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

/* FUNÇÃO PARA PADRÕES DEFAULT */
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

echo "<h1>Sincronizar Estrutura: {$db_origem['db']} → {$db_destino['db']}</h1>";

/* ============ FUNÇÕES DE METADADOS ============= */

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

/* ============ 1) Criar tabelas faltando ============= */

$q = "SELECT table_name FROM information_schema.tables WHERE table_schema = ?";
$st = $conn_origem->prepare($q);
$st->bind_param("s", $db_origem['db']);
$st->execute();
$res = $st->get_result();

echo "<h2>📌 Tabelas faltando</h2>";

while ($r = $res->fetch_assoc()) {
    $t = $r['table_name'];

    if (tabela_existe($conn_destino, $db_destino['db'], $t)) continue;

    $show = $conn_origem->query("SHOW CREATE TABLE `$t`");
    $row = $show->fetch_assoc();
    $sql = $row['Create Table'] . ";";

    echo "<p>➕ Criar tabela <b>$t</b></p>" . btn($sql);
}

/* ============ 2) Remover tabelas extras ============= */

$q2 = "SELECT table_name FROM information_schema.tables WHERE table_schema = ?";
$s2 = $conn_destino->prepare($q2);
$s2->bind_param("s", $db_destino['db']);
$s2->execute();
$rd = $s2->get_result();

echo "<h2>🗑️ Tabelas a remover</h2>";

while ($r = $rd->fetch_assoc()) {
    $t = $r['table_name'];

    if (tabela_existe($conn_origem, $db_origem['db'], $t)) continue;

    echo "<p>🗑️ Remover tabela <b>$t</b></p>" . btn("DROP TABLE `$t`;");
}

/* ============ 3) Colunas faltando ============= */

echo "<h2>📌 Colunas faltando</h2>";

$q3 = "
    SELECT o.table_name, o.column_name, o.column_type, o.is_nullable,
           o.column_default, o.extra
    FROM information_schema.columns o
    WHERE o.table_schema = ?
";
$s3 = $conn_origem->prepare($q3);
$s3->bind_param("s", $db_origem['db']);
$s3->execute();
$r3 = $s3->get_result();

while ($c = $r3->fetch_assoc()) {

    $t  = $c["table_name"];
    $col = $c["column_name"];

    if (!tabela_existe($conn_destino, $db_destino['db'], $t)) continue;

    if (colunaExiste($conn_destino, $db_destino['db'], $t, $col)) continue;

    $type = $c["column_type"];
    $null = $c["is_nullable"];
    $def = $c["column_default"];
    $extra = $c["extra"];

    $sql = "ALTER TABLE `$t` ADD COLUMN `$col` $type";
    $sql .= ($null == "NO" ? " NOT NULL" : " NULL");

    if (stripos($extra, "auto_increment") === false)
        $sql .= tratar_default($type, $def, $col);

    if ($extra !== "")
        $sql .= " $extra";

    $sql .= ";";

    echo "<p>➕ $t → adicionar coluna <b>$col</b></p>" . btn($sql);
}

/* ============ 4) Remover colunas extras ============= */

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

/* ============ 5) Sincronizar dados (suporte) ============= */

echo "<h2>📌 Sincronizar Dados (tb_acesso, rel_master)</h2>";

$sync_tables = ["tb_acesso", "rel_master"];

foreach ($sync_tables as $tabela) {

    if (!tabela_existe($conn_origem, $db_origem['db'], $tabela)) continue;

    echo "<h3>$tabela</h3>";

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

    if ($rpk->num_rows == 0) continue;

    $pk = $rpk->fetch_assoc()["column_name"];

    $diff = "
        SELECT * FROM `$tabela` o
        WHERE NOT EXISTS (
            SELECT 1 FROM {$db_destino['db']}.$tabela d
            WHERE d.$pk = o.$pk
        )
    ";

    $rdiff = $conn_origem->query($diff);

    while ($row = $rdiff->fetch_assoc()) {

        $cols = "`" . implode("`,`", array_keys($row)) . "`";
        $vals = implode(",", array_map(fn($v) => $v === null ? "NULL" : "'" . addslashes($v) . "'", array_values($row)));

        $sql = "INSERT INTO `$tabela` ($cols) VALUES ($vals);";

        echo "<p>➕ Inserir $pk <b>{$row[$pk]}</b></p>" . btn($sql);
    }
}

echo "<br><hr><p style='color:#555'>✓ Sistema de Sincronização corrigido e estável.</p>";
?>

