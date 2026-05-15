<?php
  session_start();
    
    //echo "<script>window.alert('colab 6:".$_SESSION['cd_colab']."');</script>";
    if(isset($_SESSION['tipo_pessoa'])){
      if($_SESSION['tipo_pessoa'] == 'cliente'){
        echo "<script>window.alert('Area do cliente');</script>";
                    echo "<script>location.href='../md_assistencia/acompanha_servico.php?cnpj=".$_SESSION['cnpj_empresa_cliente']."&tel=".$_SESSION['tel_cliente']."';</script>";
                    //http://localhost/ativisoft_2_0/pages/md_assistencia/acompanha_servico.php?cnpj=85073246000146&tel=5521965543094
                    exit; 
      }
    }
    if(!isset($_SESSION['cd_colab']))
    {
        //header("location: http://amorimgg77.lovestoblog.com/pages/samples/login.php");
        //echo "<script>window.alert('colab 7:".$_SESSION['cd_colab']."');</script>";
        echo '<script>location.href="'.$_SESSION['dominio'].'/pages/samples/login.php";</script>';    
        //exit; 
    }
    if($_SESSION['senha_colab'] == "")
    {
      //header("location: http://amorimgg77.lovestoblog.com/pages/samples/lock-screen.php");
      echo '<script>location.href="'.$_SESSION['dominio'].'/pages/samples/lock-screen.php";</script>';  
      exit;
    }
    require_once '../../classes/conn.php';
    
    include("../../classes/functions.php");
    //conectar($_SESSION['cnpj_empresa']);

    $u = new Usuario;
    
    
?><!--Validar sessão aberta, se usuário está logado.-->



<!DOCTYPE html>
<html lang="pt-br">

<head>
  

  <!-- Required meta tags --> 
  <meta charset="utf-8">
  <meta>
  <!--<meta http-equiv='refresh' content='30'>-->
  <!--<meta http-equiv="refresh" content="5;url=../samples/lock-screen.php">-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <title>Dashboard</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">


  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/flag-icon-css/css/flag-icon.min.css"/>
  <link rel="stylesheet" href="../../vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars-o.css">
  <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars.css"> 
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="manifest" href="manifest.json">


  <style>
    #installBtn {
      display: none;
    }
  </style>

  <?php
  		$caminho_pasta_empresa = "../web/imagens/".isset($_SESSION['cnpj_empresa'])."//logos/";
		$foto_empresa = "LogoEmpresa.jpg"; // Nome do arquivo que será salvo
		$caminho_foto_empresa = $caminho_pasta_empresa . $foto_empresa;

		if (file_exists($caminho_foto_empresa)) {
			$tipo_foto_empresa = mime_content_type($caminho_foto_empresa);
  			echo "<link rel='icon' href='data:$tipo_foto_empresa;base64," . base64_encode(file_get_contents($caminho_foto_empresa)) . "' />";
		}else{
			echo "<link rel='icon' href='https://lh3.googleusercontent.com/pw/AP1GczOReqQClzL-PZkykfOwgmMyVzQgx27DTp783MI7iwKuKSv-6P6V7KOEbCC74sGdK3DEV3O88CsBLeIvOaQwGT3x4bqCTPRtyV9zcODbYVDRxAF8zf8Uev7geh4ONPdl3arNhnSDPvbQfMdpFRPM263V9A=w250-h250-s-no-gm?authuser=0' />";
		}
	?>

  <script>
    document.getElementById("c_body").style = '<?php echo $_SESSION['c_body'];?>';
    document.getElementById("c_card").style = '<?php echo $_SESSION['c_card'];?>';
  </script>
  


</head>
<script src="../../js/functions.js"></script>
  <!--<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">-->
  <body>
  <script src="../../js/gtag.js"></script>
  <div class="container-scroller">
  
    <!-- partial:partials/_navbar.html -->
    <?php include ("../../partials/_navbar.php");?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include ("../../partials/_sidebar.php");?>
      <!-- partial -->
      <div class="main-panel" >
        <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>


        <!--Instalando app PWA-->
        <button id="installBtn" class="btn btn-block btn-social-icon-text btn-success" style="margin: 5px;"><i class="mdi mdi-anchor"></i>... Instalar Aplicativo ...<i class="mdi mdi-anchor"></i></button>

        <script>
          let deferredPrompt;
          const installBtn = document.getElementById('installBtn');

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
    });

    // Verifica se o app já está instalado
    if (window.matchMedia('(display-mode: standalone)').matches) {
      installBtn.style.display = 'none';
    }
  </script>
  <!--Instalando app PWA-->
  <!--https://www.nobleui.com/html/template/demo2-dh/pages/icons/mdi-icons.html-->


  <!-- MODAL PLAYER -->
<div class="modal fade" id="playerModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <video style="width:100%;" id="video" controls autoplay></video>
      </div>
    </div>
  </div>
</div>

          <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
              
              <p><?php echo $_SESSION['c_body'];?></p>
              <p><?php echo $_SESSION['c_card'];?></p>
              <?php
                if($_SESSION['cd_empresa'] == ""){
                  echo "<h1>...</h1>";
                }else{
                  echo '<p class="font-weight-normal mb-2 text-muted">'.$_SESSION['cd_empresa'].' - '.strtoupper($_SESSION['nfantasia_empresa']).'</p>';
                  echo '<h6></h6>';
                }
              ?>

              <p class="font-weight-normal mb-2 text-muted"><span id="data-atual" <?php echo $_SESSION['c_body'];?>></span></p>
              <script>
                var data = new Date();
                var mesPorExtenso = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(data).toUpperCase();
                var dia = data.getDate();
                var ano = data.getFullYear();
                document.getElementById("data-atual").innerHTML = 'HOJE É '+dia + ' DE ' + mesPorExtenso + ', ' + ano;
              </script>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
          
            <div class="row flex-grow">

  <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
  <div class="container mt-4">
    <div class="row" id="card_cameras">
      <div class="col-12 text-center">Carregando câmeras…</div>
    </div>
  </div>

  <!-- MODAL COPIAR LINK RTMP -->
  <div class="modal fade" id="modalCamera" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Adicionar / Copiar Link RTMP</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
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
            <small class="form-text text-muted mt-2">
              Use essa URL no OBS ou câmera IP
            </small>
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
<?php
  echo '<h5 class="modal-title" id="modalTitle">'.$_SESSION['md_cameras_param'].'</h5>';
?>
  <script>
    /* ===============================
       CONFIGURAÇÃO
    =================================*/
    const API_BASE = "https://vps63583.publiccloud.com.br/api_camera.php";
    const RTMP_BASE = "rtmp://vps63583.publiccloud.com.br/live/";
    //let CAMERAS = ["BRECHOZINHO", "MARCENARIA_1", "MARCENARIA_2"];
    console.log("teste");
    //console.log("Cameras carregadas:"+ CAMERAS);

    <?php
$js_array = [];
$cameras_php = $u->conCams('empresa', $_SESSION['cd_empresa']); // Retorna array de cameras da empresa

$cameras_list = $cameras_php['list_cameras'] ?? [];

if ($cameras_list && is_array($cameras_list)) {
    foreach($cameras_list as $cam) {
        $js_array[] = "'" . addslashes($cam['chave_camera']) . "'";
    }
}
?>

let CAMERAS = [<?php echo implode(", ", $js_array); ?>];


    
    console.log("Cameras carregadas:", CAMERAS);

    //const MAX_CAMERAS = 1;//$_SESSION['md_cameras_param'];
    

    <?php
$max_cameras = isset($_SESSION['md_cameras_param']) 
    ? (int) $_SESSION['md_cameras_param'] 
    : 0; // 0 = ilimitado (opcional)
?>

const MAX_CAMERAS = <?= $max_cameras ?>;



    /* ===============================
       FUNÇÕES
    =================================*/
    function gerarChave(tamanho = 12) {
      const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      let chave = "";
      for (let i = 0; i < tamanho; i++) {
        chave += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      return chave;
    }


    function abrirModalAddCamera(chave = null) {
    // Se chave já existe, usa ela; se não, gera uma nova
    const rtmpChave = chave || gerarChave();
    document.getElementById("rtmpKey").value = RTMP_BASE + rtmpChave;
    $('#modalCamera').modal('show');
}



    function copiarRTMP() {
      const input = document.getElementById("rtmpKey");
      input.select();
      input.setSelectionRange(0, 99999);
      document.execCommand("copy");
      alert("RTMP copiado!");
    }

    function confirmarCamera() {
    // 1️⃣ Pega a chave do input e remove a base RTMP
    const rtmp = document.getElementById("rtmpKey").value;
    const chave = rtmp.replace(RTMP_BASE, "");

    // 2️⃣ Envia para o PHP via AJAX
    $.ajax({
        url: 'confirmar_camera.php',
        type: 'POST',
        data: { rtmp: chave }, // envia a chave para o PHP
        success: function(response) {
            // 3️⃣ Mostra a resposta do PHP dentro do modal
            $("#modalCamera .modal-body").prepend(
                `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    ${response}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>`
            );

            // 4️⃣ Atualiza a lista de câmeras se ainda não estiver nela
            if (!CAMERAS.includes(chave)) CAMERAS.push(chave);
            carregarCameras();

            // 5️⃣ Fecha o modal depois de 2 segundos
            setTimeout(() => { $('#modalCamera').modal('hide'); }, 2000);
        },
        error: function() {
            alert('Erro ao processar a requisição.');
        }
    });
}




    function carregarCameras() {
      const container = document.getElementById("card_cameras");
      if (!container) return;

      if (!CAMERAS || CAMERAS.length === 0) {
        container.innerHTML = `
          <div class="col-12 text-center">
            <p class="mb-3">Nenhuma câmera cadastrada</p>
            <button class="btn btn-primary" onclick="abrirModalAddCamera()">
              + Adicionar nova câmera
            </button>
          </div>`;
        return;
      }

      let html = "";

      Promise.all(
        CAMERAS.map(cam =>
          fetch(`${API_BASE}?chave=${encodeURIComponent(cam)}`)
            .then(r => r.ok ? r.json() : Promise.reject())
            .then(d => ({ cam, d }))
            .catch(() => ({
              cam,
              d: { status: "inexistente", imagem: "", video: "" }
            }))
        )
      ).then(resultados => {

        resultados.forEach(({ cam, d }) => {
          if (d.status === "inexistente") {
    // Card para copiar link
    html += `
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
        <div class="card h-100 border border-primary d-flex align-items-center justify-content-center"
             style="cursor:pointer"
             onclick="abrirModalAddCamera('${cam}')"> <!-- Passa a chave existente -->
            <div class="text-primary text-center">
                <h1>+</h1>
                <div>Adicionar / Copiar link</div>
            </div>
        </div>
    </div>`;
}
 else {
            const statusClass = d.status === "ONLINE" ? "text-success" : "text-danger";
            const snapshot = d.imagem ? d.imagem + "?t=" + Date.now() : "https://via.placeholder.com/400x200";

            html += `
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card h-100" style="cursor:pointer"
                     onclick="abrirPlayer('${cam}', '${d.video || ""}', '${d.status}')">
                  <img class="card-img-top"
                       src="${snapshot}"
                       onerror="this.src='https://via.placeholder.com/400x200?text=SEM+IMAGEM'">
                  <div class="card-body text-center">
                    <strong>${cam}</strong>
                    <div class="${statusClass}">${d.status}</div>
                  </div>
                </div>
              </div>`;
          }
        });

        // Botão geral para adicionar nova câmera se ainda não atingiu limite
        if (CAMERAS.length < MAX_CAMERAS) {
          html += `
            <div class="col-12 text-center mt-3">
              <button class="btn btn-outline-primary" onclick="abrirModalAddCamera()">
                ➕ Adicionar nova câmera
              </button>
            </div>`;
        }

        container.innerHTML = html;
      });
    }

    let hls;
    function abrirPlayer(nome, url, status) {
      console.log('nome('+nome+') - url('+url+') - status('+status+')');
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

      $('#playerModal').modal('show'); // Bootstrap 4.6
    }

    /* ===============================
       LOOP
    =================================*/
    carregarCameras();
    setInterval(carregarCameras, 5000);

  </script>
</div>


          </div>
            </div>

          </div>


        <?php
          include("../../partials/_footer.php");
        ?>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!--<footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © sistma.com 2023</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://localhost/_1_1_sistema" target="_blank">Sistema.com</a> from 1.1</span>
          </div>
          <span class="text-muted d-block text-center text-sm-left d-sm-inline-block mt-2">Distributed By: <a href="https://www.themewagon.com/" target="_blank">ThemeWagon</a></span>
        </footer>-->
        
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="../../vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

