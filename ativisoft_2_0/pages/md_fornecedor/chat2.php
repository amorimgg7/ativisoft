

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Enviar WhatsApp</title>

<style>
  body { font-family: Arial; max-width: 600px; margin: auto; }
  input, textarea, button { width: 100%; padding: 10px; margin: 6px 0; }
  button { background: #25D366; color: #fff; border: 0; cursor: pointer; }
  pre { background: #f4f4f4; padding: 10px; white-space: pre-wrap; }
  #qrBox { text-align: center; margin-bottom: 20px; }
</style>
</head>
<body>

<h2>📲 Enviar WhatsApp</h2>

<div id="qrBox">Verificando status...</div>

<div id="formBox" style="display:none;">
  <label>Destinatários (1 por linha)</label>
  <textarea id="to" rows="5" placeholder="5521999999999"></textarea>

  <label>Mensagem</label>
  <textarea id="message" rows="4"></textarea>

  <button onclick="send()">Enviar</button>

  <pre id="resp"></pre>
</div>

<script>
async function checkStatus() {
  try {
    const r = await fetch('proxy.php', { method:'POST' }); // sem body retorna status
    const d = await r.json();
    const qrBox = document.getElementById('qrBox');
    const formBox = document.getElementById('formBox');

    if(d.status === 'CONNECTED') {
      qrBox.style.display = 'none';
      formBox.style.display = 'block';
    } else if(d.status === 'QRCODE') {
      qrBox.style.display = 'block';
      formBox.style.display = 'none';
      qrBox.innerHTML = `<h3>Escaneie o QR Code</h3><img src="${d.qr}" style="max-width:300px">`;
    } else if(d.status === 'WAITING') {
      qrBox.style.display = 'block';
      formBox.style.display = 'none';
      qrBox.innerText = 'Gerando QR Code... ⏳';
    } else {
      qrBox.style.display = 'block';
      formBox.style.display = 'none';
      qrBox.innerText = 'Sessão desconectada ou erro';
    }

  } catch(e) {
    document.getElementById('qrBox').innerText = 'Erro ao conectar à API';
  }

  setTimeout(checkStatus, 3000); 
}
checkStatus();

async function send() {
  const message = document.getElementById('message').value.trim();
  const numbers = document.getElementById('to').value
    .split('\n')
    .map(n => n.replace(/\D/g,''))
    .filter(n => n.length >= 12);

  if(!message || numbers.length === 0){
    alert('Preencha corretamente');
    return;
  }

  let results = {};
  for(const n of numbers){
    try{
      const r = await fetch('proxy.php', {
        method: 'POST',
        headers: { 'Content-Type':'application/json' },
        body: JSON.stringify({ to: n, message })
      });
      const j = await r.json();
      results[n] = j.success ? 'Enviado ✅' : (j.error || 'Erro');
    } catch {
      results[n] = 'Erro de conexão';
    }
  }

  document.getElementById('resp').textContent = JSON.stringify(results, null, 2);
}
</script>

</body>
</html>
