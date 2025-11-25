<?php

/* CONFIG ORIGEM */
$db_origem = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "db"   => "assistent_master"
];

/* CONFIG DESTINO */
$db_destino = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "db"   => "ass_08057969"
];

/* Charset e Collation desejado no destino */
$charset = "utf8mb4";
$collate = "utf8mb4_general_ci";

/* CONEXÃO ORIGEM */
$conn_o = new mysqli(
    $db_origem["host"], 
    $db_origem["user"], 
    $db_origem["pass"], 
    $db_origem["db"]
);
if ($conn_o->connect_error) { die("Erro na origem: " . $conn_o->connect_error); }

/* CONEXÃO DESTINO */
$conn_d = new mysqli(
    $db_destino["host"], 
    $db_destino["user"], 
    $db_destino["pass"], 
    $db_destino["db"]
);
if ($conn_d->connect_error) { die("Erro no destino: " . $conn_d->connect_error); }

/* BOTÃO PARA LIMPAR CACHE */
echo '<button onclick="window.location.href=window.location.pathname+\'?t=\'+new Date().getTime();" style="
        padding:5px 10px;
        background:#ffc107;
        color:black;
        border:0;
        border-radius:4px;
        cursor:pointer;
        margin-bottom:15px;
    ">
    🧹 Limpar Cache da Tela
</button>';

/* BOTÃO DE EXECUÇÃO */
function btn($sql) {
    return "
    <form method='post' style='display:inline-block;margin-top:5px'>
        <input type='hidden' name='sql' value=\"" . htmlspecialchars($sql) . "\">
        <button style='padding:5px 10px;background:#007bff;color:white;border:0;border-radius:4px;cursor:pointer;'>Aplicar</button>
    </form>";
}

/* EXECUÇÃO DOS ALTER TABLE */
if (isset($_POST["sql"])) {
    global $conn_d;
    $sql = $_POST["sql"];
    if ($conn_d->query($sql)) {
        echo "<div style='padding:10px;background:#c8ffc8;border:1px solid #0a0'>
                ✔ Executado com sucesso:<br><code>$sql</code>
              </div><br>";
    } else {
        echo "<div style='padding:10px;background:#ffc8c8;border:1px solid #a00'>
                ❌ Erro:<br>" . $conn_d->error . "<br><br><code>$sql</code>
              </div><br>";
    }
}

/* TÍTULO */
echo "<h1>Sincronizar Estrutura: {$db_origem['db']} → {$db_destino['db']}</h1>";

/* FUNÇÃO DEFAULT */
function tratar_default($type, $default, $col = "") {
    $type = strtolower($type);

    if (in_array($col, ["cd_empresa", "cd_filial", "cd_matriz"])) {
        return " DEFAULT 1";
    }

    if ($default === null || $default === "") {
        if (preg_match('/int|decimal|float|double/', $type)) return " DEFAULT 0";
        if (strpos($type,"date")!==false) return " DEFAULT NULL";
        return "";
    }

    if (strpos($type,"text")!==false || strpos($type,"blob")!==false) {
        return "";
    }

    if (preg_match('/int|decimal|float|double/', $type))
        return " DEFAULT " . $default;

    return " DEFAULT '" . addslashes($default) . "'";
}

/* ============================================
   1) TABELAS FALTANDO
   ============================================ */
echo "<h2>📌 Tabelas faltando em {$db_destino['db']}</h2>";

$q = "
SELECT table_name FROM information_schema.tables 
WHERE table_schema='{$db_origem['db']}'
AND table_name NOT IN (
    SELECT table_name FROM information_schema.tables WHERE table_schema='{$db_destino['db']}'
)";
$res = $conn_o->query($q);

if ($res->num_rows == 0) {
    echo "<p>Nenhuma tabela faltando.</p>";
} else {
    while ($r = $res->fetch_assoc()) {
        $t = $r["table_name"];
        $sql = "CREATE TABLE `{$db_destino['db']}`.`$t` LIKE `{$db_origem['db']}`.`$t`;";
        echo "<p>➕ Criar tabela <b>$t</b> ".btn($sql)."</p>";
    }
}

/* ============================================
   2) COLUNAS FALTANDO
   ============================================ */
echo "<h2>📌 Colunas faltando em {$db_destino['db']}</h2>";

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
ORDER BY c.table_name, c.ordinal_position";
$res = $conn_o->query($q);

if ($res->num_rows == 0) {
    echo "<p>Nenhuma coluna faltando.</p>";
} else {
    while ($c = $res->fetch_assoc()) {

        $t = $c["table_name"];
        $col = $c["column_name"];
        $type = $c["column_type"];
        $null = $c["is_nullable"];
        $def = $c["column_default"];
        $extra = $c["extra"];

        if (in_array($col, ["cd_empresa","cd_filial"])) {
            $def = 1;
            $null = "NO";
        }

        $charset_sql = "";
        if (preg_match('/char|text/i', $type)) {
            $charset_sql = " CHARACTER SET $GLOBALS[charset] COLLATE $GLOBALS[collate]";
        }

        $sql  = "ALTER TABLE `{$db_destino['db']}`.`$t` ADD COLUMN `$col` $type$charset_sql";
        $sql .= ($null === "NO" ? " NOT NULL" : " NULL");
        $sql .= tratar_default($type, $def, $col);
        if ($extra) $sql .= " $extra";
        $sql .= ";";

        echo "<p>➕ Em <b>$t</b>: adicionar coluna <b>$col</b> ($type) ".btn($sql)."</p>";
    }
}

/* ============================================
   3) COLUNAS DIFERENTES
   ============================================ */
echo "<h2>📌 Colunas com diferenças</h2>";

$q = "
SELECT c1.table_name, c1.column_name,
       c1.column_type AS type_o, c2.column_type AS type_d,
       c1.is_nullable AS null_o, c2.is_nullable AS null_d,
       c1.column_default AS def_o, c2.column_default AS def_d,
       c1.extra AS extra_o, c2.extra AS extra_d
FROM information_schema.columns c1
JOIN information_schema.columns c2
    ON c1.table_name=c2.table_name AND c1.column_name=c2.column_name
WHERE c1.table_schema='{$db_origem['db']}'
  AND c2.table_schema='{$db_destino['db']}'
  AND (
        c1.column_type<>c2.column_type OR
        c1.is_nullable<>c2.is_nullable OR
        IFNULL(c1.column_default,'')<>IFNULL(c2.column_default,'') OR
        c1.extra<>c2.extra
      )
ORDER BY c1.table_name, c1.ordinal_position
";
$res = $conn_o->query($q);

if ($res->num_rows == 0) {
    echo "<p>Nenhuma diferença encontrada.</p>";
} else {
    while ($c = $res->fetch_assoc()) {

        $t = $c["table_name"];
        $col = $c["column_name"];
        $type = $c["type_o"];
        $null = $c["null_o"];
        $def = $c["def_o"];
        $extra = $c["extra_o"];

        if (in_array($col, ["cd_empresa","cd_filial"])) {
            $def = 1;
            $null = "NO";
        }

        $charset_sql = "";
        if (preg_match('/char|text/i', $type)) {
            $charset_sql = " CHARACTER SET $GLOBALS[charset] COLLATE $GLOBALS[collate]";
        }

        $sql  = "ALTER TABLE `{$db_destino['db']}`.`$t` MODIFY `$col` $type$charset_sql";
        $sql .= ($null==="NO" ? " NOT NULL" : " NULL");
        $sql .= tratar_default($type,$def,$col);
        if ($extra) $sql .= " $extra";
        $sql .= ";";

        echo "<p>🔧 Em <b>$t</b>: ajustar <b>$col</b><br>
              Origem: <code>{$c['type_o']}</code> — Destino: <code>{$c['type_d']}</code><br>
              ".btn($sql)."</p>";
    }
}

echo "<br><hr><p style='color:#666'>Ferramenta de sincronização profissional — versão completa.</p>";

?>
