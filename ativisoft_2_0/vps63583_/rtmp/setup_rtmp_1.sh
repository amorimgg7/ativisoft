#!/bin/bash
# ================================
# Setup RTMP/HLS + PHP + Bootstrap com snapshots + API por chave
# Debian 12
# ================================

set -e

# Variáveis
RTMP_CONTAINER="nginx-rtmp"
BASE_DIR="/srv/rtmp"
HTML_DIR="$BASE_DIR/html"
HLS_DIR="$BASE_DIR/hls"
SNAP_DIR="$BASE_DIR/snapshots"
NGINX_CONF="$BASE_DIR/nginx.conf"
PHP_SOCK="/run/php/php8.2-fpm.sock"
IP_PUBLICO="191.252.220.154"

# --------------------------
# Atualizar sistema e instalar dependências
# --------------------------
apt update -y
apt upgrade -y
apt install -y curl git nano unzip ufw docker.io nginx php-fpm php-cli ffmpeg

systemctl enable --now docker
systemctl enable --now nginx
systemctl enable --now php8.2-fpm

# --------------------------
# Criar diretórios
# --------------------------
mkdir -p $HTML_DIR $HLS_DIR $SNAP_DIR
chown -R 1000:1000 $BASE_DIR
chmod -R 755 $BASE_DIR

# --------------------------
# Remover container antigo
# --------------------------
docker rm -f $RTMP_CONTAINER 2>/dev/null || true

# --------------------------
# Criar nginx.conf RTMP
# --------------------------
cat > $NGINX_CONF <<EOF
worker_processes 1;

events { worker_connections 1024; }

rtmp {
    server {
        listen 1935;
        chunk_size 4096;

        application live {
            live on;
            record off;

            hls on;
            hls_path /srv/rtmp/hls;
            hls_fragment 2s;
            hls_playlist_length 6s;
        }
    }
}

http {
    server {
        listen 8080;

        location /hls {
            root /srv/rtmp;
            types {
                application/vnd.apple.mpegurl m3u8;
                video/mp2t ts;
            }
            add_header Cache-Control no-cache;
        }
    }
}
EOF

# --------------------------
# Rodar container nginx-rtmp
# --------------------------
docker run -d \
--name $RTMP_CONTAINER \
-p 1935:1935 \
-p 8080:8080 \
-v $HLS_DIR:/srv/rtmp/hls \
-v $NGINX_CONF:/etc/nginx/nginx.conf:ro \
tiangolo/nginx-rtmp

# --------------------------
# Criar index.php (menu + snapshots + status)
# --------------------------
cat > $HTML_DIR/index.php <<'EOF'
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>setup_rtmp_1.sh</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<style>
body { background:#111; color:#fff; }
.card-img-top { width:100%; height:150px; object-fit:cover; background:#000; }
.online { color: #0f0; font-weight: bold; }
.offline { color: #f00; font-weight: bold; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Plataforma Câmeras</a>
  </div>
</nav>

<div class="container mt-3">
  <h3 class="text-center">setup_rtmp_1.sh</h3>
  <div class="row g-3" id="cams-container">
    <div class="col-12 text-center">Carregando câmeras...</div>
  </div>
</div>

<script>
let lastStatuses = {};
function loadCameras(){
    $.getJSON('viewcams.php?json=1', function(cameras){
        let html = '';
        let changed = false;

        if(Object.keys(cameras).length === 0){
            html = '<div class="col-12 text-center">Nenhuma câmera transmitindo</div>';
        } else {
            Object.keys(cameras).forEach(cam => {
                let status = cameras[cam];
                if(lastStatuses[cam] !== status) changed = true;
                lastStatuses[cam] = status;
                html += `<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="viewcam.php?nome=${cam}">
                        <div class="card bg-dark text-white">
                            <img class="card-img-top" src="snapshots/${cam}.jpg?${Date.now()}" alt="${cam}">
                            <div class="card-body text-center">
                                ${cam} - <span id="status_${cam}" class="${status.toLowerCase()}">${status}</span>
                            </div>
                        </div>
                    </a>
                </div>`;
            });
        }

        if(changed || $('#cams-container').html().trim() === ''){
            $('#cams-container').html(html);
        }
    });
}

loadCameras();
setInterval(loadCameras, 5000);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
EOF

# --------------------------
# Criar viewcams.php (JSON com status online/offline)
# --------------------------
cat > $HTML_DIR/viewcams.php <<'EOF'
<?php
$hls_dir = '/srv/rtmp/hls';
$now = time();
$cameras = [];

if(is_dir($hls_dir)){
    foreach(scandir($hls_dir) as $file){
        if(preg_match('/^(.*)\.m3u8$/', $file, $matches)){
            $cam = $matches[1];
            $filepath = "$hls_dir/$file";

            if(file_exists($filepath)){
                $size = filesize($filepath);
                $mtime = filemtime($filepath);

                if($size > 50 && ($now - $mtime) <= 10){
                    $cameras[$cam] = "ONLINE";
                } else {
                    $cameras[$cam] = "OFFLINE";
                }
            } else {
                $cameras[$cam] = "OFFLINE";
            }
        }
    }
}

if(isset($_GET['json'])){
    header('Content-Type: application/json');
    echo json_encode($cameras);
    exit;
}
EOF

# --------------------------
# Criar viewcam.php (vídeo ao vivo)
# --------------------------
cat > $HTML_DIR/viewcam.php <<'EOF'
<?php
if (!isset($_GET['nome'])) { echo "Parâmetro 'nome' obrigatório"; exit; }
$nome = preg_replace('/[^a-zA-Z0-9_-]/','',$_GET['nome']);
$hls_file = "/srv/rtmp/hls/$nome.m3u8";
if(!file_exists($hls_file)){ echo "Câmera não está transmitindo."; exit; }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Câmera <?= htmlspecialchars($nome) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<style>
body,html{margin:0;background:#000}
video{width:100vw;height:100vh}
</style>
</head>
<body>
<video id="video" controls autoplay></video>
<script>
let v=document.getElementById('video');
let src="/hls/<?= htmlspecialchars($nome) ?>.m3u8";
if(Hls.isSupported()){
    let hls=new Hls({lowLatencyMode:true});
    hls.loadSource(src);
    hls.attachMedia(v);
}else{
    v.src=src;
}
</script>
</body>
</html>
EOF

# --------------------------
# Criar script para gerar snapshots
# --------------------------
cat > /usr/local/bin/rtmp_snapshots.sh <<'EOF'
#!/bin/bash
HLS_DIR="/srv/rtmp/hls"
SNAP_DIR="/srv/rtmp/snapshots"
mkdir -p $SNAP_DIR

while true; do
    for file in $HLS_DIR/*.m3u8; do
        cam=$(basename "$file" .m3u8)
        ffmpeg -y -i "$file" -frames:v 1 -q:v 5 "$SNAP_DIR/$cam.jpg" < /dev/null &>/dev/null
    done
    sleep 5
done
EOF
chmod +x /usr/local/bin/rtmp_snapshots.sh
nohup /usr/local/bin/rtmp_snapshots.sh >/dev/null 2>&1 &

# --------------------------
# Criar API de consulta por chave
# --------------------------
cat > $HTML_DIR/api_camera.php <<'EOF'
<?php
$hls_dir = '/srv/rtmp/hls';
$chave = $_GET['chave'] ?? '';

header('Content-Type: application/json');

if(empty($chave)){
    echo json_encode(['error'=>'Chave não informada']);
    exit;
}

// A câmera só é válida se existir o arquivo .m3u8 correspondente
$hls_file = "$hls_dir/$chave.m3u8";

if(!file_exists($hls_file)){
    echo json_encode(['error'=>'Chave inválida ou câmera não transmitindo']);
    exit;
}

$status = 'OFFLINE';
$size = filesize($hls_file);
$mtime = filemtime($hls_file);

if($size > 50 && (time() - $mtime) <= 10){
    $status = 'ONLINE';
}

// Retorna JSON
echo json_encode([
    'camera' => $chave,
    'status' => $status,
    'stream_url' => "http://".$_SERVER['SERVER_ADDR']."/hls/$chave.m3u8"
]);
EOF

# --------------------------
# Configurar Nginx
# --------------------------
cat > /etc/nginx/sites-available/default <<EOF
server {
    listen 80 default_server;
    listen [::]:80 default_server;

    root $HTML_DIR;
    index index.php index.html;

    location / {
        try_files \$uri \$uri/ /index.php;
    }

    location ~ \.php\$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:$PHP_SOCK;
    }

    location /hls/ {
        alias $HLS_DIR/;
        types { application/vnd.apple.mpegurl m3u8; video/mp2t ts; }
        add_header Cache-Control no-cache;
    }

    location /snapshots/ {
        alias $SNAP_DIR/;
        add_header Cache-Control no-cache;
    }
}
EOF

# --------------------------
# Reiniciar serviços
# --------------------------
systemctl restart php8.2-fpm
systemctl restart nginx

# --------------------------
# Firewall
# --------------------------
ufw allow 22/tcp
ufw allow 80/tcp
ufw allow 1935/tcp
ufw --force enable

# --------------------------
# Final
# --------------------------
echo "======================================"
echo "✅ Setup concluído!"
echo "RTMP: rtmp://$IP_PUBLICO/live/<nome_da_camera>"
echo "Web: http://$IP_PUBLICO"
echo "API: http://$IP_PUBLICO/api_camera.php?chave=CAMERA123"
echo "======================================"
