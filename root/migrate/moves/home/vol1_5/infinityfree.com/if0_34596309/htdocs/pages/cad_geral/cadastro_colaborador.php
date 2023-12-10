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
                  <h3 class="card-title">Consultar pelo E-Mail</h3>
                  <p class="card-description">Informe o E-Mail do colaborador que deseja acompanhar.</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST">
                          
                            <input placeholder="E-Mail" type="email" name="email_colab" id="email_colab" class="aspNetDisabled form-control form-control-sm" required>
                            <br>
                            <button type="submit" class="btn btn-success"name="con_colab" >Consulta</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <?php
                if(isset($_POST['con_colab'])) {
                  
                  $query = "SELECT * FROM tb_colab WHERE email_colab = '".$_POST['email_colab']."'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);

                  // Exibe as informações do usuário no formulário
                  if($row) {
                    $_SESSION['concd_colab'] = $row['cd_colab'];
                    
                    
                    
                  }else{
                    $_SESSION['concd_colab'] = "NULL";
                  }
                }
                
              ?>
              <?php
                if(isset($_POST['atualizaColab'])) {
                  $updatecolab = "UPDATE tb_colab SET
                  pnome_colab = '".$_POST['btnpnome_colab']."',
                  snome_colab = '".$_POST['btnsnome_colab']."',
                  tel_colab = '".$_POST['btntel_colab']."',
                  email_colab = '".$_POST['btnemail_colab']."'
                  WHERE cd_colab = ".$_POST['btncd_colab']."";
                  mysqli_query($conn, $updatecolab);
                }
                if(isset($_POST['cadColab'])) {
                  echo "<script>window.alert('A senha padrão para novos usuários é: 1');</script>";
                  $cadcolab = "INSERT INTO tb_colab(pnome_colab, snome_colab, tel_colab, email_colab, senha_colab) VALUES(
                  '".$_POST['cadpnome_colab']."',
                  '".$_POST['cadsnome_colab']."',
                  '".$_POST['cadtel_colab']."',
                  '".$_POST['cademail_colab']."',
                  '1')";
                  mysqli_query($conn, $cadcolab);
                  
                  

                  $con_cdcolab = "SELECT * FROM tb_colab WHERE email_colab = '".$_POST['cademail_colab']."'";
                  $result_cdcolab = mysqli_query($conn, $con_cdcolab);
                  $row_cdcolab = mysqli_fetch_assoc($result_cdcolab);
                  if($row_cdcolab) {
                    $_SESSION['concd_colab'] = $row_cdcolab['cd_colab'];
                  }
                    

                  $cadrelColab = "INSERT INTO rel_user(cd_seg, cd_colab, cd_estilo, cd_funcao, cd_empresa, cd_status) VALUES(
                    '".$_POST['cadseg_colab']."',
                    '".$_SESSION['concd_colab']."',
                    '".$_POST['cadestilo_colab']."',
                    '".$_POST['cadfuncao_colab']."',
                    '".$_SESSION['cd_empresa']."',
                    '1')";
                    mysqli_query($conn, $cadrelColab);
                    echo "<script>window.alert('Relações Cadastradas!');</script>";
                }
                if(isset($_POST['outroColab'])) { 
                  $_SESSION['concd_colab'] = false;
                }
              ?>
              <?php
                if($_SESSION['concd_colab'] > 0){
                  echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                  echo '<div class="col-12 grid-margin">';
                  echo '<div class="card" '.$_SESSION['c_card'].'>';
                  echo '<div class="card-body" id="editaColab"><!--FORMULÁRIO PARA CRIAR OS-->';
                  echo '<div class="kt-portlet__body">';
                  echo '<div class="row">';
          
                  $select_colab = "SELECT * FROM tb_colab WHERE cd_colab = '".$_SESSION['concd_colab']."'";
                  $result_colab = mysqli_query($conn, $select_colab);
                  $row_colab = mysqli_fetch_assoc($result_colab);

                  // Exibe as informações do usuário no formulário
                  if($row_colab) {
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      echo '<h3 class="card-title">Dados Pessoais</h3>';
                      echo '<form method="POST">';
                      //echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" style="display:block;">';
                      echo '<input value="'.$row_colab['cd_colab'].'" name="btncd_colab" type="text" id="btncd_colab" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                      echo '<label for="btnpnome_colab">Nome</label>';
                      echo '<input value="'.$row_colab['pnome_colab'].'" name="btnpnome_colab" type="text" id="btnpnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btnsnome_colab">sobrenome</label>';
                      echo '<input value="'.$row_colab['snome_colab'].'" name="btnsnome_colab" type="text" id="btnsnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btntel_colab">Telefone</label>';
                      echo '<input value="'.$row_colab['tel_colab'].'" name="btntel_colab" type="tel"  id="btntel_colab" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" oninput="validateInput(this)"/>';
                      echo '<label for="btnemail_colab">Email</label>';
                      echo '<input value="'.$row_colab['email_colab'].'" name="btnemail_colab" type="email"  id="btnemail_colab" maxlenth="40" class="aspNetDisabled form-control form-control-sm"/>';
                      
                      //echo '</div>';        
                      echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="atualizaColab" id="atualizaColab" style="margin-top: 20px; margin-bottom: 20px;">Atualizar cadastro</button>';
                      echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="outroColab" id="outroColab" style="margin-top: 20px; margin-bottom: 20px;">Outro Cliente</button>';
                    
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

                }elseif($_SESSION['concd_colab'] == "NULL"){

                  echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                  echo '<div class="col-12 grid-margin">';
                  echo '<div class="card" '.$_SESSION['c_card'].'>';
                  echo '<div class="card-body" id="editaColab"><!--FORMULÁRIO PARA CRIAR OS-->';
                  echo '<div class="kt-portlet__body">';
                  echo '<div class="row">';



                  echo '<div class="col-12 col-md-12">';
                  echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                  echo '<h3 class="card-title">Dados Pessoais</h3>';
                  echo '<form method="POST">';
                  //echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" style="display:block;">';
                  //echo '<input name="cadcd_colab" type="text" id="cadcd_colab" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                  echo '<label for="cadpnome_colab">Nome</label>';
                  echo '<input name="cadpnome_colab" type="text" id="cadpnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                  echo '<label for="cadsnome_colab">sobrenome</label>';
                  echo '<input name="cadsnome_colab" type="text" id="cadsnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                  echo '<label for="cadtel_colab">Telefone</label>';
                  echo '<input name="cadtel_colab" type="tel"  id="cadtel_colab" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" oninput="validateInput(this)"/>';
                  echo '<label for="cademail_colab">Email</label>';
                  echo '<input value="'.$_POST['email_colab'].'" name="cademail_colab" type="email"  id="cademail_colab" maxlenth="40" class="aspNetDisabled form-control form-control-sm"/>';
                  
                  echo '<h3 class="kt-portlet__head-title">Funções e Permissões</h3>';
                  $select_estilo = "SELECT * FROM tb_estilo";
                  $result_estilo = mysqli_query($conn, $select_estilo);
                  echo '<label>Estilo</label>';
                  echo '<select name="cadestilo_colab" id="cadestilo_colab" class="aspNetDisabled form-control form-control-sm">';
                  while($row_estilo = $result_estilo->fetch_assoc()) {
                    echo '  <option value="'.$row_estilo['cd_estilo'].'">'.$row_estilo['titulo_estilo'].'</option>';
                  }
                  echo '</select>';

                  $select_funcao = "SELECT * FROM tb_funcao";
                  $result_funcao = mysqli_query($conn, $select_funcao);
                  echo '<label>Função</label>';
                  echo '<select name="cadfuncao_colab" id="cadfuncao_colab" class="aspNetDisabled form-control form-control-sm">';
                  while($row_funcao = $result_funcao->fetch_assoc()) {
                    echo '  <option value="'.$row_funcao['cd_funcao'].'">'.$row_funcao['titulo_funcao'].'</option>';
                  }
                  echo '</select>';
                  
                  $select_seguranca = "SELECT * FROM tb_seguranca";
                  $result_seguranca = mysqli_query($conn, $select_seguranca);
                  echo '<label>Permissões</label>';
                  echo '<select name="cadseg_colab" id="cadseg_colab" class="aspNetDisabled form-control form-control-sm">';
                  while($row_seguranca = $result_seguranca->fetch_assoc()) {
                    echo '  <option value="'.$row_seguranca['cd_seg'].'">'.$row_seguranca['titulo_seg'].'</option>';
                  }
                  echo '</select>';
                  //echo '</div>';        
                  echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="cadColab" id="cadColab" style="margin-top: 20px; margin-bottom: 20px;">Cadastrar</button>';
                  echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="outroColab" id="outroColab" style="margin-top: 20px; margin-bottom: 20px;">Desfazer</button>';
                    
                  echo '</form>';
                  echo '</div>';
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