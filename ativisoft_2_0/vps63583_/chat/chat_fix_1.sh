#!/bin/bash
# ==========================================
# WhatsApp API (Baileys) - Fix1
# Atualiza index.js com suporte a restart e status real
# Debian 12
# IP: 191.252.220.154
# ==========================================

set -e

BASE_DIR="/srv/whatsapp-api"
APP_DIR="$BASE_DIR/app"

echo "▶ Parando container..."
docker-compose -f $BASE_DIR/docker-compose.yml down || true

echo "▶ Atualizando index.js..."

cat > $APP_DIR/index.js <<'EOF'
const {
  default: makeWASocket,
  useMultiFileAuthState,
  DisconnectReason
} = require('@whiskeysockets/baileys');

const express = require('express');
const QRCode = require('qrcode');
const fs = require('fs');

const app = express();
app.use(express.json());

const AUTH_DIR = './auth';
let sock;
let qrCode = null;

async function startSock() {
  const { state, saveCreds } = await useMultiFileAuthState(AUTH_DIR);

  sock = makeWASocket({
    auth: state,
    printQRInTerminal: true
  });

  sock.ev.on('creds.update', saveCreds);

  sock.ev.on('connection.update', async (update) => {
    const { connection, qr, lastDisconnect } = update;

    if (qr) {
      qrCode = await QRCode.toDataURL(qr);
      console.log('QR Code atualizado');
    }

    if (connection === 'open') {
      qrCode = null;
      console.log('WhatsApp conectado ✅');
    }

    if (connection === 'close') {
      const reason = lastDisconnect?.error?.output?.statusCode;
      console.log('WhatsApp desconectado:', reason);

      if (reason === DisconnectReason.loggedOut) {
        console.log('Sessão finalizada, reinicie para gerar QR Code novamente.');
        qrCode = null;
      } else {
        startSock();
      }
    }
  });
}

startSock();

// --------------------------
// ROTAS
// --------------------------

app.get('/status', (req, res) => {
  if (qrCode) return res.json({ status: 'QRCODE', qr: qrCode });
  if (!sock || sock?.user === undefined) return res.json({ status: 'DISCONNECTED' });
  return res.json({ status: 'CONNECTED' });
});

app.post('/restart', (req, res) => {
  try {
    if (fs.existsSync(AUTH_DIR)) {
      fs.rmSync(AUTH_DIR, { recursive: true, force: true });
    }
    qrCode = null;
    startSock();
    return res.json({ success: true, msg: 'Sessão reiniciada. Escaneie o QR Code novamente.' });
  } catch (e) {
    return res.status(500).json({ success: false, error: e.message });
  }
});

app.post('/send', async (req, res) => {
  try {
    const { to, message } = req.body;

    if (!to || !message) {
      return res.status(400).json({ success: false, error: 'Dados inválidos' });
    }

    if (!sock || sock?.user === undefined) {
      return res.status(400).json({ success: false, error: 'WhatsApp não conectado' });
    }

    const jid = to.replace(/\D/g, '') + '@s.whatsapp.net';
    await sock.sendMessage(jid, { text: message });

    res.json({ success: true });
  } catch (e) {
    res.json({ success: false, error: e.message });
  }
});

app.listen(3001, () => console.log('WhatsApp API rodando na porta 3001'));
EOF

echo "▶ Reiniciando container..."
docker-compose -f $BASE_DIR/docker-compose.yml up -d

echo "========================================"
echo "✅ Atualização concluída"
echo "➡ STATUS / QR: http://191.252.220.154:3001/status"
echo "➡ RESTART sessão: POST http://191.252.220.154:3001/restart"
echo "➡ ENVIAR MENSAGEM: POST http://191.252.220.154:3001/send"
echo "========================================"
