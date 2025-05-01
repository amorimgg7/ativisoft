<?php
// Verifica se o formulário foi enviado
$response = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idInstance = '7105223939';
    $apiTokenInstance = '3f53385e2ead46cbbca3b7bdebec958e9ef4a63ba0c9437289';
    $apiUrl = "https://7105.api.greenapi.com";

    $phone = preg_replace('/\D/', '', $_POST['phone']); // Remove tudo que não for número
    $message = $_POST['message'];

    $url = "$apiUrl/waInstance$idInstance/sendMessage/$apiTokenInstance";

    $data = [
        "chatId" => $phone . "@c.us",
        "message" => $message
    ];

    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = $result ? json_decode($result, true)['idMessage'] ?? 'Enviado com sucesso!' : 'Erro ao enviar';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Envio de WhatsApp - Green API</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; background: #f4f4f4; }
        form { background: white; padding: 20px; border-radius: 10px; max-width: 400px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ccc; }
        button { background: green; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
        small { color: gray; }
        .msg { text-align: center; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <form method="post">
        <h2>Enviar mensagem pelo WhatsApp</h2>
        <label>Número com DDI e DDD:</label>
        <input type="text" name="phone" placeholder="Ex: 5521999999999" required>

        <label>Mensagem:</label>
        <textarea name="message" rows="5" placeholder="Digite sua mensagem" required></textarea>

        <button type="submit">Enviar</button>

        <div class="msg">
            <?php if ($response): ?>
                <small>Resposta da API:</small><br>
                <small><?php echo htmlspecialchars($response); ?></small>
            <?php endif; ?>
        </div>
    </form>
</body>
</html>
