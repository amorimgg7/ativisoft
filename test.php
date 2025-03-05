<?php
$start = microtime(true);

echo json_encode([
    "status" => "online",
    "timestamp" => date("Y-m-d H:i:s"),
    "load_time" => round(microtime(true) - $start, 4) // Tempo de carregamento em segundos
]);
?>
