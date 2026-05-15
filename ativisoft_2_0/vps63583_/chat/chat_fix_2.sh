#!/bin/bash
# ==========================================
# WhatsApp API (Baileys) - Fix2
# Detecta desconexão real e QR Code atualizado
# Debian 12
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
let sock = null;
let qrCode = null;
let connected = false;

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
      connected = false;
      console.log('QR Code atualizado');
    }

    if (connection === 'open') {
      qrCode = null;
      connected = true;
      console.log('WhatsApp conectado ✅');
    }

    if (connection === 'close') {
      const reason = lastDisconnect?.error?.output?.statusCode;
      console.log('WhatsApp desconectado:', reason);

      if (reason === DisconnectReason.loggedOut) {
        connected = false;
        qrCode = null;
        console.log('Sessão finalizada. Reinicie para gerar QR Code.');
      } else {
        console.log('Tentando reconectar...');
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
  if (!connected) return res.json({ status: 'DISCONNECTED' });
  return res.json({ status: 'CONNECTED' });
});

app.post('/restart', async (req, res) => {
  try {
    if (fs.existsSync(AUTH_DIR)) {
      fs.rmSync(AUTH_DIR, { recursive: true, force: true });
    }
    qrCode = null;
    connected = false;
    await startSock();
    return res.json({ success: true, msg: 'Sessão reiniciada. Escaneie o QR Code novamente.' });
  } catch (e) {
    return res.status(500).json({ success: false, error: e.message });
  }
});

app.post('/send', async (req, res) => {
  try {
    const { to, message } = req.body;

    if (!to || !message) return res.status(400).json({ success: false, error: 'Dados inválidos' });
    if (!connected) return res.status(400).json({ success: false, error: 'WhatsApp não conectado' });

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
echo "✅ Script Fix2 aplicado"
echo "➡ STATUS / QR: http://191.252.220.154:3001/status"
echo "➡ RESTART sessão: POST http://191.252.220.154:3001/restart"
echo "➡ ENVIAR MENSAGEM: POST http://191.252.220.154:3001/send"
echo "========================================"
