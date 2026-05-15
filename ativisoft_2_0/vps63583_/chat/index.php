<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Enviar WhatsApp</title>
<style>
body {
  font-family: Arial;
  max-width: 600px;
  margin: auto;
}
input, textarea, button {
  width: 100%;
  padding: 10px;
  margin: 6px 0;
}
button {
  background: #25D366;
  color: #fff;
  border: 0;
  cursor: pointer;
}
pre {
  background: #f4f4f4;
  padding: 10px;
  white-space: pre-wrap;
}
#qr img { max-width: 300px; }
</style>
</head>
<body>

<h2>📲 WhatsApp</h2>

<button onclick="restart()">Reiniciar Sessão</button>
<script>
async function restart() {
  if(!confirm("Deseja realmente reiniciar a sessão?")) return;
  const r = await fetch('proxy.php/restart', { method:'POST' });
  const j = await r.json();
  alert(j.msg);
}
</script>


<div id="status">
  <p>Carregando status...</p>
</div>

<div id="form" style="display:none">
  <label>Destinatários (1 por linha)</label>
  <textarea id="to" rows="5" placeholder="5521999999999"></textarea>

  <label>Mensagem</label>
  <textarea id="message" rows="4"></textarea>

  <button onclick="send()">Enviar</button>
  <pre id="resp"></pre>
</div>

<div id="qr" style="display:none">
  <h3>Escaneie o QR Code</h3>
  <div id="qrcode">Aguardando QR...</div>
</div>

<script>
async function checkStatus() {
  try {
    const r = await fetch('proxy.php/status');
    const d = await r.json();
    const statusDiv = document.getElementById('status');
    const formDiv = document.getElementById('form');
    const qrDiv = document.getElementById('qr');

    if(d.status === 'CONNECTED') {
      statusDiv.innerHTML = '<strong>Status:</strong> Conectado ✅';
      formDiv.style.display = 'block';
      qrDiv.style.display = 'none';
    } else if(d.status === 'QRCODE') {
      statusDiv.innerHTML = '<strong>Status:</strong> Desconectado ❌';
      formDiv.style.display = 'none';
      qrDiv.style.display = 'block';
      document.getElementById('qrcode').innerHTML = `<img src="${d.qr}">`;
    } else {
      statusDiv.innerHTML = '<strong>Status:</strong> Desconhecido';
      formDiv.style.display = 'none';
      qrDiv.style.display = 'none';
    }
  } catch (e) {
    document.getElementById('status').innerHTML = 'Erro ao conectar à API';
  }
  setTimeout(checkStatus, 3000); // Atualiza a cada 3s
}

async function send() {
  const message = document.getElementById('message').value.trim();
  const numbers = document.getElementById('to').value
    .split('\n')
    .map(n => n.replace(/\D/g, ''))
    .filter(n => n.length >= 12);

  if(!message || numbers.length === 0) {
    alert("Preencha corretamente");
    return;
  }

  let results = {};

  for(const n of numbers) {
    try {
      const r = await fetch('proxy.php', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({to: n, message})
      });
      const j = await r.json();
      results[n] = j.success ? 'Enviado ✅' : (j.error || 'Erro');
    } catch {
      results[n] = 'Erro de conexão';
    }
  }

  document.getElementById('resp').textContent = JSON.stringify(results, null, 2);
}

checkStatus();
</script>

</body>
</html>
