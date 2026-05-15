#!/bin/bash
# ==========================================================
# WhatsApp API Multi-Cliente + HTTPS NGINX
# Integração com RTMP já existente
# Debian 12
# ==========================================================

set -e

# --------------------------
# VARIÁVEIS
# --------------------------
WA_BASE="/srv/whatsapp-api"
WA_PORT=3001
IP_PUBLICO="vps63583.publiccloud.com.br"  # seu domínio

# --------------------------
# DEPENDÊNCIAS
# --------------------------
apt update -y
apt install -y nodejs npm git curl

mkdir -p $WA_BASE/{sessions,keys,public}

# --------------------------
# INDEX.JS (API WhatsApp)
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

  client.on('qr', async qr => {
    SESSIONS[phone].qr = await QRCode.toDataURL(qr);
  });

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

app.get('/qr/:phone',(req,res)=>{
  startSession(req.params.phone);
  res.sendFile(__dirname+'/public/qr.html');
});

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
  try{
    await SESSIONS[phone].client.sendMessage(`${to}@c.us`,message);
    res.json({sucesso:true});
  }catch(e){res.status(500).json({erro:e.message});}
});

app.listen(3001,()=>console.log('WhatsApp API rodando na porta 3001'));
EOF

# --------------------------
# QR PAGE
# --------------------------
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
# INSTALAR NODE MODULES
# --------------------------
cd $WA_BASE
npm install express whatsapp-web.js qrcode body-parser uuid fs

# --------------------------
# START COM PM2
# --------------------------
npm install -g pm2
pm2 start index.js --name whatsapp-api
pm2 save
pm2 startup systemd

# --------------------------
# NGINX /chat Proxy + SSL
# --------------------------
cat > /etc/nginx/sites-available/whatsapp-api <<EOF
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
 listen 443 ssl http2;
 server_name $IP_PUBLICO;

 ssl_certificate /etc/letsencrypt/live/$IP_PUBLICO/fullchain.pem;
 ssl_certificate_key /etc/letsencrypt/live/$IP_PUBLICO/privkey.pem;

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

ln -s /etc/nginx/sites-available/whatsapp-api /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx

echo "✅ WhatsApp API disponível em https://$IP_PUBLICO/chat/qr/<numero>"
