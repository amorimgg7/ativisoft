<?php
session_start();

// 1. Otimização: Usar header nativo do PHP para redirecionamentos sempre que possível.
if (isset($_SESSION['tipo_pessoa']) && $_SESSION['tipo_pessoa'] == 'cliente') {
    $url = "../md_assistencia/acompanha_servico.php?cnpj=" . urlencode($_SESSION['cnpj_empresa_cliente']) . "&tel=" . urlencode($_SESSION['tel_cliente']);
    // Como precisamos do window.alert aqui, mantemos o script, mas garantimos o exit.
    echo "<script>window.alert('Area do cliente'); location.href='{$url}';</script>";
    exit; 
}

if (!isset($_SESSION['cd_colab'])) {
    header("Location: " . $_SESSION['dominio'] . "/pages/samples/login.php");
    exit; 
}

if (empty($_SESSION['senha_colab'])) {
    header("Location: " . $_SESSION['dominio'] . "/pages/samples/lock-screen.php");
    exit;
}

require_once '../../classes/conn.php';
include("../../classes/functions.php");

$u = new Usuario;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <!-- Required meta tags --> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <title>Dashboard</title>
  
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/flag-icon-css/css/flag-icon.min.css"/>
  <link rel="stylesheet" href="../../vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars-o.css">
  <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars.css"> 
  
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="manifest" href="manifest.json">

  <style>
    #installBtn { display: none; }
  </style>

  <?php
    $cnpj_empresa = isset($_SESSION['cnpj_empresa']) ? $_SESSION['cnpj_empresa'] : 'default';
    $caminho_foto_empresa = "../web/imagens/{$cnpj_empresa}/logos/LogoEmpresa.jpg";

    if (file_exists($caminho_foto_empresa)) {
        $tipo_foto_empresa = mime_content_type($caminho_foto_empresa);
        $base64 = base64_encode(file_get_contents($caminho_foto_empresa));
        echo "<link rel='icon' href='data:{$tipo_foto_empresa};base64,{$base64}' />";
    } else {
        echo "<link rel='icon' href='https://lh3.googleusercontent.com/pw/AP1GczOReqQClzL-PZkykfOwgmMyVzQgx27DTp783MI7iwKuKSv-6P6V7KOEbCC74sGdK3DEV3O88CsBLeIvOaQwGT3x4bqCTPRtyV9zcODbYVDRxAF8zf8Uev7geh4ONPdl3arNhnSDPvbQfMdpFRPM263V9A=w250-h250-s-no-gm?authuser=0' />";
    }
  ?>

  <script>
    // Configurações visuais que vêm da sessão
    document.addEventListener("DOMContentLoaded", function() {
        let cBody = '<?php echo htmlspecialchars($_SESSION['c_body'] ?? '', ENT_QUOTES); ?>';
        let cCard = '<?php echo htmlspecialchars($_SESSION['c_card'] ?? '', ENT_QUOTES); ?>';
        
        if(document.getElementById("c_body")) document.getElementById("c_body").style = cBody;
        if(document.getElementById("c_card")) document.getElementById("c_card").style = cCard;
    });
  </script>
</head>

<body>
  <script src="../../js/gtag.js"></script>
  <script src="../../js/functions.js"></script>

  <div class="container-scroller">
    <?php include ("../../partials/_navbar.php"); ?>
    
    <div class="container-fluid page-body-wrapper">
      <?php include ("../../partials/_sidebar.php"); ?>
      
      <div class="main-panel">
        <div class="content-wrapper" <?php echo $_SESSION['c_body'] ?? ''; ?>>

          <!-- Botão PWA -->
          <button id="installBtn" class="btn btn-block btn-social-icon-text btn-success" style="margin: 5px;">
            <i class="mdi mdi-anchor"></i>... Instalar Aplicativo ...<i class="mdi mdi-anchor"></i>
          </button>

          <!-- Topo Dashboard -->
          <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
              <?php if (empty($_SESSION['cd_empresa'])): ?>
                <h1>...</h1>
              <?php else: ?>
                <p class="font-weight-normal mb-2 text-muted">
                  <?php echo htmlspecialchars($_SESSION['cd_empresa']) . ' - ' . strtoupper(htmlspecialchars($_SESSION['nfantasia_empresa'])); ?>
                </p>
              <?php endif; ?>
              <p class="font-weight-normal mb-2 text-muted"><span id="data-atual" <?php echo $_SESSION['c_body'] ?? ''; ?>></span></p>
            </div>
          </div>

          <!-- Seção de Câmeras -->
          <div class="row flex-grow">
            <div class="container mt-4">
              <div class="row" id="card_cameras">
                <div class="col-12 text-center">Carregando câmeras…</div>
              </div>
            </div>
          </div>

          <!-- MODAL COPIAR LINK RTMP -->
          <div class="modal fade" id="modalCamera" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Adicionar / Copiar Link RTMP</h5>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Chave RTMP</label>
                    <div class="input-group">
                      <input type="text" id="rtmpKey" class="form-control" readonly>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" onclick="copiarRTMP()">Copiar</button>
                      </div>
                    </div>
                    <small class="form-text text-muted mt-2">Use essa URL no OBS ou câmera IP</small>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                  <button class="btn btn-primary" onclick="confirmarCamera()">Confirmar</button>
                </div>
              </div>
            </div>
          </div>

          <!-- MODAL PLAYER -->
          <div class="modal fade" id="playerModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
              <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalTitle"></h5>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <video id="video" class="w-100" controls autoplay></video>
                </div>
              </div>
            </div>
          </div>

          <!-- MODAL INFORMAÇÕES DA CÂMERA -->
          <div class="modal fade" id="modalInfoCamera" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header bg-info text-white">
                  <h5 class="modal-title"><i class="mdi mdi-information-outline"></i> Detalhes da Câmera</h5>
                  <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <table class="table table-sm table-borderless">
                    <tbody>
                      <tr><th scope="row">Chave:</th><td id="infoCamChave"></td></tr>
                      <tr><th scope="row">Empresa:</th><td id="infoCamEmpresa" class="font-weight-bold text-primary"></td></tr>
                      <tr><th scope="row">Fabricante:</th><td id="infoCamFabricante"></td></tr>
                      <tr><th scope="row">Marca:</th><td id="infoCamMarca"></td></tr>
                      <tr><th scope="row">Modelo:</th><td id="infoCamModelo"></td></tr>
                      <tr><th scope="row">Data de Cadastro:</th><td id="infoCamData"></td></tr>
                    </tbody>
                  </table>

                  <hr>

                  <!-- Campo de Link RTMP para Reconexão -->
                  <div class="form-group mb-0">
                    <label class="font-weight-bold">Link RTMP para Reconexão:</label>
                    <div class="input-group">
                      <input type="text" id="infoCamRtmpUrl" class="form-control bg-light" readonly>
                      <div class="input-group-append">
                        <button class="btn btn-outline-primary" onclick="copiarRTMPDetalhes()">
                          <i class="mdi mdi-content-copy"></i> Copiar
                        </button>
                      </div>
                    </div>
                    <small class="form-text text-muted">Copie e cole este link no OBS, Encoder ou Câmera IP para reconectar a transmissão.</small>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
              </div>
            </div>
          </div>

        </div>
        <?php include("../../partials/_footer.php"); ?>
      </div>
    </div>
  </div>

  <!-- base:js e plugins -->
  <script src="../../vendors/base/vendor.bundle.base.js"></script>
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
  <script src="../../js/dashboard.js"></script>
  
  <!-- HLS para Câmeras -->
  <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
  
  <script>
    /* ===============================
       PWA SCRIPT
    =================================*/
    let deferredPrompt;
    const installBtn = document.getElementById('installBtn');

    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('sw.js')
        .then(() => console.log('Service Worker registrado com sucesso.'))
        .catch((error) => console.error('Erro ao registrar Service Worker:', error));
    }

    window.addEventListener('beforeinstallprompt', (e) => {
      e.preventDefault();
      deferredPrompt = e;
      installBtn.style.display = 'block';
    });

    installBtn.addEventListener('click', () => {
      deferredPrompt.prompt();
      deferredPrompt.userChoice.then((choiceResult) => {
        installBtn.style.display = 'none';
        deferredPrompt = null;
      });
    });

    window.addEventListener('appinstalled', () => {
      installBtn.style.display = 'none';
    });

    if (window.matchMedia('(display-mode: standalone)').matches) {
      installBtn.style.display = 'none';
    }

    /* ===============================
       DATA ATUAL
    =================================*/
    const data = new Date();
    const mesPorExtenso = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(data).toUpperCase();
    document.getElementById("data-atual").innerHTML = `HOJE É ${data.getDate()} DE ${mesPorExtenso}, ${data.getFullYear()}`;

    /* ===============================
       CONFIGURAÇÃO CÂMERAS
    =================================*/
    const API_BASE = "https://vps63583.publiccloud.com.br/api_camera.php";
    const RTMP_BASE = "rtmp://vps63583.publiccloud.com.br/live/";
    
    <?php
      $cameras_php = $u->conCams('all', ''); 
      $cameras_list = $cameras_php['list_cameras'] ?? [];
      
      $cameras_json = [];
      foreach($cameras_list as $cam) {
          $cameras_json[] = [
              'chave' => $cam['chave_camera'] ?? '',
              'fabricante' => $cam['fabricante_camera'] ?? 'Não informado',
              'marca' => $cam['marca_camera'] ?? 'Não informado',
              'modelo' => $cam['modelo_camera'] ?? 'Não informado',
              'dt_cadastro' => $cam['dt_cadastro_camera'] ?? 'Não informado',
              'empresa' => $cam['nfantasia_empresa'] ?? ($cam['cd_empresa'] ? 'Empresa ID: '.$cam['cd_empresa'] : 'Sem empresa vinculada')
          ];
      }
    ?>
    let CAMERAS_DATA = <?php echo json_encode($cameras_json); ?>;
    const MAX_CAMERAS = 999;

    function gerarChave(tamanho = 12) {
      const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      return Array.from({length: tamanho}, () => chars.charAt(Math.floor(Math.random() * chars.length))).join('');
    }

    function abrirModalAddCamera(chave = null) {
      const rtmpChave = chave || gerarChave();
      document.getElementById("rtmpKey").value = RTMP_BASE + rtmpChave;
      $('#modalCamera').modal('show');
    }

    function copiarRTMP() {
      const input = document.getElementById("rtmpKey");
      input.select();
      document.execCommand("copy");
      alert("RTMP copiado!");
    }

    function carregarCameras() {
      const container = document.getElementById("card_cameras");
      if (!container) return;

      if (CAMERAS_DATA.length === 0) {
        container.innerHTML = `
          <div class="col-12 text-center">
            <p class="mb-3">Nenhuma câmera cadastrada</p>
            <button class="btn btn-primary" onclick="abrirModalAddCamera()">+ Adicionar nova câmera</button>
          </div>`;
        return;
      }

      Promise.all(
        CAMERAS_DATA.map(camObj =>
          fetch(`${API_BASE}?chave=${encodeURIComponent(camObj.chave)}`)
            .then(r => r.ok ? r.json() : Promise.reject())
            .then(d => ({ ...camObj, d }))
            .catch(() => ({ ...camObj, d: { status: "INEXISTENTE", imagem: "", video: "" } }))
        )
      ).then(resultados => {
        let html = "";
        
        resultados.forEach((camObj) => {
          let d = camObj.d;
          let chave = camObj.chave;

          if (d.status === "inexistente" || d.status === "INEXISTENTE") {
            html += `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card h-100 border border-primary d-flex align-items-center justify-content-center"
                     style="cursor:pointer" onclick="abrirModalAddCamera('${chave}')">
                    <div class="text-primary text-center p-3">
                        <h1>+</h1>
                        <div>Vincular Chave Inexistente</div>
                        <small class="text-muted d-block mt-2">${chave}</small>
                    </div>
                </div>
            </div>`;
          } else {
            const statusClass = d.status === "ONLINE" ? "text-success" : "text-danger";
            
            html += `
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card h-100 shadow-sm border-0">
                  <!-- Corpo do Card (Abre o Vídeo) -->
                  <div class="card-body text-center p-3" style="cursor:pointer" onclick="abrirPlayer('${chave}', '${d.video || ""}', '${d.status}')">
                    
                    <!-- Tag com o Nome da Empresa -->
                    <div class="badge badge-primary mb-2 text-wrap w-100" style="font-size: 0.75rem;">
                       <i class="mdi mdi-domain"></i> ${camObj.empresa}
                    </div>
                    
                    <h5 class="card-title text-truncate mb-1" title="${chave}">${chave}</h5>
                    <div class="${statusClass} font-weight-bold mb-2" style="font-size: 0.85rem;">${d.status}</div>
                  </div>
                  
                  <!-- Rodapé do Card (Marca e Botão Info) -->
                  <div class="card-footer bg-white border-top-0 pt-0 pb-3 px-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted text-truncate" style="max-width: 60%;">${camObj.marca}</small>
                    <button class="btn btn-sm btn-outline-info py-1 px-2" onclick="abrirInfoCamera(event, '${chave}')">
                      Info <i class="mdi mdi-information-outline"></i>
                    </button>
                  </div>

                </div>
              </div>`;
          }
        });

        if (CAMERAS_DATA.length < MAX_CAMERAS) {
          html += `
            <div class="col-12 text-center mt-3">
              <button class="btn btn-outline-primary shadow-sm" onclick="abrirModalAddCamera()">
                ➕ Adicionar nova câmera
              </button>
            </div>`;
        }

        container.innerHTML = html;
      });
    }

    // Função para abrir o Modal de Informações
    function abrirInfoCamera(event, chave) {
        event.stopPropagation(); // Impede que o clique abra o player de vídeo
        
        const cam = CAMERAS_DATA.find(c => c.chave === chave);
        if(!cam) return;

        // Preenche as informações na tabela
        document.getElementById("infoCamChave").innerText = cam.chave;
        document.getElementById("infoCamEmpresa").innerText = cam.empresa;
        document.getElementById("infoCamFabricante").innerText = cam.fabricante;
        document.getElementById("infoCamMarca").innerText = cam.marca;
        document.getElementById("infoCamModelo").innerText = cam.modelo;
        document.getElementById("infoCamData").innerText = cam.dt_cadastro;
        
        // Preenche a URL RTMP completa para reconexão
        document.getElementById("infoCamRtmpUrl").value = RTMP_BASE + cam.chave;
        
        // Exibe o Modal
        $('#modalInfoCamera').modal('show');
    }

    // Copiar RTMP do Modal de Detalhes
    function copiarRTMPDetalhes() {
        const input = document.getElementById("infoCamRtmpUrl");
        input.select();
        input.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Link RTMP copiado com sucesso!");
    }

    // Confirmação de Adição de Câmera
    function confirmarCamera() {
      const rtmp = document.getElementById("rtmpKey").value;
      const chave = rtmp.replace(RTMP_BASE, "");

      $.ajax({
        url: 'confirmar_camera.php',
        type: 'POST',
        data: { rtmp: chave },
        success: function(response) {
          $("#modalCamera .modal-body").prepend(
            `<div class="alert alert-success alert-dismissible fade show" role="alert">
                ${response}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>`
          );
          
          if (!CAMERAS_DATA.some(c => c.chave === chave)) {
            CAMERAS_DATA.push({
                chave: chave,
                empresa: "Recém Adicionada",
                fabricante: "-", marca: "-", modelo: "-", dt_cadastro: "Agora"
            });
          }
          
          carregarCameras();
          setTimeout(() => $('#modalCamera').modal('hide'), 2000);
        },
        error: () => alert('Erro ao processar a requisição.')
      });
    }

    let hls;
    function abrirPlayer(nome, url, status) {
      if (status === "INEXISTENTE") {
        abrirModalAddCamera(nome);
        return;
      }
      if (!url || status === "OFFLINE") {
        alert("Câmera offline");
        return;
      }

      document.getElementById("modalTitle").innerText = nome;
      let video = document.getElementById("video");

      if (hls) {
        hls.destroy();
        hls = null;
      }

      if (Hls.isSupported()) {
        hls = new Hls({ lowLatencyMode: true });
        hls.loadSource(url);
        hls.attachMedia(video);
      } else {
        video.src = url;
      }

      $('#playerModal').modal('show');
    }

    carregarCameras();
    setInterval(carregarCameras, 5000);
  </script>
</body>
</html>