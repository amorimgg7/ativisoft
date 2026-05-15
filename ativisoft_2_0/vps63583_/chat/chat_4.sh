#!/bin/bash
# ==========================================
# WhatsApp API Multi-Número - Docker
# Debian 12
# IP: 191.252.220.154
# ==========================================

set -e

IP_PUBLICO="191.252.220.154"
BASE_DIR="/srv/whatsapp-api"
API_KEY="MINHA_CHAVE_SECRETA"

echo "▶ Atualizando sistema..."
apt update -y
apt upgrade -y

echo "▶ Instalando dependências..."
apt install -y curl git ca-certificates gnupg lsb-release

# --------------------------
# Docker
# --------------------------
echo "▶ Instalando Docker..."
curl -fsSL https://get.docker.com | sh
systemctl enable docker
systemctl start docker

# --------------------------
# Docker Compose
# --------------------------
echo "▶ Instalando Docker Compose..."
curl -L https://github.com/docker/compose/releases/download/v2.27.0/docker-compose-linux-x86_64 \
  -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

# --------------------------
# Diretórios
# --------------------------
mkdir -p $BASE_DIR/app/sessions
cd $BASE_DIR

# --------------------------
# docker-compose.yml
# --------------------------
cat > docker-compose.yml <<EOF
version: "3.9"

services:
  whatsapp:
    image: node:20
    container_name: whatsapp-api
    working_dir: /app
    volumes:
      - ./app:/app
    ports:
      - "3001:3001"
    environment:
      - API_KEY=$API_KEY
    command: >
      sh -c "
      npm install express qrcode @whiskeysockets/baileys &&
      node index.js
      "
    restart: unless-stopped
EOF

# --------------------------
# index.js
# --------------------------
cat > app/index.js <<'EOF'
const {
  default: makeWASocket,
  useMultiFileAuthState,
  DisconnectReason
} = require('@whiskeysockets/baileys')

const express = require('express')
const QRCode = require('qrcode')
const fs = require('fs')
const path = require('path')

const API_KEY = process.env.API_KEY
const app = express()
app.use(express.json())

const sessions = {}

function getSessionDir(phone) {
  return path.join(__dirname, 'sessions', phone)
}

async function startSession(phone) {
  if (sessions[phone]?.sock) return

  const sessionDir = getSessionDir(phone)
  fs.mkdirSync(sessionDir, { recursive: true })

  const { state, saveCreds } = await useMultiFileAuthState(sessionDir)

  const sock = makeWASocket({
    auth: state,
    printQRInTerminal: false
  })

  sessions[phone] = {
    sock,
    status: 'CONNECTING',
    qr: null
  }

  sock.ev.on('creds.update', saveCreds)

  sock.ev.on('connection.update', async (update) => {
    const { connection, qr, lastDisconnect } = update

    if (qr) {
      sessions[phone].qr = await QRCode.toDataURL(qr)
      sessions[phone].status = 'QRCODE'
      console.log(`[${phone}] QR Code gerado`)
    }

    if (connection === 'open') {
      sessions[phone].qr = null
      sessions[phone].status = 'CONNECTED'
      console.log(`[${phone}] Conectado ✅`)
    }

    if (connection === 'close') {
      sessions[phone].status = 'DISCONNECTED'
      const shouldReconnect =
        lastDisconnect?.error?.output?.statusCode !== DisconnectReason.loggedOut
      if (shouldReconnect) {
        console.log(`[${phone}] Reconectando em 3s... 🔄`)
        setTimeout(() => startSession(phone), 3000)
      }
    }
  })
}

// --------------------------
// ROTAS
// --------------------------

app.get('/status/:phone', async (req, res) => {
  const phone = req.params.phone.replace(/\D/g, '')
  await startSession(phone)
  const s = sessions[phone]

  if (s.qr) return res.json({ status: 'QRCODE', qr: s.qr })
  return res.json({ status: s.status })
})

app.post('/send', async (req, res) => {
  const { api_key, to, message } = req.body

  if (api_key !== API_KEY) {
    return res.status(401).json({ success: false, error: 'API KEY inválida' })
  }

  if (!to || !message) {
    return res.json({ success: false, error: 'Dados inválidos' })
  }

  const phone = to.replace(/\D/g, '')

  if (!sessions[phone] || sessions[phone].status !== 'CONNECTED') {
    return res.json({ success: false, error: 'WhatsApp desconectado' })
  }

  try {
    const jid = phone + '@s.whatsapp.net'
    await sessions[phone].sock.sendMessage(jid, { text: message })
    res.json({ success: true })
  } catch (e) {
    res.json({ success: false, error: e.message })
  }
})

app.listen(3001, () => {
  console.log('🚀 WhatsApp API Multi-Número rodando na porta 3001')
})
EOF

# --------------------------
# Subir container
# --------------------------
docker-compose up -d --build

echo "========================================"
echo "✅ WHATSAPP API INSTALADA COM SUCESSO"
echo
echo "➡ STATUS / QR (ex: número 5521965543094):"
echo "http://$IP_PUBLICO:3001/status/5521965543094"
echo
echo "➡ ENVIAR MENSAGEM (POST com JSON e API_KEY):"
echo "http://$IP_PUBLICO:3001/send"
echo
echo "JSON EXEMPLO:"
echo '{ "api_key": "MINHA_CHAVE_SECRETA", "to": "5521965543094", "message": "Olá mundo" }'
echo "========================================"
