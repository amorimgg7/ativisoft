<?php
$rtmp_server = "rtmp://sistema.ativisoft.com.br/live"; // Link RTMP para configurar na câmera
$hls_server = "https://sistema.ativisoft.com.br/live"; // Link HLS para reprodução no navegador
$txt_file = "cameras.txt";

// Lê câmeras salvas
$cameras = [];
if (file_exists($txt_file)) {
    $cameras = file($txt_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

// Adiciona nova câmera
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['camera_name'])) {
        $camera_name = htmlspecialchars($_POST['camera_name']);
        if (!in_array($camera_name, $cameras)) {
            $cameras[] = $camera_name;
            file_put_contents($txt_file, $camera_name . PHP_EOL, FILE_APPEND);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerador de Links RTMP e Player HLS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Video.js CSS -->
    <link href="https://vjs.zencdn.net/8.20.0/video-js.css" rel="stylesheet" />
    <style>
        .video-card { margin-bottom: 20px; }
        body { background: #f8f9fa; }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="mb-4 text-center">Gerenciador de Câmeras Intelbras Mibo</h1>

    <!-- Formulário para adicionar câmera -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="camera_name" class="form-control" placeholder="Nome da câmera" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Adicionar Câmera</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de câmeras -->
    <div class="row">
        <?php foreach ($cameras as $cam): ?>
            <?php 
            $rtmp_link = $rtmp_server . '/' . $cam; 
            $hls_link = $hls_server . '/' . $cam . '.m3u8'; 
            ?>
            <div class="col-md-6 video-card">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= $cam ?></h5>

                        <!-- Link RTMP -->
                        <p>
                            <label>Link RTMP (para a câmera):</label>
                            <input type="text" class="form-control mb-2" value="<?= $rtmp_link ?>" readonly>
                            <button class="btn btn-success w-100 mb-2" onclick="copyLink(this)">Copiar Link</button>
                        </p>

                        <!-- Player HLS -->
                        <label>Visualização no navegador (HLS):</label>
                        <video
                            id="player_<?= $cam ?>"
                            class="video-js vjs-default-skin"
                            controls
                            preload="auto"
                            width="100%"
                            height="250"
                            data-setup='{}'>
                            <source src="<?= $hls_link ?>" type="application/x-mpegURL">
                        </video>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Video.js -->
<script src="https://vjs.zencdn.net/8.20.0/video.min.js"></script>
<script>
function copyLink(button) {
    const input = button.previousElementSibling;
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
        alert('Link copiado: ' + input.value);
    });
}
</script>
</body>
</html>
