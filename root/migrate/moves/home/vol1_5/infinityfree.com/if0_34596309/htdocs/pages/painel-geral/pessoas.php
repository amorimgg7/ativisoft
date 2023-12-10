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
  <title>Geral Pessoal</title>
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
              $sql_tipo = "SELECT * FROM tb_pessoal"; 
              $resulta = $conn->query($sql_tipo);
              if ($resulta->num_rows > 0){
                echo '<div class="col-lg-12 grid-margin stretch-card">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title">Funcionários cadastrados</h4>';
                echo '<p class="card-description">Abaixo os funcionários Rankeados</p>';
                echo '<div class="table-responsive">';
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Foto</th>';
                echo '<th>Nome</th>';
                echo '<th>Ranking</th>';
                echo '<th>Responsabilidade patrimonial</th>';
                echo '<th>Conosco desde</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ( $row = $resulta->fetch_assoc()){
                  echo '<tr>';
                  echo '<td class="py-1">';
                  echo '<img src="'.$row['foto_pessoal'].'"/>';
                  echo '</td>';
                  echo '<td>'.$row['pnome_pessoal'].' '.$row['snome_pessoal'].'</td>';
                  echo '<td>';
                  echo '<div class="progress">';
                  echo '<div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>';
                  echo '</div>';
                  echo '</td>';
                  echo '<td>';
                  echo 'R$: 77.99';
                  echo '</td>';
                  echo '<td>';
                  echo 'May 15, 2015';
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
