<?php
header('Content-Type: application/json');

$baileys = "http://191.252.220.154:3001"; // IP do seu servidor Baileys

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// --------------------------
// GET /status
// --------------------------
if($method === 'GET' && strpos($uri, 'proxy.php/status') !== false) {
    $ch = curl_init("$baileys/status");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    exit;
}

// --------------------------
// POST /send
// --------------------------
if($method === 'POST') {
    if(strpos($uri, 'proxy.php/restart') !== false){
        $authPath = '/srv/whatsapp-api/app/auth';
    array_map('unlink', glob("$authPath/*")); // remove todos os arquivos
    echo json_encode(['success'=>true,'msg'=>'Sessão reiniciada. Escaneie o QR Code novamente.']);
    exit;
    }else{
        $data = json_decode(file_get_contents("php://input"), true);

    if(!$data || empty($data['to']) || empty($data['message'])) {
        echo json_encode(['success'=>false, 'error'=>'Dados inválidos']);
        exit;
    }

    $ch = curl_init("$baileys/send");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode([
            'to' => $data['to'],
            'message' => $data['message']
        ])
    ]);

    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    exit;
    }
    
}


echo json_encode(['success'=>false,'error'=>'Rota inválida']);
