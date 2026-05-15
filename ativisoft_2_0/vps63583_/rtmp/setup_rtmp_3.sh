#!/bin/bash
# ==========================================================
# DVR ATIVISOFT + WhatsApp API Multi-Cliente
# RTMP + HLS + PHP Dashboard + Snapshots + WhatsApp API
# Debian 12 - HTTPS NGINX + Rate Limit
# ==========================================================

set -e

# --------------------------
# VARIÁVEIS
# --------------------------
# RTMP/HLS
RTMP_CONTAINER="nginx-rtmp"
BASE="/srv/rtmp"
HTML="$BASE/html"
HLS="$BASE/hls"
SNAP="$BASE/snapshots"
NGINX_RTMP_CONF="$BASE/nginx-rtmp.conf"
PHP_SOCK="/run/php/php8.2-fpm.sock"

# WhatsApp
WA_BASE="/srv/whatsapp-api"
WA_PORT=3001
WA_SESSIONS="$WA_BASE/sessions"
WA_KEYS="$WA_BASE/keys/keys.txt"

# Domínio
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
certbot python3-certbot-nginx \
nodejs npm git

systemctl enable --now docker
systemctl enable --now nginx
systemctl enable --now php8.2-fpm

# --------------------------
# DIRETÓRIOS
# --------------------------
mkdir -p $HTML $HLS $SNAP $WA_BASE/{sessions,keys,public}
chown -R 1000:1000 $BASE
chmod -R 755 $BASE

# --------------------------
# REMOVER CONTAINER ANTIGO
# --------------------------
docker rm -f $RTMP_CONTAINER 2>/dev/null || true

# --------------------------
# NGINX RTMP (CONTAINER)
# --------------------------
# 1️⃣ NGINX HTTP apenas
cat > /etc/nginx/sites-available/whatsapp-api <<EOF
server {
 listen 80;
 server_name $IP_PUBLICO;

 location / {
    return 301 http://\$host\$request_uri;
 }

 location /.well-known/acme-challenge/ {
    root /var/www/html;
 }

 # Proxy HTTP temporário
 location /chat/ {
    proxy_pass http://127.0.0.1:3001/;
    proxy_http_version 1.1;
    proxy_set_header Upgrade \$http_upgrade;
    proxy_set_header Connection "upgrade";
    proxy_set_header Host \$host;
    proxy_set_header X-Real-IP \$remote_addr;
    proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
 }
}
EOF

ln -sf /etc/nginx/sites-available/whatsapp-api /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx

# 2️⃣ Gerar SSL com Certbot
certbot --nginx -d $IP_PUBLICO --non-interactive --agree-tos -m amorimgg7@gmail.com

# 3️⃣ Após Certbot, habilitar HTTPS + rate limit
cat > /etc/nginx/sites-available/whatsapp-api <<EOF
limit_req_zone \$binary_remote_addr zone=chat:10m rate=5r/s;

server {
 listen 80;
 server_name $IP_PUBLICO;
 return 301 http://\$host\$request_uri;
}

server {
 listen 443 ssl http2;
 server_name $IP_PUBLICO;

 ssl_certificate /etc/letsencrypt/live/$IP_PUBLICO/fullchain.pem;
 ssl_certificate_key /etc/letsencrypt/live/$IP_PUBLICO/privkey.pem;

 location /chat/ {
    limit_req zone=chat burst=10 nodelay;
    proxy_pass http://127.0.0.1:3001/;
    proxy_http_version 1.1;
    proxy_set_header Upgrade \$http_upgrade;
    proxy_set_header Connection "upgrade";
    proxy_set_header Host \$host;
    proxy_set_header X-Real-IP \$remote_addr;
    proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
 }
}
EOF

nginx -t
systemctl reload nginx


docker run -d \
--name $RTMP_CONTAINER \
--restart unless-stopped \
-p 1935:1935 \
-p 8080:8080 \
-v $HLS:/srv/rtmp/hls \
-v $NGINX_RTMP_CONF:/etc/nginx/nginx.conf:ro \
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
 "erro"=>"camera nunca transmitiu"
]);
EOF

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
body { background: #020617; color: #f1f5f9; }
.card { background: #020617; border: 1px solid #334155; color: #f1f5f9; }
.card img { height: 160px; object-fit: cover; }
.online { color: #4ade80; font-weight: bold; }
.offline { color: #f87171; font-weight: bold; }
</style>
</head>
<body>
<nav class="navbar navbar-dark bg-black px-3"><span class="navbar-brand">setup_rtmp_2.sh</span></nav>
<div class="container mt-3"><div class="row g-3" id="cams"></div></div>
<div class="modal fade" id="modal">
<div class="modal-dialog modal-xl modal-dialog-centered">
<div class="modal-content bg-dark text-white">
<div class="modal-header">
<h5 id="titulo"></h5>
<button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body"><video id="video" controls autoplay></video></div>
</div></div></div>
<script>
const camsEl=document.getElementById("cams");
let hls;
function carregar(){
 fetch("api_cameras.php").then(r=>r.json()).then(lista=>{
  lista.forEach(cam=>{
   fetch(`api_camera.php?chave=${cam}`).then(r=>r.json()).then(d=>atualizar(cam,d));
  });
 });
}
function atualizar(cam,d){
 let el=document.getElementById("cam_"+cam);
 if(!el){
  el=document.createElement("div");
  el.className="col-12 col-sm-6 col-md-4 col-lg-3";
  el.id="cam_"+cam;
  el.innerHTML=`<div class="card"><img id="img_${cam}"><div class="card-body text-center"><div>${cam}</div><div id="st_${cam}"></div></div></div>`;
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
 if(Hls.isSupported()){ hls=new Hls({lowLatencyMode:true}); hls.loadSource(url); hls.attachMedia(v);}
 else v.src=url;
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
# WhatsApp API
# --------------------------
cat > $WA_BASE/index.js <<'EOF'
const { Client, LocalAuth } = require('whatsapp-web.js');
const express = require('express');
const bodyParser = require('body-parser');
const QRCode = require('qrcode');
const { v4: uuidv4 } = require('uuid');
const fs = require('fs');
const app = express();
app.use(bodyParser.json());
app.use(express.static('public'));
const SESSIONS = {};
const KEY_FILE = './keys/keys.txt';
if(!fs.existsSync('./keys')) fs.mkdirSync('./keys');
function saveKey(phone, apiKey){
  const line = `${phone}|${apiKey}|CONNECTED|${Date.now()}\n`;
  fs.appendFileSync(KEY_FILE, line);
}
function invalidateKey(phone){
  if(!fs.existsSync(KEY_FILE)) return;
  const lines = fs.readFileSync(KEY_FILE,'utf8').split('\n').map(l=>{
    if(l.startsWith(phone+'|')) return l.replace('|CONNECTED|','|DISCONNECTED|');
    return l;
  });
  fs.writeFileSync(KEY_FILE, lines.join('\n'));
}
function validateKey(phone,key){
  if(!fs.existsSync(KEY_FILE)) return false;
  return fs.readFileSync(KEY_FILE,'utf8').split('\n').some(l=>l.startsWith(`${phone}|${key}|CONNECTED`));
}
function startSession(phone){
  if(SESSIONS[phone]) return;
  const client = new Client({
    authStrategy: new LocalAuth({clientId:phone,dataPath:'./sessions'}),
    puppeteer:{headless:true,args:['--no-sandbox','--disable-setuid-sandbox']}
  });
  SESSIONS[phone] = {client, qr:null, ready:false, apiKey:null};
  client.on('qr', async qr => { SESSIONS[phone].qr = await QRCode.toDataURL(qr); });
  client.on('ready', () => {
    const apiKey = uuidv4();
    SESSIONS[phone].ready = true;
    SESSIONS[phone].apiKey = apiKey;
    SESSIONS[phone].qr = null;
    saveKey(phone, apiKey);
    console.log(`WhatsApp ${phone} conectado | KEY: ${apiKey}`);
  });
  client.on('disconnected', () => {
    console.log(`WhatsApp ${phone} desconectado`);
    invalidateKey(phone);
    delete SESSIONS[phone];
  });
  client.initialize();
}
app.get('/qr/:phone',(req,res)=>{ startSession(req.params.phone); res.sendFile(__dirname+'/public/qr.html'); });
app.get('/api/qr/:phone',(req,res)=>{
  const s = SESSIONS[req.params.phone];
  if(!s){return res.json({status:'DISCONNECTED'});}
  if(s.ready){return res.json({status:'CONNECTED',apiKey:s.apiKey});}
  res.json({status:'QRCODE',qr:s.qr});
});
app.post('/api/send',async(req,res)=>{
  const {phone,apiKey,to,message} = req.body;
  if(!validateKey(phone,apiKey)) return res.status(401).json({erro:'API KEY inválida ou desconectada'});
  if(!SESSIONS[phone] || !SESSIONS[phone].ready) return res.status(400).json({erro:'Sessão não ativa'});
  try{ await SESSIONS[phone].client.sendMessage(`${to}@c.us`,message); res.json({sucesso:true}); }
  catch(e){res.status(500).json({erro:e.message});}
});
app.listen(3001,()=>console.log('WhatsApp API rodando na porta 3001'));
EOF

cat > $WA_BASE/public/qr.html <<'EOF'
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>WhatsApp QR</title></head>
<body>
<h2>Escaneie o QR Code</h2>
<div id="box">Carregando...</div>
<script>
const phone = location.pathname.split('/').pop();
async function check(){
  const r = await fetch('/api/qr/'+phone);
  const d = await r.json();
  if(d.status==='CONNECTED'){document.getElementById('box').innerHTML=`<h3>Conectado ✅</h3><p>API KEY:</p><code>${d.apiKey}</code>`;return;}
  if(d.status==='QRCODE'){document.getElementById('box').innerHTML=`<img src="${d.qr}">`;}
  if(d.status==='DISCONNECTED'){document.getElementById('box').innerHTML=`<p>Desconectado ❌</p>`;}
  setTimeout(check,2000);
}
check();
</script>
</body>
</html>
EOF

# --------------------------
# NODE MODULES + PM2
# --------------------------
cd $WA_BASE
npm install express whatsapp-web.js qrcode body-parser uuid fs
npm install -g pm2
pm2 start index.js --name whatsapp-api
pm2 save
pm2 startup systemd

# --------------------------
# NGINX HTTPS + Proxy /chat + Rate Limit
# --------------------------
cat > /etc/nginx/sites-available/whatsapp-api <<EOF
limit_req_zone \$binary_remote_addr zone=chat:10m rate=5r/s;

server {
 listen 80;
 server_name $IP_PUBLICO;

 location / {
    return 301 https://\$host\$request_uri;
 }
 location /.well-known/acme-challenge/ {
    root /var/www/html;
 }
}

server {
    listen 80;
    server_name vps63583.publiccloud.com.br;

    location /chat/ {
        proxy_pass http://127.0.0.1:3001/;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    }
}

EOF

ln -sf /etc/nginx/sites-available/whatsapp-api /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx

# --------------------------
# Certbot
# --------------------------
# certbot --nginx -d $IP_PUBLICO --non-interactive --agree-tos -m amorimgg7@gmail.com
# certbot --nginx -d $IP_PUBLICO --non-interactive --agree-tos -m amorimgg7@gmail.com
certbot certonly --nginx -d $IP_PUBLICO --staging --non-interactive --agree-tos -m amorimgg7@gmail.com

# --------------------------
# Firewall
# --------------------------
ufw allow 22/tcp
ufw allow 80/tcp
ufw allow 443/tcp
ufw allow 1935/tcp
ufw --force enable

echo "======================================"
echo "✅ DVR ATIVISOFT + WhatsApp API PRONTO"
echo "RTMP: rtmp://$IP_PUBLICO/live/<camera>"
echo "WEB : https://$IP_PUBLICO"
echo "API : https://$IP_PUBLICO/api_camera.php?chave=<camera>"
echo "WhatsApp QR: https://$IP_PUBLICO/chat/qr/<numero>"
echo "======================================"
