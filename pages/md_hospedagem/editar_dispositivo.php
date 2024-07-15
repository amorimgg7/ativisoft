<?php 
    session_start();  
    if(!isset($_SESSION['cd_colab']))
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
  <?php 
    if(isset($_SESSION['bloqueado'])){
      
      if($_SESSION['bloqueado'] == 1){
        echo "<meta http-equiv='refresh' content='60;url=../auto_pagamento/payment.php'>";
        
      }else if($_SESSION['bloqueado'] == 2){
        echo "<meta http-equiv='refresh' content='1;url=../auto_pagamento/payment.php'>";
      }
    }
  ?>
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
  <?php
  		$caminho_pasta_empresa = "../web/imagens/".$_SESSION['cnpj_empresa']."//logos/";
		$foto_empresa = "LogoEmpresa.jpg"; // Nome do arquivo que será salvo
		$caminho_foto_empresa = $caminho_pasta_empresa . $foto_empresa;

		if (file_exists($caminho_foto_empresa)) {
			$tipo_foto_empresa = mime_content_type($caminho_foto_empresa);
  			echo "<link rel='shortcut icon' href='data:$tipo_foto_empresa;base64," . base64_encode(file_get_contents($caminho_foto_empresa)) . "' />";
		}else{
			echo "<link rel='shortcut icon' href='https://lh3.googleusercontent.com/pw/AP1GczOReqQClzL-PZkykfOwgmMyVzQgx27DTp783MI7iwKuKSv-6P6V7KOEbCC74sGdK3DEV3O88CsBLeIvOaQwGT3x4bqCTPRtyV9zcODbYVDRxAF8zf8Uev7geh4ONPdl3arNhnSDPvbQfMdpFRPM263V9A=w250-h250-s-no-gm?authuser=0' />";
		}
	?>
  <!-- endinject -->
  <script src="../../js/functions.js"></script>
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
        <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card" <?php $_SESSION['c_card'];?>>
                

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

                    echo '<div class="card-body" '.$_SESSION['c_card'].'>';
                    echo '<div class="kt-portlet__body">';
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-12">';
                    echo '<div class="nc-form-tac">';
                    //echo '<form method="POST" id="alter_dispositivo" name="alter_dispositivo">';
                    echo '<div class="typeahead" '.$_SESSION['c_card'].' style="display: block;">';
                    
                    echo '<label for="btncd_dispositivo">Código do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['cd_dispositivo'].'" type="tel" name="btncd_dispositivo" id="btncd_dispositivo" class="form-control form-control-sm" readonly>';
/*
                    echo '<label for="btncd_casa_dispositivo">Código da Casa do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['cd_casa_dispositivo'].'" type="tel" name="btncd_casa_dispositivo" id="btncd_casa_dispositivo" class="form-control form-control-sm" readonly>';
*/
                    echo '<label for="btnmac_dispositivo">MAC do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['mac_dispositivo'].'" type="text" name="btnmac_dispositivo" id="btnmac_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnip_dispositivo">IP do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['ip_dispositivo'].'" type="text" name="btnip_dispositivo" id="btnip_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnmascara_dispositivo">Máscara do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['mascara_dispositivo'].'" type="text" name="btnmascara_dispositivo" id="btnmascara_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btngateway_dispositivo">Gateway do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['gateway_dispositivo'].'" type="text" name="btngateway_dispositivo" id="btngateway_dispositivo" class="form-control form-control-sm" readonly>';
/*
                    echo '<label for="btnmarca_dispositivo">Marca do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['marca_dispositivo'].'" type="text" name="btnmarca_dispositivo" id="btnmarca_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnmodelo_dispositivo">Modelo do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['modelo_dispositivo'].'" type="text" name="btnmodelo_dispositivo" id="btnmodelo_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnversao_dispositivo">Versão do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['versao_dispositivo'].'" type="text" name="btnversao_dispositivo" id="btnversao_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btntitulo_dispositivo">Título do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['titulo_dispositivo'].'" type="text" name="btntitulo_dispositivo" id="btntitulo_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnlocal_dispositivo">Local do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['local_dispositivo'].'" type="text" name="btnlocal_dispositivo" id="btnlocal_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnstatus_dispositivo">Status do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['status_dispositivo'].'" type="text" name="btnstatus_dispositivo" id="btnstatus_dispositivo" class="form-control form-control-sm" readonly>';
*/
                    



                    //echo "<meta http-equiv='refresh' content='1;url=".$_SESSION['dominio']."pages/md_hospedagem/p1.php'>";//<meta http-equiv="refresh" content="1;url=https://www.novapagina.com">

                    ?>
                      <script>
                        function updateContent1() {
                          fetch('p1.php')
                          .then(response => response.text())
                          .then(data => {
                            document.getElementById('content1').innerHTML = data;
                          })
                          .catch(error => console.error('Erro:', error));
                        }
                        setInterval(updateContent1, 3000);
                        window.onload = updateContent1;
                      </script>
                      <div style="width:100%;" id="content1"><h1>Carregando #1...</h1></div>
                    <?php


                    for ($i = 1; $i <= 8; $i++) {
                      if (isset($_POST['btncanal_' . $i])) {
                          $edit_canais = "UPDATE tb_dispositivo SET
                              canal_" . $i . " = '" . $_POST['btncanal_' . $i] . "'
                              WHERE cd_dispositivo = '" . $_SESSION['cd_dispositivo'] . "'";
                          if (mysqli_query($conn, $edit_canais)) {
                              //echo "<script>window.alert('Canal " . $i . " atualizado para " . $_POST['btncanal_' . $i] . "!');</script>";
                              $select_dispositivo = "SELECT * FROM tb_dispositivo WHERE cd_dispositivo = '" . $_SESSION['cd_dispositivo'] . "'";
                              $result_dispositivo = mysqli_query($conn, $select_dispositivo);
                              $row_dispositivo = mysqli_fetch_assoc($result_dispositivo);
                              // Atualiza a sessão com o novo valor do canal
                              if ($row_dispositivo) {
                                  $_SESSION['canal_' . $i] = $row_dispositivo['canal_' . $i];
                              }
                          } else {
                              echo "<script>window.alert('Erro ao atualizar o canal " . $i . "!');</script>";
                          }
                      }
                    }
/*
                    for ($i = 1; $i <= 8; $i++) {
                      if ($_SESSION['canal_' . $i] > 0) {
                        echo '<form method="POST">';
                        echo '<div class="col">';
                        echo '<p class="mb-2">Canal ' . $i . ' - ' . $_SESSION['canal_' . $i] . '</p>';
                        if ($_SESSION['canal_' . $i] == 2) {
                          echo '<input style="display:none;" type="text" id="btncanal_' . $i . '" name="btncanal_' . $i . '" value="1">';
                          echo '<input type="submit" value="Canal ' . $i . '" class="btn btn-info">';
                        } else {
                          echo '<input style="display:none;" type="text" id="btncanal_' . $i . '" name="btncanal_' . $i . '" value="2">';
                          echo '<input type="submit" value="Canal ' . $i . '" class="btn btn-dark">';
                        }
                        echo '</div>';
                        echo '</form>';
                      }
                    }
*/
                    echo '</form>';


                    echo '<td><a href="'.$_SESSION['dominio'].'/pages/md_hospedagem/editar_casa.php" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Voltar para Imóvel</a></td>';
                    echo '<td><a href="'.$_SESSION['dominio'].'/pages/dashboard/index.php" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Voltar ao início</a></td>';
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
                <div class="card" <?php $_SESSION['c_card'];?>>
                



                

              <?php
              //    if(isset($_POST['consulta'])) {
              //      // Consulta o usuário pelo CPF
              //      $sql_os = "SELECT * FROM tb_servico WHERE cd_servico = '".$_POST['conos_servico']."'";
              //      $result_os = mysqli_query($conn, $sql_os);
              //      $row_os = mysqli_fetch_assoc($result_os);

              //      // Exibe as informações do usuário no formulário
              //      if($row_os) {
              //        $_SESSION['os_servico'] = $_POST['conos_servico'];
              //        // Consulta o usuário pelo CPF
              //      }


              //    }


                    
                ?>
                
              </div>

                

              </div>
            </div>
          </div>
        
     
    
  

        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php
          include("../../partials/_footer.php");
        ?>
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