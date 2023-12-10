<?php 
    session_start(); 
    if(!isset($_SESSION['cd_pessoal']))
    {
        header("location: ../../pages/samples/login.php");
        exit;
    }
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    $u = new Usuario;
?><!--Validar sessão aberta, se usuário está logado.-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Geral Empresas</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include ("../../partials/_navbar.php");?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include ("../../partials/_sidebar.php");?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <?php
              $sql_tipo = "SELECT * FROM tb_empresa"; 
              $resulta = $conn->query($sql_tipo);
              if ($resulta->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title mb-3">Empresas cadastradas</h4>';
                echo '<p class="card-description">Abaixo as  empresas que foram cadastraras no sistema</p>';
                echo '<div class="table-responsive pt-3">';
                echo '<table class="table table-bordered">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>RSOCIAL</th>';
                echo '<th>CNPJ</th>';
                echo '<th>RANKING</th>';
                echo '<th>PATRIMONIO</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                
                while ( $row = $resulta->fetch_assoc()){
                  echo '<tr>';
                  //echo '<td>'.$row['id_empresa'].'</td>';

                  echo '<td><form action=""><input type="submit" name="cd_empresa'.$row['cd_empresa'].'" value="<'.$row['cd_empresa'].'>"></form></td>';
                        if (!isset($_SESSION['cd_empresa'])) {
                            $_SESSION['cd_empresa'] = 0;
                        }
                              
                        if (isset($_GET['cd_empresa'.$row['cd_empresa'].''])) {
                            $_SESSION['cd_empresa'] = $row['cd_empresa'];
                            echo '<script>location.href="../../index.php";</script>';
                        }

                  echo '<td>'.$row['nfantasia_empresa'].'</td>';
                  echo '<td>'.$row['cnpj_empresa'].'</td>';
                  echo '<td>';
                  echo '<div class="progress">';
                  echo '<div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
                  echo '</div>';
                  echo '</td>';
                  echo '<td>';
                  echo 'R$:0.00';
                  echo '</td>';
                  echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';                
              }
            ?>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard templates</a> from Bootstrapdash.com</span>
          </div>
        </footer>
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
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>
