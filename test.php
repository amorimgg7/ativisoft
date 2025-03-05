<?php
header('Content-Type: application/json');

$inicioTotal = microtime(true);
$inicioProcessamento = microtime(true);

// Simulação de processamento no servidor (pode ser removida ou ajustada conforme necessário)
usleep(50000); // 50ms de atraso para simular carga no servidor

$tempoProcessamento = microtime(true) - $inicioProcessamento;
$inicioComunicacao = microtime(true);

// Simula verificação de status (poderia ser um teste de conexão a um banco de dados, por exemplo)
$status = "online"; 

// Monta a resposta
$response = [
    "status" => $status,
    "tempo_processamento" => round($tempoProcessamento * 1000, 2), // Em milissegundos
    "tempo_comunicacao" => 0, // Será calculado abaixo
    "tempo_total" => 0, // Será calculado abaixo
    "timestamp" => time()
];

$tempoComunicacao = microtime(true) - $inicioComunicacao;
$response["tempo_comunicacao"] = round($tempoComunicacao * 1000, 2); // Em milissegundos
$response["tempo_total"] = round((microtime(true) - $inicioTotal) * 1000, 2); // Tempo total da requisição

echo json_encode($response);
?>
