<?php
  session_start();
  if(!isset($_SESSION['cd_pessoa']))
  {
    echo '<script>location.href="'.$_SESSION['dominio'].'../samples/login.php";</script>';    
    exit; 
  }
  if($_SESSION['senha_pessoa'] == "")
  {
    echo '<script>location.href="'.$_SESSION['dominio'].'../../samples/lock-screen.php";</script>';  
    exit;
  }
  require_once '../../classes/conn.php';
  include("../../classes/functions.php");
  $u = new Usuario;  
  
  


  


?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AtiviHouse</title>
    <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/feather/feather.css">
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../vendors/flag-icon-css/css/flag-icon.min.css"/>
    <link rel="stylesheet" href="../../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars-o.css">
    <link rel="stylesheet" href="../../vendors/jquery-bar-rating/fontawesome-stars.css">
    <link rel="stylesheet" href="../../css/style.css">
  </head>
  <script src="../../js/functions.js"></script>
  <body>
  <div class="container-scroller">
    <?php include ("../../partials/_navbar.php");?>
    <div>
      <?php include ("../../partials/_sidebar.php");?>
      <div>
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
              <p class="font-weight-normal mb-2 text-muted"><span id="data-atual"></span></p>
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
                <?php
                  include '../../pages/md_casa/index.php';
                ?>
            </div>
          </div>
        </div>
        <?php
          include("../../partials/_footer.php");
        ?>
      </div>
    </div>
  </div>
  <script src="../../vendors/base/vendor.bundle.base.js"></script>
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
  <script src="../../js/dashboard.js"></script>
</body>

</html>

