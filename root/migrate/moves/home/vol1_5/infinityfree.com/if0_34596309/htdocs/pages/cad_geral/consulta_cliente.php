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
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Consulta Cliente</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <script src="../../js/functions.js"></script>
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
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
        <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card" <?php echo $_SESSION['c_card'];?>>
                
                <div class="card-body" id="consulta" style="display: block;">
                  <h3 class="card-title">Consultar pelo telefone</h3>
                  <p class="card-description">Consulte o cliente que deseja atualizar os dados cadastrais pelo número de telefone cadastrado.</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST">
                          
                            <input placeholder="Telefone" type="tel" name="btntel_cliente" id="btntel_cliente" type="tel" class="aspNetDisabled form-control form-control-sm" required>
                            <br>
                            <button type="submit" class="btn btn-success"name="con_cliente" >Consulta</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <?php
                if(isset($_POST['con_cliente'])) {
                  
                  $query = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_POST['btntel_cliente']."'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);

                  // Exibe as informações do usuário no formulário
                  if($row) {
                    $_SESSION['concd_cliente'] = $row['cd_cliente'];
                    
                    
                    
                  }      
                }
                
              ?>
              <?php
                if(isset($_POST['atualizaCliente'])) {
                  $updatecliente = "UPDATE tb_cliente SET
                  pnome_cliente = '".$_POST['btnpnome_cliente']."',
                  snome_cliente = '".$_POST['btnsnome_cliente']."',
                  tel_cliente = '".$_POST['btntel_cliente']."',
                  email_cliente = '".$_POST['btnemail_cliente']."'
                  WHERE cd_cliente = ".$_POST['btncd_cliente']."";
                  mysqli_query($conn, $updatecliente);
                }

                if(isset($_POST['outroCliente'])) { 
                  $_SESSION['concd_cliente'] = 0;
                }
              ?>
              <?php
                if($_SESSION['concd_cliente'] > 0){
                  echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                  echo '<div class="col-12 grid-margin">';
                  echo '<div class="card" '.$_SESSION['c_card'].'>';
                  echo '<div class="card-body" id="editaCliente"><!--FORMULÁRIO PARA CRIAR OS-->';
                  echo '<div class="kt-portlet__body">';
                  echo '<div class="row">';
          
                  $select_cliente = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$_SESSION['concd_cliente']."'";
                  $result_cliente = mysqli_query($conn, $select_cliente);
                  $row_cliente = mysqli_fetch_assoc($result_cliente);

                  // Exibe as informações do usuário no formulário
                  if($row_cliente) {
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      echo '<h3 class="card-title">Dados Pessoais</h3>';
                      echo '<form method="POST">';
                      //echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" style="display:block;">';
                      echo '<input value="'.$row_cliente['cd_cliente'].'" name="btncd_cliente" type="text" id="btncd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                      echo '<label for="btnpnome_cliente">Nome</label>';
                      echo '<input value="'.$row_cliente['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btnsnome_cliente">sobrenome</label>';
                      echo '<input value="'.$row_cliente['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btntel_cliente">Telefone</label>';
                      echo '<input value="'.$row_cliente['tel_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" oninput="validateInput(this)"/>';
                      echo '<label for="btnemail_cliente">Email</label>';
                      echo '<input value="'.$row_cliente['email_cliente'].'" name="btnemail_cliente" type="email"  id="btnemail_cliente" maxlenth="40" class="aspNetDisabled form-control form-control-sm"/>';
                      
                      //echo '</div>';        
                      echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="atualizaCliente" id="atualizaCliente" style="margin-top: 20px; margin-bottom: 20px;">Atualizar cadastro</button>';
                      echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="outroCliente" id="outroCliente" style="margin-top: 20px; margin-bottom: 20px;">Outro Cliente</button>';
                    
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      
                    }
                    ?>
                          
                          


                          <p id="error-message" style="color: #DDDDDD;"></p>
                      
                          <script>
                              function validateInput(inputElement) {
                                  var inputValue = inputElement.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                                  var errorMessageElement = document.getElementById("error-message");
                      
                                  if (inputValue.length === 11) {
                                      errorMessageElement.textContent = "";
                                      inputElement.setCustomValidity("");
                                  } else if (inputValue.length === 10) {
                                      errorMessageElement.textContent = "Insira um número válido com DDD.";
                                      inputElement.setCustomValidity("Insira um número válido com DDD.");
                                  } else if (inputValue.length === 9) {
                                      errorMessageElement.textContent = "Insira o DDD e o número completo.";
                                      inputElement.setCustomValidity("Insira o DDD e o número completo.");
                                  } else {
                                      errorMessageElement.textContent = "Insira um número válido.";
                                      inputElement.setCustomValidity("Insira um número válido.");
                                  }
                              }
                      
                              var phoneInput = document.getElementById("contel_cliente");
                              phoneInput.addEventListener("input", function () {
                                  validateInput(phoneInput);
                              });
                          </script>
                    <?php
                    
                    
                    


                    //echo '<label for="lancarPagamento"></label>';
                    //echo '<input type="submit" name="lancarPagamento" id="lancarPagamento" class="btn btn-success"">';
                    
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    
                    
                    
                   

                    
                    
                    
                      
                    

                    /*             


                    echo '<form action="impresso.php" method="POST" target="_blank">';
                    echo '<div style="display:none;">';
                    //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                    echo '<input value="'.$_SESSION['cd_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" style="display: none;"/>';
                    //echo '<label for="btnpnome_cliente">Nome</label>';
                    echo '<input value="'.$_SESSION['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40" readonly/>';
                    //echo '<label for="btnsnome_cliente">sobrenome</label>';
                    echo '<input value="'.$_SESSION['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40" readonly/>';
                    //echo '<label for="btntel_cliente">Telefone</label>';
                    echo '<input value="'.$_SESSION['tel_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" readonly/>';
                    echo '<script>document.getElementById("showcd_cliente").value = "'.$_SESSION['cd_cliente'].'"</script>';
                    echo '<script>document.getElementById("btnpnome_cliente").value = "'.$_SESSION['pnome_cliente'].'"</script>';
                    echo '<script>document.getElementById("btnsnome_cliente").value = "'.$_SESSION['snome_cliente'].'"</script>';
                    echo '<script>document.getElementById("btntel_cliente").value = "'.$_SESSION['tel_cliente'].'"</script>';

                    //echo '<label for="btncd_servico">OS</label>';
                    echo '<input value="'.$_SESSION['cd_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" readonly>';
                    //echo '<label for="btnobs_servico">Descrição Geral</label>';
                    echo '<input value="'.$_SESSION['obs_servico'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico" placeholder="Caracteristica geral do serviço" readonly>';
                    //echo '<label for="btnprioridade_servico">Prioridade</label>';
                    echo '<select name="btnprioridade_servico" id="btnprioridade_servico">';
                    echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >'.$_SESSION['prioridade_servico'].'</option>';
                    echo '</select>';
                    //echo '<!--<label for="btnprazo_servico">Entrada</label>-->';
                    echo '<input value="'.$_SESSION['entrada_servico'].'" name="btnentrada_servico" type="datetime-local" id="btnentrada_servico" readonly/>';
                    //echo '<label for="btnprazo_servico">Prazo</label>';
                    echo '<input value="'.$_SESSION['prazo_servico'].'" name="btnprazo_servico" type="datetime-local" id="btnprazo_servico" readonly/>';
                    
                    echo '<script>document.getElementById("btncd_servico").value = "'.$_SESSION['cd_servico'].'"</script>';
                    echo '<script>document.getElementById("btnobs_servico").value = "'.$_SESSION['obs_servico'].'"</script>';
                    echo '<script>document.getElementById("btnprioridade_servico").value = "'.$_SESSION['prioridade_servico'].'"</script>';
                    echo '<script>document.getElementById("btnentrada_servico").value = "'.$_SESSION['entrada_servico'].'"</script>';
                    echo '<script>document.getElementById("btnprazo_servico").value = "'.$_SESSION['prazo_servico'].'"</script>';

                    //echo '<label for="showobs_servico">Total</label>';
                    echo '<input value="'.$_SESSION['vtotal_orcamento'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" readonly>';
                    //echo '<label for="showobs_servico">Pago</label>';
                    echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" readonly>';
                    

                    echo '<script>document.getElementById("btnvtotal_orcamento").value = "'.$_SESSION['vtotal_orcamento'].'"</script>';
                    echo '<script>document.getElementById("btnvpag_orcamento").value = "'.$_SESSION['vpag_servico'].'"</script>';
                    echo '</div>';

                    
                    //echo '<button type="submit" name="lancarOrcamento" class="btn btn-success">LançarOrcamento</button>';
                    echo '<button type="submit" name="imprimir_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">OS <i class="mdi mdi-printer btn-icon-append"></i></button>';
                    echo '<button type="submit" name="historico_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Histórico <i class="mdi mdi-printer btn-icon-append"></i></button>';
                    echo '<button type="submit" name="via_cliente" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente <i class="mdi mdi-printer btn-icon-append"></i></button>';
                    echo '<button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente <i class="mdi mdi-whatsapp"></i></button>';
                    //echo '<button type="submit" class="btn btn-danger" name="limparOS-" style="margin: 5px;">Nova Consulta</button>';     
                    echo '</form>';
                    echo '<form method="post">';//echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Nova Consulta</button>';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-warning" name="editaOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-file-check btn-icon-append"></i> Editar</button>';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-reload btn-icon-prepend"></i> Nova Consulta</button>';
                    //<i class="mdi mdi-alert btn-icon-prepend"></i>  
                    echo '</form>';
                    */

                  }

                  
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