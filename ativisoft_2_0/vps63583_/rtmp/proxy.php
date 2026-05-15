<?php
$chave = $_GET['chave'] ?? '';
if(!$chave) exit(json_encode(['error'=>'Chave não fornecida']));

$url = "http://191.252.220.154/api_camera.php?chave=".urlencode($chave);
$dados = file_get_contents($url);
header('Content-Type: application/json');
echo $dados;
