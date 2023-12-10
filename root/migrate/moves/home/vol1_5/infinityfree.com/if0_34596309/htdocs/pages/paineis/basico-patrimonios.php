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
  <title>Geral Patrimonios</title>
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

<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">
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
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              $sql_tipo = "SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'DP' GROUP BY marca_patrimonio, modelo_patrimonio"; 
              $resulta = $conn->query($sql_tipo);
              if ($resulta->num_rows > 0){
                echo '<div class="col-lg-6 grid-margin stretch-card">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title">Desktop</h4>';
                
                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Marca</th>';
                echo '<th>Modelo</th>';
                echo '<th>Quantidade</th>';
                echo '<th>Em uso</th>';
                echo '<th>Fora de uso</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ( $row = $resulta->fetch_assoc()){
                  echo '<tr>';
                  echo '<td>'.$row['marca_patrimonio'].'</td>';
                  echo '<td>'.$row['modelo_patrimonio'].'</td>';
                  echo '<td><label class="badge badge-success">'.$row['total'].'</label></td>';

                  // Contagem de equipamentos em uso
                  $sql_qtd_uso = "SELECT COUNT(*) AS total_uso FROM tb_patrimonio WHERE tipo_patrimonio = 'DP' AND status_patrimonio = '1' AND marca_patrimonio = '".$row['marca_patrimonio']."' AND modelo_patrimonio = '".$row['modelo_patrimonio']."'"; 
                  $resulta_uso = $conn->query($sql_qtd_uso);
                  $row_uso = $resulta_uso->fetch_assoc();
                  $qtd_uso = $row_uso['total_uso'];
                  echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';

                  // Contagem de equipamentos fora de uso
                  $qtd_fora_de_uso = $row['total'] - $qtd_uso;
                  echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';

                  //echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';
                  //echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
              }
            ?>


            <?php
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              $sql_tipo = "SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'NK' GROUP BY marca_patrimonio, modelo_patrimonio"; 
              $resulta = $conn->query($sql_tipo);
              if ($resulta->num_rows > 0){
                echo '<div class="col-lg-6 grid-margin stretch-card">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title">Notebook</h4>';
                
                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Marca</th>';
                echo '<th>Modelo</th>';
                echo '<th>Quantidade</th>';
                echo '<th>Em uso</th>';
                echo '<th>Fora de uso</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ( $row = $resulta->fetch_assoc()){
                  echo '<tr>';
                  echo '<td>'.$row['marca_patrimonio'].'</td>';
                  echo '<td>'.$row['modelo_patrimonio'].'</td>';
                  echo '<td><label class="badge badge-success">'.$row['total'].'</label></td>';

                  // Contagem de equipamentos em uso
                  $sql_qtd_uso = "SELECT COUNT(*) AS total_uso FROM tb_patrimonio WHERE tipo_patrimonio = 'NK' AND status_patrimonio = '1' AND marca_patrimonio = '".$row['marca_patrimonio']."' AND modelo_patrimonio = '".$row['modelo_patrimonio']."'"; 
                  $resulta_uso = $conn->query($sql_qtd_uso);
                  $row_uso = $resulta_uso->fetch_assoc();
                  $qtd_uso = $row_uso['total_uso'];
                  echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';

                  // Contagem de equipamentos fora de uso
                  $qtd_fora_de_uso = $row['total'] - $qtd_uso;
                  echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';

                  //echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';
                  //echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
              }
            ?>

            <?php
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              $sql_tipo = "SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'MR' GROUP BY marca_patrimonio, modelo_patrimonio"; 
              $resulta = $conn->query($sql_tipo);
              if ($resulta->num_rows > 0){
                echo '<div class="col-lg-6 grid-margin stretch-card">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title">Monitor</h4>';
                
                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Marca</th>';
                echo '<th>Modelo</th>';
                echo '<th>Quantidade</th>';
                echo '<th>Em uso</th>';
                echo '<th>Fora de uso</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ( $row = $resulta->fetch_assoc()){
                  echo '<tr>';
                  echo '<td>'.$row['marca_patrimonio'].'</td>';
                  echo '<td>'.$row['modelo_patrimonio'].'</td>';
                  echo '<td><label class="badge badge-success">'.$row['total'].'</label></td>';

                  // Contagem de equipamentos em uso
                  $sql_qtd_uso = "SELECT COUNT(*) AS total_uso FROM tb_patrimonio WHERE tipo_patrimonio = 'MR' AND status_patrimonio = '1' AND marca_patrimonio = '".$row['marca_patrimonio']."' AND modelo_patrimonio = '".$row['modelo_patrimonio']."'"; 
                  $resulta_uso = $conn->query($sql_qtd_uso);
                  $row_uso = $resulta_uso->fetch_assoc();
                  $qtd_uso = $row_uso['total_uso'];
                  echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';

                  // Contagem de equipamentos fora de uso
                  $qtd_fora_de_uso = $row['total'] - $qtd_uso;
                  echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';

                  //echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';
                  //echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
              }
            ?>

            <?php
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              $sql_tipo = "SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'IA' GROUP BY marca_patrimonio, modelo_patrimonio"; 
              $resulta = $conn->query($sql_tipo);
              if ($resulta->num_rows > 0){
                echo '<div class="col-lg-6 grid-margin stretch-card">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title">Impressora</h4>';
                
                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Marca</th>';
                echo '<th>Modelo</th>';
                echo '<th>Quantidade</th>';
                echo '<th>Em uso</th>';
                echo '<th>Fora de uso</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ( $row = $resulta->fetch_assoc()){
                  echo '<tr>';
                  echo '<td>'.$row['marca_patrimonio'].'</td>';
                  echo '<td>'.$row['modelo_patrimonio'].'</td>';
                  echo '<td><label class="badge badge-success">'.$row['total'].'</label></td>';

                  // Contagem de equipamentos em uso
                  $sql_qtd_uso = "SELECT COUNT(*) AS total_uso FROM tb_patrimonio WHERE tipo_patrimonio = 'IA' AND status_patrimonio = '1' AND marca_patrimonio = '".$row['marca_patrimonio']."' AND modelo_patrimonio = '".$row['modelo_patrimonio']."'"; 
                  $resulta_uso = $conn->query($sql_qtd_uso);
                  $row_uso = $resulta_uso->fetch_assoc();
                  $qtd_uso = $row_uso['total_uso'];
                  echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';

                  // Contagem de equipamentos fora de uso
                  $qtd_fora_de_uso = $row['total'] - $qtd_uso;
                  echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';

                  //echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';
                  //echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';  
              }
            ?>

            <?php
              //"SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'Impressora' GROUP BY marca_patrimonio, modelo_patrimonio";
              $sql_tipo = "SELECT marca_patrimonio, modelo_patrimonio, COUNT(*) AS total FROM tb_patrimonio WHERE tipo_patrimonio = 'SE' GROUP BY marca_patrimonio, modelo_patrimonio"; 
              $resulta = $conn->query($sql_tipo);
              if ($resulta->num_rows > 0){
                echo '<div class="col-lg-6 grid-margin stretch-card">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title">Smartphone</h4>';
                
                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Marca</th>';
                echo '<th>Modelo</th>';
                echo '<th>Quantidade</th>';
                echo '<th>Em uso</th>';
                echo '<th>Fora de uso</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ( $row = $resulta->fetch_assoc()){
                  echo '<tr>';
                  echo '<td>'.$row['marca_patrimonio'].'</td>';
                  echo '<td>'.$row['modelo_patrimonio'].'</td>';
                  echo '<td><label class="badge badge-success">'.$row['total'].'</label></td>';

                  // Contagem de equipamentos em uso
                  $sql_qtd_uso = "SELECT COUNT(*) AS total_uso FROM tb_patrimonio WHERE tipo_patrimonio = 'SE' AND status_patrimonio = '1' AND marca_patrimonio = '".$row['marca_patrimonio']."' AND modelo_patrimonio = '".$row['modelo_patrimonio']."'"; 
                  $resulta_uso = $conn->query($sql_qtd_uso);
                  $row_uso = $resulta_uso->fetch_assoc();
                  $qtd_uso = $row_uso['total_uso'];
                  echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';

                  // Contagem de equipamentos fora de uso
                  $qtd_fora_de_uso = $row['total'] - $qtd_uso;
                  echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';

                  //echo '<td><label class="badge badge-info">'.$qtd_uso.'</label></td>';
                  //echo '<td><label class="badge badge-warning">'.$qtd_fora_de_uso.'</label></td>';
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
