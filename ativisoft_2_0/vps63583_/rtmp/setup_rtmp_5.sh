#!/bin/bash
# ==========================================================
# DVR ATIVISOFT - RTMP + HLS + API + SNAPSHOTS + DASHBOARD
# Debian 12 - Produção
# ==========================================================

set -e

# --------------------------
# VARIÁVEIS
# --------------------------
IP_PUBLICO="191.252.220.154"
BASE="/srv/rtmp"
HTML="$BASE/html"
HLS="$BASE/hls"
SNAP="$BASE/snapshots"
NGINX_RTMP_CONF="$BASE/nginx-rtmp.conf"
PHP_SOCK="/run/php/php8.2-fpm.sock"
RTMP_CONTAINER="nginx-rtmp"

# --------------------------
# SISTEMA
# --------------------------
apt update -y
apt upgrade -y
apt install -y \
certbot python3-certbot-nginx \
docker.io nginx ufw \
php8.2 php8.2-fpm php8.2-cli \
ffmpeg curl nano unzip

systemctl enable --now docker
systemctl enable --now nginx
systemctl enable --now php8.2-fpm

# --------------------------
# DIRETÓRIOS
# --------------------------
mkdir -p $HTML $HLS $SNAP
chmod -R 755 $BASE

# --------------------------
# REMOVE CONTAINER ANTIGO
# --------------------------
docker rm -f $RTMP_CONTAINER 2>/dev/null || true

# --------------------------
# NGINX RTMP (CONTAINER)
# --------------------------
cat > $NGINX_RTMP_CONF <<EOF
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
   add_header Access-Control-Allow-Origin *;
  }
 }
}

https {
 server {
  listen 443;
  location /hls {
   root /srv/rtmp;
   types {
    application/vnd.apple.mpegurl m3u8;
    video/mp2t ts;
   }
   add_header Cache-Control no-cache;
   add_header Access-Control-Allow-Origin *;
  }
 }
}
EOF

docker run -d \
--name $RTMP_CONTAINER \
--restart unless-stopped \
-p 1935:1935 \
-p 8080:8080 \
-p 443:443 \
-v $HLS:/srv/rtmp/hls \
-v $NGINX_RTMP_CONF:/etc/nginx/nginx.conf:ro \
tiangolo/nginx-rtmp

# --------------------------
# API CAMERA (STATUS CORRETO)
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

/*
 REGRAS:
 ONLINE      → m3u8 atualizado
 OFFLINE     → já existiu (snapshot ou playlist antiga)
 INEXISTENTE → nunca transmitiu
*/

if(file_exists($playlist)){
 $delta=time()-filemtime($playlist);
 if($delta<=6){
  echo json_encode([
   "status"=>"ONLINE",
   "imagem"=>"http://$HOST/snapshots/$cam.jpg",
   "video"=>"http://$HOST/hls/$cam.m3u8",
   "delay"=>$delta
  ]);
 } else {
  echo json_encode([
   "status"=>"OFFLINE",
   "imagem"=>file_exists($snapshot)?"http://$HOST/snapshots/$cam.jpg":null,
   "video"=>null,
   "delay"=>$delta
  ]);
 }
 exit;
}

if(file_exists($snapshot)){
 echo json_encode([
  "status"=>"OFFLINE",
  "imagem"=>"http://$HOST/snapshots/$cam.jpg",
  "video"=>null
 ]);
 exit;
}

echo json_encode([
 "status"=>"INEXISTENTE",
 "erro"=>"Câmera nunca transmitiu"
]);
EOF

# --------------------------
# API LISTAR CÂMERAS
# --------------------------
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
# FRONTEND (INDEX)
# --------------------------
cat > $HTML/index.html <<'EOF'
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Ativisoft • Câmeras</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<style>
body{background:#020617;color:#e5e7eb}
.card{background:#020617;border:1px solid #1e293b}
.card img{height:160px;object-fit:cover}
.online{color:#22c55e;font-weight:bold}
.offline{color:#ef4444;font-weight:bold}
</style>
</head>
<body>
<nav class="navbar navbar-dark bg-black px-3">
<span class="navbar-brand">📡 Ativisoft DVR</span>
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

# --------------------------
# NGINX SITE
# --------------------------
cat > /etc/nginx/sites-available/default <<EOF
server {
 listen 80 default_server;
 root $HTML;
 index index.html;

 location / {
  try_files \$uri \$uri/ /index.html;
 }

 location ~ \.php\$ {
  include snippets/fastcgi-php.conf;
  fastcgi_pass unix:$PHP_SOCK;
 }

 location /hls/ {
    alias /srv/rtmp/hls/;
    types {
        application/vnd.apple.mpegurl m3u8;
        video/mp2t ts;
    }
    add_header Cache-Control no-cache;
    add_header Access-Control-Allow-Origin *;
}


 location /snapshots/ {
  alias $SNAP/;
  add_header Cache-Control no-cache;
 }
}
EOF

systemctl restart nginx php8.2-fpm

# --------------------------
# FIREWALL
# --------------------------
ufw allow 22
ufw allow 80
ufw allow 1935
ufw --force enable

echo "======================================"
echo "✅ DVR ATIVISOFT PRONTO"
echo "RTMP: rtmp://$IP_PUBLICO/live/cam1"
echo "WEB : http://$IP_PUBLICO"
echo "API : http://$IP_PUBLICO/api_camera.php?chave=cam1"
echo "======================================"
