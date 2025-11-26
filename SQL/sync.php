<?php

/* CONFIG ORIGEM */
$db_origem = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "db"   => "assistent_master"
];
/*$db_origem = [
    "host" => "ass_geral.mysql.dbaas.com.br",
    "user" => "ass_geral",
    "pass" => "GGA@20002021g",
    "db"   => "ass_geral"
];*/

/* CONFIG DESTINO */
$db_destino = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "db"   => "ass_08057969"
];

/* CONEXÕES */
$conn_origem = new mysqli(
    $db_origem["host"], $db_origem["user"], $db_origem["pass"], $db_origem["db"]
);
if ($conn_origem->connect_error) die("Erro origem: " . $conn_origem->connect_error);

$conn_destino = new mysqli(
    $db_destino["host"], $db_destino["user"], $db_destino["pass"], $db_destino["db"]
);
if ($conn_destino->connect_error) die("Erro destino: " . $conn_destino->connect_error);


/* BOTÃO LIMPAR CACHE */
echo '<button onclick="location.href=location.pathname+\'?t=\'+Date.now()" 
        style="padding:6px 12px;background:#ffc107;border:0;border-radius:4px;margin-bottom:15px;cursor:pointer;">
        🧹 Limpar Cache da Tela
      </button>';


/* BOTÃO EXECUTAR */
function btn($sql) {
    return "<form method='post' style='display:inline-block;margin-left:10px'>
                <input type='hidden' name='sql' value=\"" . htmlspecialchars($sql) . "\">
                <button style='padding:5px 10px;background:#007bff;border:0;color:white;border-radius:4px;cursor:pointer;'>Aplicar</button>
            </form>";
}

/* EXECUTAR SQL */
if (isset($_POST["sql"])) {
    global $conn_destino;
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


/* FUNÇÃO DEFAULT */
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





/* =======================================================
   1) TABELAS FALTANDO
======================================================= */


$q = "
SELECT table_name FROM information_schema.tables
WHERE table_schema='{$db_origem['db']}'
AND table_name NOT IN (
    SELECT table_name FROM information_schema.tables WHERE table_schema='{$db_destino['db']}'
)
";

$res = $conn_origem->query($q);

if ($res->num_rows == 0) echo "<p>Nenhuma tabela faltando.</p>";
else {echo "<h2>📌 Tabelas faltando</h2>";}
while ($r = $res->fetch_assoc()) {
    
    $t = $r["table_name"];
    $sql = "CREATE TABLE `{$db_destino['db']}`.`$t` LIKE `{$db_origem['db']}`.`$t`;";
    echo "<p>➕ Criar tabela <b>$t</b> " . btn($sql) . "</p>";
}

/* =======================================================
   2) REMOVER TABELAS QUE NÃO EXISTEM NA ORIGEM
======================================================= */


$q = "
SELECT table_name FROM information_schema.tables
WHERE table_schema='{$db_destino['db']}'
AND table_name NOT IN (
    SELECT table_name FROM information_schema.tables WHERE table_schema='{$db_origem['db']}'
)
";

$res = $conn_destino->query($q);

if ($res->num_rows == 0) {
    echo "<p>Nenhuma tabela extra encontrada.</p>";
} else {
    echo "<h2>🗑️ Tabelas a remover</h2>";
    while ($r = $res->fetch_assoc()) {
        $t = $r["table_name"];
        $sql = "DROP TABLE `{$db_destino['db']}`.`$t`;";
        echo "<p>🗑️ Remover tabela <b>$t</b> " . btn($sql) . "</p>";
    }
}





/* =======================================================
   3) COLUNAS FALTANDO
======================================================= */


$q = "
SELECT c.table_name, c.column_name, c.column_type,
       c.is_nullable, c.column_default, c.extra
FROM information_schema.columns c
WHERE c.table_schema='{$db_origem['db']}'
AND NOT EXISTS (
    SELECT 1 FROM information_schema.columns 
    WHERE table_schema='{$db_destino['db']}'
    AND table_name=c.table_name
    AND column_name=c.column_name
)
ORDER BY c.table_name, c.ordinal_position
";

$res = $conn_origem->query($q);

if ($res->num_rows == 0) echo "<p>Nenhuma coluna faltando.</p>";
else while ($c = $res->fetch_assoc()) {
    echo "<h2>📌 Colunas faltando</h2>";

    $t = $c["table_name"];
    $col = $c["column_name"];
    $type = $c["column_type"];
    $null = $c["is_nullable"];
    $def = $c["column_default"];
    $extra = $c["extra"];

    if (in_array($col, ["cd_empresa","cd_filial", "cd_matriz"])) {
        $def = 1;
        $null = "NO";
    }
    if (in_array($col, ["md_assistencia", "md_venda", "md_comissao", "md_financeiro", "md_cadastros", "md_folhaponto", "md_patrimonio"])) {
        $def = "999";
        $null = "NO";
    }

    $sql = "ALTER TABLE `{$db_destino['db']}`.`$t` ADD COLUMN `$col` $type";
    $sql .= ($null==="NO"?" NOT NULL":" NULL");
    $sql .= tratar_default($type,$def,$col);
    if ($extra) $sql .= " $extra";
    $sql .= ";";

    echo "<p>➕ $t → adicionar coluna <b>$col</b> ($type) " . btn($sql) . "</p>";
}


/* =======================================================
   4) REMOVER COLUNAS QUE NÃO EXISTEM NA ORIGEM
======================================================= */


$q = "
SELECT c.table_name, c.column_name
FROM information_schema.columns c
WHERE c.table_schema='{$db_destino['db']}'
AND NOT EXISTS (
    SELECT 1 FROM information_schema.columns o
    WHERE o.table_schema='{$db_origem['db']}'
    AND o.table_name=c.table_name
    AND o.column_name=c.column_name
)
";

$res = $conn_destino->query($q);

if ($res->num_rows == 0) echo "<p>Nenhuma coluna extra encontrada.</p>";
else while ($c = $res->fetch_assoc()) {
    echo "<h2>🗑️ Colunas a remover</h2>";
    $t = $c["table_name"];
    $col = $c["column_name"];

    $sql = "ALTER TABLE `{$db_destino['db']}`.`$t` DROP COLUMN `$col`;";
    echo "<p>🗑️ Remover coluna <b>$t.$col</b> " . btn($sql) . "</p>";
}

/* =======================================================
   5) COLUNAS DIFERENTES (somente tipo + tamanho)
======================================================= */


$q = "
SELECT c1.table_name, c1.column_name, c1.column_type AS type_o, c2.column_type AS type_d
FROM information_schema.columns c1
JOIN information_schema.columns c2
ON c1.table_name=c2.table_name AND c1.column_name=c2.column_name
WHERE c1.table_schema='{$db_origem['db']}'
AND c2.table_schema='{$db_destino['db']}'
AND c1.column_type <> c2.column_type
";

$res = $conn_origem->query($q);

if ($res->num_rows == 0) echo "<p>Nenhuma diferença encontrada entre as colunas.</p>";
else while ($c = $res->fetch_assoc()) {
    echo "<h2>📌 Colunas diferentes (tipo + tamanho)</h2>";

    $t = $c["table_name"];
    $col = $c["column_name"];
    $type = $c["type_o"];

    $sql = "ALTER TABLE `{$db_destino['db']}`.`$t` MODIFY `$col` $type;";
    echo "<p>🔧 Ajustar $t.$col — Origem: <code>{$c['type_o']}</code> / Destino: <code>{$c['type_d']}</code> " . btn($sql) . "</p>";
}



/* =======================================================
   6) SINCRONIZAR DADOS
======================================================= */
echo "<h2>📌 Sincronizar Dados (tb_acesso, rel_master)</h2>";

$tables_sync = ["tb_acesso", "rel_master"];

foreach ($tables_sync as $tabela) {

    echo "<h3>📂 $tabela</h3>";

    $pk_q = "
        SELECT column_name FROM information_schema.key_column_usage
        WHERE table_schema='{$db_origem['db']}'
        AND table_name='$tabela'
        AND constraint_name='PRIMARY'
    ";
    $pk_r = $conn_origem->query($pk_q);

    if ($pk_r->num_rows == 0) {
        echo "<p style='color:red'>⚠ Tabela sem PK: ignorada.</p>";
        continue;
    }

    $pk = $pk_r->fetch_assoc()["column_name"];

    $diff_q = "
        SELECT * FROM `{$db_origem['db']}`.`$tabela` o
        WHERE NOT EXISTS (
            SELECT 1 FROM `{$db_destino['db']}`.`$tabela` d
            WHERE d.`$pk` = o.`$pk`
        )
    ";

    $diff_r = $conn_origem->query($diff_q);

    if ($diff_r->num_rows == 0) {
        echo "<p>✔ Nenhum registro faltando.</p>";
        continue;
    }

    echo "<p>➕ Registros a inserir: <b>{$diff_r->num_rows}</b></p>";

    while ($row = $diff_r->fetch_assoc()) {

        $cols = "`" . implode("`,`", array_keys($row)) . "`";
        $vals = implode(",", array_map(function($v){
            return $v === null ? "NULL" : "'" . addslashes($v) . "'";
        }, array_values($row)));

        $sql = "INSERT INTO `{$db_destino['db']}`.`$tabela` ($cols) VALUES ($vals);";

        echo "<p>🔹 Inserir PK <b>{$row[$pk]}</b> " . btn($sql) . "</p>";
    }
}



echo "<br><hr><p style='color:#555'>Ferramenta de Sincronização — versão completa com remover + criar + ajustar + sincronizar.</p>";

?>
