#!/bin/bash
# ==========================================
# WhatsApp API ONLY
# Debian 12 + NGINX + PM2
# SEM SSL (IP DIRETO)
# ==========================================

set -e

# --------------------------
# VARIÁVEIS
# --------------------------
IP_PUBLICO="191.252.220.154"
WA_BASE="/srv/whatsapp-api"
WA_PORT=3001

# --------------------------
# SISTEMA
# --------------------------
apt update -y
apt upgrade -y

apt install -y \
nginx curl nano git \
ufw \
xvfb \
chromium \
nodejs npm

# --------------------------
# NODE LTS REAL
# --------------------------
npm install -g n
n lts
hash -r

node -v
npm -v

# --------------------------
# DIRETÓRIOS
# --------------------------
mkdir -p $WA_BASE/{sessions,keys,public}
cd $WA_BASE

# --------------------------
# WHATSAPP API (Node)
# --------------------------
cat > index.js <<'EOF'
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

if (!fs.existsSync('./keys')) fs.mkdirSync('./keys');

function saveKey(phone, apiKey){
  fs.appendFileSync(KEY_FILE, `${phone}|${apiKey}|CONNECTED|${Date.now()}\n`);
}

function invalidateKey(phone){
  if(!fs.existsSync(KEY_FILE)) return;
  const lines = fs.readFileSync(KEY_FILE,'utf8')
    .split('\n')
    .map(l => l.startsWith(phone+'|') ? l.replace('|CONNECTED|','|DISCONNECTED|') : l);
  fs.writeFileSync(KEY_FILE, lines.join('\n'));
}

function validateKey(phone,key){
  if(!fs.existsSync(KEY_FILE)) return false;
  return fs.readFileSync(KEY_FILE,'utf8')
    .split('\n')
    .some(l => l.startsWith(`${phone}|${key}|CONNECTED`));
}

function startSession(phone){
  if(SESSIONS[phone]) return;

  const client = new Client({
    authStrategy: new LocalAuth({
      clientId: phone,
      dataPath: './sessions'
    }),
    puppeteer: {
      headless: false,
      executablePath: '/usr/bin/chromium',
      args: [
        '--no-sandbox',
        '--disable-setuid-sandbox',
        '--disable-dev-shm-usage',
        '--disable-gpu',
        '--single-process'
      ]
    }

  });

  SESSIONS[phone] = { client, qr:null, ready:false, apiKey:null };

  client.on('authenticated', () => {
    if (!SESSIONS[phone]) return;
    console.log(`WhatsApp ${phone} autenticado`);
    SESSIONS[phone].qr = null;
  });

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
    invalidateKey(phone);
    delete SESSIONS[phone];
  });

  client.initialize();
}

app.get('/qr/:phone', (req,res) => {
  startSession(req.params.phone);
  res.sendFile(__dirname + '/public/qr.html');
});

app.get('/api/qr/:phone', (req,res) => {
  const s = SESSIONS[req.params.phone];
  if(!s) return res.json({status:'DISCONNECTED'});
  if(s.ready) return res.json({status:'CONNECTED', apiKey:s.apiKey});
  if(!s.qr) return res.json({status:'WAITING'});
  res.json({status:'QRCODE', qr:s.qr});
});

app.post('/api/send', async (req,res) => {
  const { phone, apiKey, to, message } = req.body;

  if(!validateKey(phone, apiKey))
    return res.status(401).json({erro:'API KEY inválida'});

  if(!SESSIONS[phone] || !SESSIONS[phone].ready)
    return res.status(400).json({erro:'Sessão não ativa'});

  try{
    await SESSIONS[phone].client.sendMessage(`${to}@c.us`, message);
    res.json({sucesso:true});
  }catch(e){
    res.status(500).json({erro:e.message});
  }
});

app.listen(3001, () => {
  console.log('WhatsApp API rodando na porta 3001');
});
EOF

# --------------------------
# HTML QR (CORRIGIDO)
# --------------------------
cat > public/qr.html <<'EOF'
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>WhatsApp QR</title>
</head>
<body>
<h2>Escaneie o QR Code</h2>
<div id="box">Inicializando sessão...</div>

<script>
const phone = location.pathname.split('/').pop();

async function check(){
  const r = await fetch('/api/qr/' + phone);
  const d = await r.json();

  if(d.status === 'CONNECTED'){
    box.innerHTML = `<h3>Conectado ✅</h3><p>API KEY:</p><code>${d.apiKey}</code>`;
    return;
  }

  if(d.status === 'QRCODE'){
    box.innerHTML = `<img src="${d.qr}" style="max-width:300px">`;
  }

  if(d.status === 'WAITING'){
    box.innerText = 'Gerando QR Code... ⏳';
  }

  setTimeout(check, 2000);
}
check();
</script>
</body>
</html>
EOF

# --------------------------
# DEPENDÊNCIAS
# --------------------------
npm install express whatsapp-web.js qrcode body-parser uuid
npm install -g pm2

pm2 start index.js --name whatsapp-api
pm2 save
pm2 startup systemd -u root --hp /root

# --------------------------
# NGINX
# --------------------------
cat > /etc/nginx/sites-available/whatsapp <<EOF
server {
    listen 80;
    server_name $IP_PUBLICO;

    location / {
        proxy_pass http://127.0.0.1:$WA_PORT;
        proxy_http_version 1.1;
        proxy_set_header Upgrade \$http_upgrade;
        proxy_set_header Connection "upgrade";
        proxy_set_header Host \$host;
    }
}
EOF

ln -sf /etc/nginx/sites-available/whatsapp /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

nginx -t
systemctl reload nginx

# --------------------------
# FIREWALL
# --------------------------
ufw allow 22
ufw allow 80
ufw --force enable

echo "========================================"
echo "✅ WHATSAPP API FUNCIONAL"
echo "QR: http://$IP_PUBLICO/qr/5511999999999"
echo "SEND: POST http://$IP_PUBLICO/api/send"
echo "========================================"
