<?php
    session_start();

    
    if(!isset($_SESSION['cd_colab']))
    {
        //header("location: http://amorimgg77.lovestoblog.com/pages/samples/login.php");
        echo '<script>location.href="'.$_SESSION['dominio'].'../samples/login.php";</script>';    
        exit; 
    }
    if($_SESSION['senha_colab'] == "")
    {
      //header("location: http://amorimgg77.lovestoblog.com/pages/samples/lock-screen.php");
      echo '<script>location.href="'.$_SESSION['dominio'].'../../samples/lock-screen.php";</script>';  
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
  <meta http-equiv='refresh' content='30'>
  <!--<meta http-equiv="refresh" content="5;url=../samples/lock-screen.php">-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
  <title>AtiviSoft</title>
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
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
  <script>
                document.getElementById("c_body").style = '<?php echo $_SESSION['c_body'];?>';
                document.getElementById("c_card").style = '<?php echo $_SESSION['c_card'];?>';
              </script>
  

</head>
<script src="../../js/functions.js"></script>
<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">
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
          <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
              
              <p><?php echo $_SESSION['c_body'];?></p>
              <p><?php echo $_SESSION['c_card'];?></p>
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
                  if($_SESSION['cd_funcao'] == 1)
                  {
                    
                    include '../../pages/auto_pagamento/index.php';
                    //include '../../pages/md_caixa/index.php';

                    //include '../../pages/md_patrimonio/index.php';
                    //include '../../pages/md_caixa/index.php';
                    //include '../../pages/md_assistencia/index.php';

                  }
                  if($_SESSION['cd_funcao'] == 2)
                  {
                    echo '<h1>Módulo cliente!</h1>';
                    echo '<h6>Destinado ao usuário que tem uma empresa, irá cadastrar patrimonio e funcionários e também movimentar responsabilidade sob patrimonio cadastrado. </h6>';
                    include '../../pages/md_cliente/index.php';

                  }
                  if($_SESSION['cd_funcao'] == 3)
                  {
                    echo '<h1>Módulo fornecedor!</h1>';
                    echo '<h6>Módulo destinado para fornecedores de peças e equipamentos exclusivamente para empresários e técnicos cadastrados neste sistema e a futura loja virtual</h6>';

                  }
                  if($_SESSION['cd_funcao'] == 4)
                  {
                    echo '<h1>Módulo cliente / fornecedor!</h1>';
                    echo '<h6>Este módulo é destinado ao empresário que deseja utilizar funções de cliente e fornecedor juntas</h6>';

                  }
                  if($_SESSION['cd_funcao'] == 5)
                  {
                    //echo '<h1>Módulo Assistente!</h1>';
                    //echo '<h6>&nbsp&nbsp&nbsp&nbsp Licença ao módulo de assistencia.</h6>';

                    include '../../pages/auto_pagamento/index.php';
                    include '../../pages/md_caixa/index.php';
                    include '../../pages/md_assistencia/index.php';
                  }
                  if($_SESSION['cd_funcao'] == 6)
                  {
                    echo '<h1>Módulo Patrimônio!</h1>';
                    echo '<h6>&nbsp&nbsp&nbsp&nbsp Licença ao módulo de controle patrimônial.</h6>';
                    //include '../../pages/md_patrimonio/index.php';
                  }
                ?>
              </div>
            </div>
          </div>

        </div>

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

