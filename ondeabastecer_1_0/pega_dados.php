<?php
require 'vendor/autoload.php';
use Google\Cloud\BigQuery\BigQueryClient;

if (!file_exists(__DIR__ . '/credentials.json')) {
    die('Arquivo de credenciais não encontrado!');
} else {
    putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/credentials.json');
}

$bigQuery = new BigQueryClient(['projectId' => 'ondeabastecer-455021']);

$query = "SELECT * FROM `basedosdados.br_anp_precos_combustiveis.microdados`
          WHERE id_municipio = '3304557'
            and data_coleta >= '2025-01-01'
          LIMIT 10000";

$queryResults = $bigQuery->runQuery($bigQuery->query($query));
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Consulta ANP + INSERT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2 class="mb-4">Consulta ANP + Comandos INSERT</h2>

<?php
if ($queryResults->isComplete()) {
    $resultados = iterator_to_array($queryResults);

    if (count($resultados) === 0) {
        echo "<div class='alert alert-warning'>Nenhum dado encontrado.</div>";
    } else {
        require_once 'classes/conn.php';

        // Cria a tabela tb_empresas, se não existir
        $createEmpresasSQL = "CREATE TABLE IF NOT EXISTS `tb_empresas` (
            `cnpj` VARCHAR(20) NOT NULL PRIMARY KEY,
            `bandeira_revenda` VARCHAR(255) DEFAULT NULL,
            `razao_social` VARCHAR(255) DEFAULT NULL,
            `nome_fantasia` VARCHAR(255) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        mysqli_query($conn, $createEmpresasSQL);

        $totalRetornados = count($resultados);
        $tentativas = 0;
        $inseridos = 0;
        $jaExistiam = 0;

        $colunas = array_keys($resultados[0]);

        function detectarTipo($coluna, $valores) {
            $isDate = true;
            $isDateTime = true;
            $isTime = true;
            $maxLen = 0;

            foreach ($valores as $v) {
                if (is_null($v)) continue;

                if ($v instanceof \Google\Cloud\BigQuery\Date) {
                    $v = $v->get()->format('Y-m-d');
                } elseif (is_object($v)) {
                    $v = '';
                }

                $v = trim((string)$v);
                $maxLen = max($maxLen, strlen($v));

                if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) $isDate = false;
                if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $v)) $isDateTime = false;
                if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $v)) $isTime = false;
            }

            if ($isDateTime) return 'DATETIME';
            if ($isDate) return 'DATE';
            if ($isTime) return 'TIME';

            return "VARCHAR(" . ($maxLen + 10) . ")";
        }

        $valoresPorColuna = [];
        foreach ($colunas as $coluna) {
            $valoresPorColuna[$coluna] = array_column($resultados, $coluna);
        }

        $tipos = [];
        foreach ($colunas as $coluna) {
            $tipos[$coluna] = detectarTipo($coluna, $valoresPorColuna[$coluna]);
        }

        $tabela = 'tb_anp';
        $createSQL = "CREATE TABLE IF NOT EXISTS `$tabela` (\n";
        $definicoes = [];

        foreach ($colunas as $coluna) {
            $tipo = $tipos[$coluna];
            $definicoes[] = "`$coluna` $tipo";
        }

        $createSQL .= implode(",\n", $definicoes) . "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        mysqli_query($conn, $createSQL);

        echo "<div class='mt-4'><h4>Comandos INSERT gerados</h4><pre><code>";
        $linhasInsert = [];

        foreach ($resultados as $row) {
            $tentativas++;

            $cnpj = isset($row['cnpj_revenda']) ? addslashes($row['cnpj_revenda']) : null;
            $bandeira = isset($row['bandeira_revenda']) ? addslashes($row['bandeira_revenda']) : null;
            $razao = isset($row['razao_social']) ? addslashes($row['razao_social']) : null;
            $fantasia = isset($row['nome_estabelecimento']) ? addslashes($row['nome_estabelecimento']) : null;

            if ($cnpj) {
                $checkEmpresaQuery = "SELECT COUNT(*) as total FROM `tb_empresas` WHERE `cnpj` = '$cnpj'";
                $checkEmpresaResult = mysqli_query($conn, $checkEmpresaQuery);

                $empresaExiste = false;
                if ($checkEmpresaResult && $rowEmpresa = mysqli_fetch_assoc($checkEmpresaResult)) {
                    $empresaExiste = $rowEmpresa['total'] > 0;
                }

                if (!$empresaExiste) {
                    $insertEmpresaQuery = "INSERT INTO `tb_empresas` (`cnpj`, `razao_social`, `nome_fantasia`) 
                                           VALUES ('$cnpj', " . 
                                                  ($razao ? "'$razao'" : "NULL") . ", " .
                                                  ($fantasia ? "'$fantasia'" : "NULL") . ")";
                    mysqli_query($conn, $insertEmpresaQuery);
                }
            }

            $data = null;
            if (isset($row['data_coleta']) && $row['data_coleta'] instanceof \Google\Cloud\BigQuery\Date) {
                $data = $row['data_coleta']->get()->format('Y-m-d');
            }

            $preco = isset($row['preco_venda']) ? floatval($row['preco_venda']) : null;

            if ($cnpj && $data && $preco !== null) {
                $checkQuery = "SELECT COUNT(*) as total FROM `$tabela` 
                               WHERE `cnpj_revenda` = '$cnpj' 
                                 AND `data_coleta` = '$data' 
                                 AND `preco_venda` = '$preco'";
                $checkResult = mysqli_query($conn, $checkQuery);

                $exists = false;
                if ($checkResult && $rowCheck = mysqli_fetch_assoc($checkResult)) {
                    $exists = $rowCheck['total'] > 0;
                }

                if ($exists) {
                    $jaExistiam++;
                } else {
                    $valores = [];
                    foreach ($colunas as $coluna) {
                        $valor = $row[$coluna];

                        if ($valor instanceof \Google\Cloud\BigQuery\Date) {
                            $valor = $valor->get()->format('Y-m-d');
                        } elseif ($coluna === 'data_coleta') {
                            $valor = date('Y-m-d', strtotime($valor));
                        }

                        $valores[] = is_null($valor) ? "NULL" : "'" . addslashes($valor) . "'";
                    }

                    $insertQuery = "INSERT INTO `$tabela` (" . implode(", ", array_map(fn($c) => "`$c`", $colunas)) . ") VALUES (" . implode(", ", $valores) . ")";
                    if (mysqli_query($conn, $insertQuery)) {
                        $inseridos++;
                        $linhasInsert[] = $insertQuery;
                    } else {
                        echo "<div class='text-danger'>Erro ao inserir: " . mysqli_error($conn) . "</div>";
                    }
                }
            }
        }

        echo htmlspecialchars(implode(";\n", $linhasInsert));
        echo ";\n</code></pre></div>";

        echo "<div class='mt-4 alert alert-info'>";
        echo "<strong>Resumo da Operação:</strong><br>";
        echo "Linhas retornadas do BigQuery: <strong>$totalRetornados</strong><br>";
        echo "Tentativas de inserção: <strong>$tentativas</strong><br>";
        echo "Registros inseridos: <strong>$inseridos</strong><br>";
        echo "Registros ignorados (já existiam): <strong>$jaExistiam</strong>";
        echo "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>A consulta não foi concluída.</div>";
}
?>
</body>
</html>
