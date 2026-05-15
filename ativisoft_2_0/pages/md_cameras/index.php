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
                
                <?php
                  //echo '<h1>'.$_SESSION['cd_acesso'].'</h1>';
                  include '../../pages/cad_acesso/index.php';

                  if($_SESSION['cd_acesso'] == 0)
                  {
                    /*
                    if($_SESSION['cd_empresa'] == ""){
                      echo '<div class="container text-center mt-5">';
                      echo '  <h1 class="mb-3">Vamos começar!</h1>';
                      echo '  <h4 class="mb-4">Conte um pouco sobre o seu negócio para que possamos te ajudar melhor.</h4>';
                      echo '  <form method="post" action="../cad_geral/unidade_operacional.php">';
                      echo '    <input class="btn btn-info btn-lg font-weight-medium" type="submit" value="Começar agora">';
                      echo '  </form>';
                      echo '</div>';
                    }else{
                      include '../../pages/cad_acesso/index.php';
                    }
                    */
                    
                    

                  }else 
                  if($_SESSION['cd_funcao'] == 1)
                  {
                    if($_SESSION['cd_empresa'] == ""){
                      echo '<div class="container text-center mt-5">';
                      echo '  <h1 class="mb-3">Vamos começar!</h1>';
                      echo '  <h4 class="mb-4">Conte um pouco sobre o seu negócio para que possamos te ajudar melhor.</h4>';
                      echo '  <form method="post" action="../cad_geral/unidade_operacional.php">';
                      echo '    <input class="btn btn-info btn-lg font-weight-medium" type="submit" value="Começar agora">';
                      echo '  </form>';
                      echo '</div>';
                    }else{
                      ////include '../../pages/auto_pagamento/index.php';
                      include '../../pages/md_caixa/index.php';
                      ////include '../../pages/md_vendas/index.php';

                      //include '../../pages/md_patrimonio/index.php';
                      //include '../../pages/md_caixa/index.php';
                      include '../../pages/md_assistencia/index.php';
                    }
                    
                    
                    

                  }else 
                  if($_SESSION['cd_funcao'] == 2)
                  {
                    //echo '<h1>Licença Essencial!</h1>';
                    
                    //echo '<h6>&nbsp&nbsp&nbsp&nbsp Aqui voce verá funcionalidades essenciais para o seu negócio.</h6>';

                    //include '../../pages/auto_pagamento/index.php';
                    include '../../pages/md_caixa/index.php';
                    //include '../../pages/md_vendas/index.php';
                    include '../../pages/md_assistencia/index.php';


                    if ($_POST['pagar_cd_comissao'] > 0) {
                      // Construir a mensagem com os itens separados por quebra de linha
                      $mensagem = "O item selecionado retornará ao estoque?";
  
                      // Gerar o modal via PHP
                      echo '
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Confirmação</h5>
                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>-->
                        </div>
                        <div class="modal-body">
                        <p>' . htmlspecialchars($mensagem, ENT_QUOTES) . '</p>
                        </div>
                        <div class="modal-footer">
                        <form method="POST" action="">
                      ';
  
                      // Preservar os dados do POST no modal
                      foreach ($_POST as $key => $value) {
                        if (is_array($value)) {
                          foreach ($value as $subValue) {
                            echo '<input type="hidden" name="' . htmlspecialchars($key, ENT_QUOTES) . '[]" value="' . htmlspecialchars($subValue, ENT_QUOTES) . '">';
                          }
                        } else {
                          echo '<input type="hidden" name="' . htmlspecialchars($key, ENT_QUOTES) . '" value="' . htmlspecialchars($value, ENT_QUOTES) . '">';
                        }
                      }

                      echo '
                      <button type="submit" name="confirmacao" value="sim" class="btn btn-success">Sim</button>
                      <button type="submit" name="confirmacao" value="nao" class="btn btn-danger">Não</button>
                      <button type="submit" name="confirmacao" value="cancelar" class="btn btn-secondary">Cancelar</button>
                      </form>
                      </div>
                      </div>
                      </div>
                      </div>
                      <script>
                      $(document).ready(function() {
                      $("#exampleModalCenter").modal("show");
                      });
                      </script>';
                  }

                  if (isset($_POST['confirmacao'])) {
                    if ($_POST['confirmacao'] === 'sim') {
                      $updateEstoque = "
                          UPDATE `tb_prod_serv` 
                          INNER JOIN `tb_orcamento_servico` 
                          ON `tb_prod_serv`.`cd_prod_serv` = `tb_orcamento_servico`.`cd_produto` 
                          SET `tb_prod_serv`.`estoque_prod_serv` = `tb_prod_serv`.`estoque_prod_serv` + `tb_orcamento_servico`.`qtd_orcamento` 
                          WHERE `tb_orcamento_servico`.`cd_orcamento` = " . intval($_POST['listaid_orcamento']);

                      if(mysqli_query($conn, $updateEstoque)){
                        echo '<script>alert("1");</script>';
                      
                      }
                    
                      $removeReserva = "DELETE FROM `tb_reserva` WHERE `cd_orcamento` = " . intval($_POST['listaid_orcamento']);

                      if(mysqli_query($conn, $removeReserva)){
                        echo '<script>alert("2");</script>';
                      
                      }
                      $removeOrcamentoServico = "DELETE FROM `tb_orcamento_servico` WHERE `cd_orcamento` = " . intval($_POST['listaid_orcamento']);
                      if (mysqli_query($conn, $removeOrcamentoServico)) {
                        // Atualizar o estoque



                          echo '<script>alert("Reserva removida e estoque atualizado com sucesso!");</script>';
                          echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_assistencia/cadastro_servico.php";</script>';          


                      
                      } else {
                          echo '<script>alert("Erro ao remover a reserva: ' . mysqli_error($conn) . '");</script>';
                      }
                    
                    } elseif ($_POST['confirmacao'] === 'nao') {
                        echo '<script>alert("Não retornou ao estoque!");</script>';
                        // Lógica para confirmação "Não"
                    } elseif ($_POST['confirmacao'] === 'cancelar') {
                        echo '<script>alert("Operação cancelada pelo usuário.");</script>';
                        // Lógica para "Cancelar"
                    }
                  }

                    include '../../pages/md_comissao/index.php';
                  }
                  if($_SESSION['cd_funcao'] == 3)
                  {
                    echo '<h1>Módulo fornecedor!</h1>';
                    echo '<h6>Módulo destinado para fornecedores de peças e equipamentos exclusivamente para empresários e técnicos cadastrados neste sistema e a futura loja virtual</h6>';

                  }
                  if($_SESSION['cd_funcao'] == 4)
                  {
                    //include '../../pages/auto_pagamento/index.php';
                    include '../../pages/md_caixa/index.php';
                    //include '../../pages/md_vendas/index.php';
                    include '../../pages/md_assistencia/index.php';


                    if ($_POST['pagar_cd_comissao'] > 0) {
                      // Construir a mensagem com os itens separados por quebra de linha
                      $mensagem = "O item selecionado retornará ao estoque?";
  
                      // Gerar o modal via PHP
                      echo '
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Confirmação</h5>
                        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>-->
                        </div>
                        <div class="modal-body">
                        <p>' . htmlspecialchars($mensagem, ENT_QUOTES) . '</p>
                        </div>
                        <div class="modal-footer">
                        <form method="POST" action="">
                      ';
  
                      // Preservar os dados do POST no modal
                      foreach ($_POST as $key => $value) {
                        if (is_array($value)) {
                          foreach ($value as $subValue) {
                            echo '<input type="hidden" name="' . htmlspecialchars($key, ENT_QUOTES) . '[]" value="' . htmlspecialchars($subValue, ENT_QUOTES) . '">';
                          }
                        } else {
                          echo '<input type="hidden" name="' . htmlspecialchars($key, ENT_QUOTES) . '" value="' . htmlspecialchars($value, ENT_QUOTES) . '">';
                        }
                      }

                      echo '
                      <button type="submit" name="confirmacao" value="sim" class="btn btn-success">Sim</button>
                      <button type="submit" name="confirmacao" value="nao" class="btn btn-danger">Não</button>
                      <button type="submit" name="confirmacao" value="cancelar" class="btn btn-secondary">Cancelar</button>
                      </form>
                      </div>
                      </div>
                      </div>
                      </div>
                      <script>
                      $(document).ready(function() {
                      $("#exampleModalCenter").modal("show");
                      });
                      </script>';
                  }
                  }
                  if($_SESSION['cd_funcao'] == 5)
                  {
                    echo '<h1>Módulo Assistente!</h1>';
                    echo '<h6>&nbsp&nbsp&nbsp&nbsp Licença ao módulo de assistencia.</h6>';

                    ////include '../../pages/auto_pagamento/index.php';
                    ////include '../../pages/md_caixa/index.php';
                    ////include '../../pages/md_vendas/index.php';
                    ////include '../../pages/md_assistencia/index.php';
                  }
                  if($_SESSION['cd_funcao'] == 6)
                  {
                    //include '../../pages/auto_pagamento/index.php';
                    
                    include '../../pages/md_caixa/index.php';
                    //include '../../pages/md_vendas/index.php';
                    include '../../pages/md_lanchonete/index.php';
                  }
                  if($_SESSION['cd_funcao'] == 7)
                  {
                    echo '<h1>Escritório Simples!</h1>';
                    //echo '<h6>&nbsp&nbsp&nbsp&nbsp Licença ao módulo de controle de casas voltado a pessoas que alugam casas e espaços.</h6>';
                    include '../../pages/md_caixa/index.php';
                    ////include '../../pages/md_hospedagem/index.php';
                    //include '../../pages/md_patrimonio/index.php';
                  }
                  if($_SESSION['cd_funcao'] == 8)
                  {
                    echo '<h1>Escritório Avançado!</h1>';
                    //echo '<h6>&nbsp&nbsp&nbsp&nbsp Licença ao módulo de controle de casas voltado a pessoas que alugam casas e espaços.</h6>';
                    ////include '../../pages/md_caixa/index.php';
                    ////include '../../pages/md_hospedagem/index.php';
                    //include '../../pages/md_patrimonio/index.php';
                  }else{
                    echo '<h1>'.$_SESSION['titulo_acesso'].'</h1>';
                    //echo '<pre id="jsonAcesso">'.json_encode($_SESSION['acesso_geral'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).'</pre>';

                    $data = $_SESSION['acesso_geral'] ?? null;

                    // JSON_PRETTY_PRINT e JSON_UNESCAPED_UNICODE continuam funcionando normalmente no 8.3
                    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    if ($json === false) {
                      echo '<pre id="jsonAcesso">Erro ao gerar JSON: ' . json_last_error_msg() . '</pre>';
                    } else {
                      echo '<pre id="jsonAcesso">' . $json . '</pre>';
                    }

                    //echo '<h6>&nbsp&nbsp&nbsp&nbsp Licença ao módulo de controle de casas voltado a pessoas que alugam casas e espaços.</h6>';
                    //include '../../pages/md_caixa/index.php';
                    ////include '../../pages/md_hospedagem/index.php';
                    //include '../../pages/md_patrimonio/index.php';
                  }

                ?>
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

