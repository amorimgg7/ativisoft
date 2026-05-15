<?php 
    session_start();  
    if(!isset($_SESSION['cd_pessoa']))
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
  <title>Dispositivo</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">

  
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
            <div class="col-12 grid-margin">
              <div class="card">
                

                <?php
                  if(isset($_POST['limparOS'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    session_start();
                    $_SESSION['cd_cliente'] = 0;
                    $_SESSION['cd_dispositivo'] = 0;
                    $_SESSION['vtotal_casa'] = 0;
                    $_SESSION['vpag_total'] = 0;
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                  }
                  if(isset($_POST['GravarDispositivo'])){

                    $edit_dispositivo = "UPDATE tb_dispositivo SET
                      titulo_dispositivo = '".$_POST['btntitulo_dispositivo']."',
                      local_dispositivo = '".$_POST['btnlocal_dispositivo']."'
                      WHERE cd_dispositivo = '".$_POST['btncd_dispositivo']."'";
                    if(mysqli_query($conn, $edit_dispositivo)){
                      //echo "<script>window.alert('Dispositivo editado!');</script>";
                    }
                  }
                ?>
                
                <?php
                  if(isset($_POST['concd_dispositivo']) ){
                    $_SESSION['cd_dispositivo'] = $_POST['concd_dispositivo'];
                    $_SESSION['dispositivo'] = $_POST['concd_dispositivo'];
                  }

                  if(isset($_SESSION['dispositivo']) ){
                    $select_dispositivo = "SELECT * FROM tb_dispositivo WHERE cd_dispositivo = '".$_SESSION['dispositivo']."'";
                    $result_dispositivo = mysqli_query($conn, $select_dispositivo);
                    $row_dispositivo = mysqli_fetch_assoc($result_dispositivo);
                    // Exibe as informações do usuário no formulário
                    if($row_dispositivo) {
                      $_SESSION['dispositivo'] = $row_dispositivo['cd_dispositivo'];
                      $_SESSION['cd_dispositivo'] = $row_dispositivo['cd_dispositivo'];
                      $_SESSION['cd_casa_dispositivo'] = $row_dispositivo['cd_casa_dispositivo'];
                      $_SESSION['mac_dispositivo'] = $row_dispositivo['mac_dispositivo'];
                      $_SESSION['ip_dispositivo'] = $row_dispositivo['ip_dispositivo'];
                      $_SESSION['mascara_dispositivo'] = $row_dispositivo['mascara_dispositivo'];
                      $_SESSION['gateway_dispositivo'] = $row_dispositivo['gateway_dispositivo'];
                      $_SESSION['marca_dispositivo'] = $row_dispositivo['marca_dispositivo'];
                      $_SESSION['modelo_dispositivo'] = $row_dispositivo['modelo_dispositivo'];
                      $_SESSION['versao_dispositivo'] = $row_dispositivo['versao_dispositivo'];
                      $_SESSION['titulo_dispositivo'] = $row_dispositivo['titulo_dispositivo'];
                      $_SESSION['local_dispositivo'] = $row_dispositivo['local_dispositivo'];
                      $_SESSION['status_dispositivo'] = $row_dispositivo['status_dispositivo'];
                      $_SESSION['canal_1'] = $row_dispositivo['canal_1'];
                      $_SESSION['canal_2'] = $row_dispositivo['canal_2'];
                      $_SESSION['canal_3'] = $row_dispositivo['canal_3'];
                      $_SESSION['canal_4'] = $row_dispositivo['canal_4'];
                      $_SESSION['canal_5'] = $row_dispositivo['canal_5'];
                      $_SESSION['canal_6'] = $row_dispositivo['canal_6'];
                      $_SESSION['canal_7'] = $row_dispositivo['canal_7'];
                      $_SESSION['canal_8'] = $row_dispositivo['canal_8'];
                      
                    }

                  }

                  




                
                

                  //desfazer_rezerva

                  
                ?>
                
                <?php
                  if($_SESSION['cd_dispositivo'] > 0){
                    $_SESSION['dispositivo'] = $_SESSION['cd_dispositivo'];

                    echo '<div class="card-body" >';
                    echo '<div class="kt-portlet__body">';
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-12">';
                    echo '<div class="nc-form-tac">';
                    //echo '<form method="POST" id="alter_dispositivo" name="alter_dispositivo">';
                    echo '<div class="typeahead" style="display: block;">';
                    
                    echo '<p>Informações não alteráveis<br>CD: '.$_SESSION['cd_dispositivo'].'<br>MAC: '.$_SESSION['mac_dispositivo'].'<br>IP: '.$_SESSION['ip_dispositivo'].'<br>Mascara: '.$_SESSION['mascara_dispositivo'].'<br>GW: '.$_SESSION['gateway_dispositivo'].'<br>Marca: '.$_SESSION['marca_dispositivo'].'<br>Modelo: '.$_SESSION['modelo_dispositivo'].'<br>Versão: '.$_SESSION['versao_dispositivo'].'</p>';
                    echo '<form method="post">';
                    //echo '<label for="btncd_dispositivo">Código do Dispositivo</label>';
                    echo '<input style="display:none;" value="'.$_SESSION['cd_dispositivo'].'" type="tel" name="btncd_dispositivo" id="btncd_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btntitulo_dispositivo">Título do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['titulo_dispositivo'].'" type="text" name="btntitulo_dispositivo" id="btntitulo_dispositivo" class="form-control form-control-sm">';

                    echo '<label for="btnlocal_dispositivo">Local do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['local_dispositivo'].'" type="text" name="btnlocal_dispositivo" id="btnlocal_dispositivo" class="form-control form-control-sm">';

                    //echo '<label for="btnstatus_dispositivo">Status do Dispositivo</label>';
                    //echo '<input value="'.$_SESSION['status_dispositivo'].'" type="text" name="btnstatus_dispositivo" id="btnstatus_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<a style="margin:10px; height: 50px;" href="'.$_SESSION['dominio'].'/pages/dashboard/index.php" class="btn col-12 col-md-5 btn-outline-warning">Voltar ao início</a>';

                    echo '<input style="margin:10px; height: 50px;" id="GravarDispositivo" name="GravarDispositivo" type="submit" class="btn col-12 col-md-5 btn-outline-success" value="Gravar">';
                    echo '</form>';
                    if($_SESSION['modelo_dispositivo'] == "Higrometro_1_0" ){

                    }
    
                    //echo '<td><a href="'.$_SESSION['dominio'].'/pages/md_hospedagem/editar_casa.php" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Voltar para Imóvel</a></td>';
                    //echo '</form>';
                    echo '</div>';
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                  }
                ?>
                
                

                

              </div>
            </div>
          </div>
      
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php
          //include("../../partials/_footer.php");
        ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="../../vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/file-upload.js"></script>
  <script src="../../js/typeahead.js"></script>
  <script src="../../js/select2.js"></script>
  <!-- End custom js for this page-->
</body>

</html>