#!/bin/bash
# ==========================================
# WhatsApp API (Baileys) - Docker
# Debian 12
# IP: 191.252.220.154
# ==========================================

set -e

IP_PUBLICO="191.252.220.154"
BASE_DIR="/srv/whatsapp-api"

echo "▶ Atualizando sistema..."
apt update -y
apt upgrade -y

echo "▶ Instalando dependências..."
apt install -y \
  curl \
  git \
  ca-certificates \
  gnupg \
  lsb-release

# --------------------------
# Docker
# --------------------------
echo "▶ Instalando Docker..."
curl -fsSL https://get.docker.com | sh
systemctl enable docker
systemctl start docker

# --------------------------
# Docker Compose (binário)
# --------------------------
echo "▶ Instalando Docker Compose..."
curl -L "https://github.com/docker/compose/releases/download/v2.27.0/docker-compose-linux-x86_64" \
  -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

# --------------------------
# Diretórios
# --------------------------
mkdir -p $BASE_DIR/app/auth
cd $BASE_DIR

# --------------------------
# docker-compose.yml
# --------------------------
cat > docker-compose.yml <<'EOF'
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
    command: >
      sh -c "
      npm install express qrcode @whiskeysockets/baileys &&
      node index.js
      "
    restart: unless-stopped
EOF

# --------------------------
# index.js (API REAL)
# --------------------------
cat > app/index.js <<'EOF'
const {
  default: makeWASocket,
  useMultiFileAuthState,
  DisconnectReason
} = require('@whiskeysockets/baileys')

const express = require('express')
const QRCode = require('qrcode')

const app = express()
app.use(express.json())

let sock
let qrCode = null

async function startSock() {
  const { state, saveCreds } = await useMultiFileAuthState('./auth')

  sock = makeWASocket({
    auth: state,
    printQRInTerminal: true
  })

  sock.ev.on('creds.update', saveCreds)

  sock.ev.on('connection.update', async (update) => {
    const { connection, qr, lastDisconnect } = update

    if (qr) {
      qrCode = await QRCode.toDataURL(qr)
      console.log('QR Code atualizado')
    }

    if (connection === 'open') {
      qrCode = null
      console.log('WhatsApp conectado ✅')
    }

    if (connection === 'close') {
      const shouldReconnect =
        lastDisconnect?.error?.output?.statusCode !== DisconnectReason.loggedOut
      if (shouldReconnect) startSock()
    }
  })
}

startSock()

// --------------------------
// ROTAS
// --------------------------
app.get('/status', (req, res) => {
  if (qrCode) {
    return res.json({ status: 'QRCODE', qr: qrCode })
  }
  return res.json({ status: 'CONNECTED' })
})

app.post('/send', async (req, res) => {
  try {
    const { to, message } = req.body

    if (!to || !message) {
      return res.status(400).json({ success: false, error: 'Dados inválidos' })
    }

    const jid = to.replace(/\D/g, '') + '@s.whatsapp.net'
    await sock.sendMessage(jid, { text: message })

    res.json({ success: true })
  } catch (e) {
    res.json({ success: false, error: e.message })
  }
})

app.listen(3001, () => {
  console.log('WhatsApp API rodando na porta 3001')
})
EOF

# --------------------------
# Subir container
# --------------------------
echo "▶ Iniciando WhatsApp API..."
docker-compose up -d

echo "========================================"
echo "✅ WHATSAPP API INSTALADA COM SUCESSO"
echo
echo "➡ STATUS / QR:"
echo "http://$IP_PUBLICO:3001/status"
echo
echo "➡ ENVIAR MENSAGEM:"
echo "POST http://$IP_PUBLICO:3001/send"
echo
echo "JSON:"
echo '{ "to": "5521999999999", "message": "Olá mundo" }'
echo "========================================"
