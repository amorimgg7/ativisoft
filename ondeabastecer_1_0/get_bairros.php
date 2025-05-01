<?php
require 'vendor/autoload.php'; // Carrega o SDK do Google

use Google\Cloud\BigQuery\BigQueryClient;

putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/credentials.json');

$projectId = 'ondeabastecer-455021';
$bigQuery = new BigQueryClient([
    'projectId' => $projectId,
]);

// Verifica se o parâmetro "municipio" foi informado
if (!isset($_GET['municipio']) || empty($_GET['municipio'])) {
    echo json_encode([]);
    exit;
}

$municipio = $_GET['municipio'];
error_log("Município recebido: $municipio");

$query = "SELECT DISTINCT bairro_revenda 
          FROM `basedosdados.br_anp_precos_combustiveis.microdados`
          WHERE data_coleta >= '2025-02-01' 
          AND id_municipio = '$municipio' 
          ORDER BY bairro_revenda ASC";

try {
    $queryJobConfig = $bigQuery->query($query);
    $queryResults = $bigQuery->runQuery($queryJobConfig);

    $bairros = [];
    foreach ($queryResults as $row) {
        if (!empty($row['bairro_revenda'])) {
            $bairros[] = $row['bairro_revenda'];
        }
    }

    // Log se nenhum bairro for encontrado
    if (empty($bairros)) {
        error_log("Nenhum bairro encontrado para o município $municipio.");
    }

    echo json_encode($bairros);
} catch (Exception $e) {
    error_log('Erro na consulta: ' . $e->getMessage());
    echo json_encode([]);
}
?>
