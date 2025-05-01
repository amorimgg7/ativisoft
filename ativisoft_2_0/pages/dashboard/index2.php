<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meu PWA</title>
  <link rel="manifest" href="manifest.json">
  <link rel="icon" href="icon-192x192.png">
  <style>
    #installBtn, #installedMessage {
      display: none;
      padding: 10px 20px;
      font-size: 16px;
      margin-top: 20px;
      cursor: pointer;
    }
    #installBtn {
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
    }
    #installedMessage {
      color: green;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <h1>Meu PWA</h1>
  <button id="installBtn">Instalar Aplicativo</button>
  <p id="installedMessage">Aplicativo já instalado!</p>
  
  <script>
    let deferredPrompt;
    const installBtn = document.getElementById('installBtn');
    const installedMessage = document.getElementById('installedMessage');

    // Verifica se o Service Worker está registrado
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('sw.js')
        .then(() => console.log('Service Worker registrado com sucesso.'))
        .catch((error) => console.error('Erro ao registrar Service Worker:', error));
    }

    // Evento para exibir o botão de instalação
    window.addEventListener('beforeinstallprompt', (e) => {
      e.preventDefault();
      deferredPrompt = e;
      installBtn.style.display = 'block'; // Exibe o botão de instalação
    });

    // Ação do botão de instalação
    installBtn.addEventListener('click', () => {
      deferredPrompt.prompt();
      deferredPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
          console.log('Usuário aceitou instalar.');
          installBtn.style.display = 'none';
          installedMessage.style.display = 'block'; // Exibe mensagem após instalação
        } else {
          console.log('Usuário cancelou a instalação.');
        }
        deferredPrompt = null;
      });
    });

    // Evento para quando o app é instalado
    window.addEventListener('appinstalled', () => {
      console.log('Aplicativo instalado com sucesso!');
      installBtn.style.display = 'none';
      installedMessage.style.display = 'block'; // Exibe mensagem após instalação
    });

    // Verifica se o app já está instalado
    if (window.matchMedia('(display-mode: standalone)').matches) {
      installBtn.style.display = 'none';
      installedMessage.style.display = 'block'; // Mensagem de app já instalado
    }
  </script>
</body>
</html>
