<?php
session_start();
header('Content-Type: application/json');

if (empty($_SESSION['contel_whatsapp'])) {
    http_response_code(400);
    echo json_encode([
        'status' => 'ERROR',
        'error' => 'Sessão WhatsApp não definida'
    ]);
    exit;
}

$SESSAO = preg_replace('/\D/', '', $_SESSION['contel_whatsapp']);
$API = "http://191.252.220.154:3001";

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

/* ======================
   STATUS (GET SIMULADO)
====================== */
if (!$data) {
    $ch = curl_init("$API/status/$SESSAO");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        echo json_encode([
            'status' => 'ERROR',
            'error' => curl_error($ch)
        ]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);
    echo $response;
    exit;
}

/* ======================
   ENVIO DE MENSAGEM
====================== */
if (empty($data['to']) || empty($data['message'])) {
    echo json_encode([
        'success' => false,
        'error' => 'Parâmetros inválidos'
    ]);
    exit;
}

$payload = [
    'to'      => preg_replace('/\D/', '', $data['to']),
    'message' => $data['message']
];

$ch = curl_init("$API/send/$SESSAO");
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_TIMEOUT => 20
]);

$response = curl_exec($ch);

if ($response === false) {
    echo json_encode([
        'success' => false,
        'error' => curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

curl_close($ch);
echo $response;
