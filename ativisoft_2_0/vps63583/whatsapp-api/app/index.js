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

const SESSIONS_DIR = './sessions';
if (!fs.existsSync(SESSIONS_DIR)) fs.mkdirSync(SESSIONS_DIR, { recursive: true });

const sessions = {};

// Função para iniciar sessão
async function startSession(phone) {
  const authPath = `${SESSIONS_DIR}/${phone}`;
  if (!fs.existsSync(authPath)) fs.mkdirSync(authPath, { recursive: true });

  const { state, saveCreds } = await useMultiFileAuthState(authPath);
  //const sock = makeWASocket({ auth: state, printQRInTerminal: true });
  const sock = makeWASocket({
    auth: state,
    printQRInTerminal: false,
    browser: ['Ubuntu', 'Chrome', '120.0.0']
  });

  sessions[phone] = { sock, qrCode: null, connected: false };

  sock.ev.on('creds.update', saveCreds);

  sock.ev.on('connection.update', async (update) => {
    const { connection, qr, lastDisconnect } = update;

    if (qr) {
      sessions[phone].qrCode = await QRCode.toDataURL(qr);
      sessions[phone].connected = false;
      console.log(`QR Code atualizado para ${phone}`);
    }

    if (connection === 'open') {
      sessions[phone].qrCode = null;
      sessions[phone].connected = true;
      console.log(`WhatsApp conectado ✅ para ${phone}`);
    }

    if (connection === 'close') {
      const reason = lastDisconnect?.error?.output?.statusCode;
      sessions[phone].connected = false;
      console.log(`WhatsApp desconectado ${phone}:`, reason);

      if (reason === DisconnectReason.loggedOut) {
        console.log(`Sessão finalizada para ${phone}, removendo credenciais...`);
        fs.rmSync(authPath, { recursive: true, force: true });
        await startSession(phone);
      } else {
        console.log(`Tentando reconectar para ${phone}...`);
        await startSession(phone);
      }
    }
  });

  return sock;
}

// --------------------------
// ROTAS
// --------------------------

// Listar sessões ativas
app.get('/sessions', (req, res) => {
  const list = Object.keys(sessions).map(phone => ({
    phone,
    connected: sessions[phone].connected,
    hasQr: !!sessions[phone].qrCode
  }));

  res.json({
    total: list.length,
    sessions: list
  });
});

// Status / QR
app.get('/status/:phone', async (req, res) => {
  const phone = req.params.phone;
  if (!sessions[phone]) await startSession(phone);
  const s = sessions[phone];
  if (s.qrCode) return res.json({ status: 'QRCODE', qr: s.qrCode });
  if (!s.connected) return res.json({ status: 'DISCONNECTED', qr: null });
  return res.json({ status: 'CONNECTED' });
});

// Enviar mensagem
app.post('/send/:session', async (req, res) => {
  try {
    const session = req.params.session;
    const { to, message } = req.body;

    if (!to || !message) {
      return res.status(400).json({
        success: false,
        error: 'Destinatário ou mensagem inválidos'
      });
    }

    const s = sessions[session];
    if (!s) {
      return res.status(400).json({
        success: false,
        error: 'Sessão não iniciada'
      });
    }

    if (!s.connected || !s.sock) {
      return res.status(400).json({
        success: false,
        error: 'WhatsApp não conectado'
      });
    }

    const jid = to.replace(/\D/g, '') + '@s.whatsapp.net';

    await s.sock.sendMessage(jid, { text: message });

    return res.json({ success: true });

  } catch (e) {
    console.error('Erro ao enviar:', e);
    return res.status(500).json({
      success: false,
      error: e.message
    });
  }
});



// Reiniciar sessão
app.post('/restart/:phone', async (req, res) => {
  try {
    const phone = req.params.phone;
    const authPath = `${SESSIONS_DIR}/${phone}`;
    if (fs.existsSync(authPath)) fs.rmSync(authPath, { recursive: true, force: true });
    sessions[phone] = { sock: null, qrCode: null, connected: false };
    await startSession(phone);
    return res.json({ success: true, msg: `Sessão reiniciada para ${phone}. Escaneie o QR Code novamente.` });
  } catch (e) {
    return res.status(500).json({ success: false, error: e.message });
  }
});

app.listen(3001, () => console.log('WhatsApp API rodando na porta 3001'));
