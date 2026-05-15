#!/bin/bash
# ==========================================================
# DVR ATIVISOFT - RTMP + HLS + API + SNAPSHOTS + DASHBOARD
# Debian 12 - HTTPS sem conflito de portas
# ==========================================================

set -e

# --------------------------
# VARIÁVEIS
# --------------------------
RTMP_CONTAINER="nginx-rtmp"
BASE="/srv/rtmp"
HTML="$BASE/html"
HLS="$BASE/hls"
SNAP="$BASE/snapshots"
NGINX_CONF="$BASE/nginx-rtmp.conf"
PHP_SOCK="/run/php/php8.2-fpm.sock"
IP_PUBLICO="vps63583.publiccloud.com.br"  # seu domínio com HTTPS

# --------------------------
# SISTEMA
# --------------------------
apt update -y
apt upgrade -y
apt install -y \
docker.io nginx ufw \
php8.2 php8.2-fpm php8.2-cli \
ffmpeg curl nano unzip \
certbot python3-certbot-nginx

systemctl enable --now docker
systemctl enable --now nginx
systemctl enable --now php8.2-fpm

# --------------------------
# DIRETÓRIOS
# --------------------------
mkdir -p $HTML $HLS $SNAP
chown -R 1000:1000 $BASE
chmod -R 755 $BASE

# --------------------------
# REMOVER CONTAINER ANTIGO
# --------------------------
docker rm -f $RTMP_CONTAINER 2>/dev/null || true

# --------------------------
# NGINX RTMP (CONTAINER)
# --------------------------
cat > $NGINX_CONF <<EOF
worker_processes auto;

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
   hls_fragment 1s;
   hls_playlist_length 4s;
   hls_cleanup on;
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

docker run -d \
--name $RTMP_CONTAINER \
--restart unless-stopped \
-p 1935:1935 \
-p 8080:8080 \
-v $HLS:/srv/rtmp/hls \
-v $NGINX_CONF:/etc/nginx/nginx.conf:ro \
tiangolo/nginx-rtmp

# --------------------------
# API CAMERA + SNAPSHOTS
# --------------------------
cat > $HTML/api_camera.php <<'EOF'
<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$BASE="/srv/rtmp";
$HLS="$BASE/hls";
$SNAP="$BASE/snapshots";
$HOST=$_SERVER['HTTP_HOST'] ?? 'localhost';

$cam=$_GET['chave'] ?? '';
if(!$cam){
 echo json_encode(["status"=>"ERRO","erro"=>"Chave não informada"]);
 exit;
}

$playlist="$HLS/$cam.m3u8";
$snapshot="$SNAP/$cam.jpg";

if(file_exists($playlist)){
 $delta=time()-filemtime($playlist);
 if($delta<=6){
  echo json_encode([
   "status"=>"ONLINE",
   "imagem"=>"https://$HOST/snapshots/$cam.jpg",
   "video"=>"https://$HOST/hls/$cam.m3u8",
   "delay"=>$delta
  ]);
 } else {
  echo json_encode([
   "status"=>"OFFLINE",
   "imagem"=>file_exists($snapshot)?"https://$HOST/snapshots/$cam.jpg":null,
   "video"=>null,
   "delay"=>$delta
  ]);
 }
 exit;
}

if(file_exists($snapshot)){
 echo json_encode([
  "status"=>"OFFLINE",
  "imagem"=>"https://$HOST/snapshots/$cam.jpg",
  "video"=>null
 ]);
 exit;
}

echo json_encode([
 "status"=>"INEXISTENTE",
 "erro"=>"camera nunca transmitiu"
]);
EOF

# --------------------------
# FRONTEND (INDEX)
# --------------------------
cat > $HTML/index.html <<'EOF'
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>setup_rtmp_2.sh</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<style>
body {
    background: #020617;
    color: #f1f5f9; /* texto principal mais claro */
}

.card {
    background: #020617;
    border: 1px solid #334155; /* leve contraste no card */
    color: #f1f5f9; /* garante texto claro dentro do card */
}

.card img {
    height: 160px;
    object-fit: cover;
}

.online {
    color: #4ade80; /* verde mais vibrante e claro */
    font-weight: bold;
}

.offline {
    color: #f87171; /* vermelho mais claro */
    font-weight: bold;
}
</style>

</head>
<body>
<nav class="navbar navbar-dark bg-black px-3">
<span class="navbar-brand">setup_rtmp_2.sh</span>
</nav>

<div class="container mt-3">
<div class="row g-3" id="cams"></div>
</div>

<div class="modal fade" id="modal">
<div class="modal-dialog modal-xl modal-dialog-centered">
<div class="modal-content bg-dark text-white">
<div class="modal-header">
<h5 id="titulo"></h5>
<button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<video id="video" controls autoplay></video>
</div>
</div>
</div>
</div>

<script>
const camsEl=document.getElementById("cams");
let hls;

function carregar(){
 fetch("api_cameras.php").then(r=>r.json()).then(lista=>{
  lista.forEach(cam=>{
   fetch(`api_camera.php?chave=${cam}`)
   .then(r=>r.json())
   .then(d=>atualizar(cam,d));
  });
 });
}

function atualizar(cam,d){
 let el=document.getElementById("cam_"+cam);
 if(!el){
  el=document.createElement("div");
  el.className="col-12 col-sm-6 col-md-4 col-lg-3";
  el.id="cam_"+cam;
  el.innerHTML=`
  <div class="card">
   <img id="img_${cam}">
   <div class="card-body text-center">
    <div>${cam}</div>
    <div id="st_${cam}"></div>
   </div>
  </div>`;
  camsEl.appendChild(el);
 }

 document.getElementById("st_"+cam).innerText=d.status;
 document.getElementById("st_"+cam).className=d.status=="ONLINE"?"online":"offline";
 document.getElementById("img_"+cam).src=d.imagem?d.imagem+"?t="+Date.now():"";

 el.onclick=()=>{ if(d.video) abrir(cam,d.video); };
}

function abrir(cam,url){
 document.getElementById("titulo").innerText=cam;
 const v=document.getElementById("video");
 if(hls){hls.destroy();hls=null;}
 if(Hls.isSupported()){
  hls=new Hls({lowLatencyMode:true});
  hls.loadSource(url);
  hls.attachMedia(v);
 } else v.src=url;
 new bootstrap.Modal(document.getElementById("modal")).show();
}

carregar();
setInterval(carregar,2000);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
EOF

# API listar todas as câmeras
cat > $HTML/api_cameras.php <<'EOF'
<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$HLS="/srv/rtmp/hls";
$cams=[];

foreach(glob("$HLS/*.m3u8") as $f){
 $cams[]=basename($f,'.m3u8');
}
echo json_encode(array_values(array_unique($cams)));
EOF

# --------------------------
# SNAPSHOTS TEMPO REAL
# --------------------------
cat > /usr/local/bin/rtmp_snapshots.sh <<'EOF'
#!/bin/bash
HLS="/srv/rtmp/hls"
SNAP="/srv/rtmp/snapshots"
mkdir -p $SNAP

while true; do
 for f in $HLS/*.m3u8; do
  [ -e "$f" ] || continue
  cam=$(basename "$f" .m3u8)
  ffmpeg -y -i "$f" -frames:v 1 -q:v 5 "$SNAP/$cam.jpg" </dev/null &>/dev/null
 done
 sleep 2
done
EOF
chmod +x /usr/local/bin/rtmp_snapshots.sh
nohup /usr/local/bin/rtmp_snapshots.sh >/dev/null 2>&1 &

# --------------------------
# NGINX HOST (HTTPS)
# --------------------------
cat > /etc/nginx/sites-available/default <<EOF
server {
 listen 80;
 server_name $IP_PUBLICO;

 root $HTML;
 index index.html index.php;

 location / {
  try_files \$uri \$uri/ /index.html;
 }

 location ~ \.php\$ {
  include snippets/fastcgi-php.conf;
  fastcgi_pass unix:$PHP_SOCK;
 }

 # Proxy reverso HLS e snapshots para HTTPS
 location /hls/ {
    proxy_pass http://127.0.0.1:8080/hls/;
    proxy_buffering off;
    add_header Cache-Control no-cache;
    add_header Access-Control-Allow-Origin *;
 }

 location /snapshots/ {
  alias $SNAP/;
  add_header Cache-Control no-cache;
 }
}
EOF

# --------------------------
# Certbot (Let's Encrypt)
# --------------------------
certbot --nginx -d $IP_PUBLICO --non-interactive --agree-tos -m amorimgg7@gmail.com
# certbot certonly --nginx -d vps63583.publiccloud.com.br --staging --non-interactive --agree-tos -m amorimgg7@gmail.com


systemctl restart nginx php8.2-fpm

# --------------------------
# Firewall
# --------------------------
ufw allow 22/tcp
ufw allow 80/tcp
ufw allow 443/tcp
ufw allow 1935/tcp
ufw --force enable

echo "======================================"
echo "✅ DVR ATIVISOFT HTTPS PRONTO"
echo "RTMP: rtmp://$IP_PUBLICO/live/<camera>"
echo "WEB : https://$IP_PUBLICO"
echo "API : https://$IP_PUBLICO/api_camera.php?chave=<camera>"
echo "======================================"
