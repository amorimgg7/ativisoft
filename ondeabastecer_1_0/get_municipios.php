<?php
require 'vendor/autoload.php'; // Carrega o SDK do Google

use Google\Cloud\BigQuery\BigQueryClient;

putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/credentials.json');

$projectId = 'ondeabastecer-455021';
$bigQuery = new BigQueryClient([
    'projectId' => $projectId,
]);

if (isset($_GET['estado'])) {
    $estado = $_GET['estado'];

    // Adicionando depuração para verificar o estado recebido
    error_log("Estado recebido: $estado");

    $query = "SELECT DISTINCT 
        m.id_municipio, 
        m.nome AS nome_municipio
    FROM `basedosdados.br_bd_diretorios_brasil.municipio` AS m
    WHERE m.sigla_uf = '$estado'
    ORDER BY nome_municipio ASC;";

    try {
        $queryJobConfig = $bigQuery->query($query);
        $queryResults = $bigQuery->runQuery($queryJobConfig);

        $municipios = [];
        foreach ($queryResults as $row) {
            $municipios[] = $row['nome_municipio'];
        }

        // Verificando se retornou algum município
        if (empty($municipios)) {
            error_log("Nenhum município encontrado para o estado $estado.");
        }

        echo json_encode($municipios);
    } catch (Exception $e) {
        // Em caso de erro na consulta
        error_log('Erro na consulta: ' . $e->getMessage());
        echo json_encode([]);
    }
} else {
    // Caso o parâmetro não esteja presente
    echo json_encode([]);
}
?>
