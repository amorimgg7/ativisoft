<?php  
    session_start(); 
    if(!isset($_SESSION['cd_colab']))
    {
        header("location: ../../pages/samples/login.php");
        exit;
    }
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    include("../../classes/tools.php");
    $u = new Usuario;
    
    $t = new Tools;
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
  <link rel="stylesheet" href="../../css/custom.css">
  
  <link rel='shortcut icon' href='https://lh3.googleusercontent.com/pw/AP1GczOReqQClzL-PZkykfOwgmMyVzQgx27DTp783MI7iwKuKSv-6P6V7KOEbCC74sGdK3DEV3O88CsBLeIvOaQwGT3x4bqCTPRtyV9zcODbYVDRxAF8zf8Uev7geh4ONPdl3arNhnSDPvbQfMdpFRPM263V9A=w250-h250-s-no-gm?authuser=0' />

  <!-- endinject -->
  <script src="../../js/functions.js"></script>
  <link rel="shortcut icon" href="<?php //echo $_SESSION['logo_empresa']; ?>" />
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>-->
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
                  <p class="card-description">Consulte o funcionário que deseja cadastrar ou atualizar os dados cadastrais pelo número de telefone.</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        

                        
                          <form method="POST">
                          
                          <div class="form-group" style="display: flex;">
                            <div class="input-group">
                              <?php 
                                $resultado = $t->telefone(0);
                                echo '<div class="input-group">';
                                echo '    <div class="input-group-prepend">';
                                echo '      <select name="cd_pais" id="cd_pais"  class="input-group-text" required>';
                                echo '      <option selected="selected" value="'.$resultado['codigo_pais'].'">'.$resultado['nome_pais'].'</option>';
                                echo $resultado['lista_paises'];
                                echo '      </select>  ';
                                echo '    </div>';
                                echo '    <input placeholder="Telefone" type="tel" value="'.$resultado['ddd'].$resultado['numero'].'" name="btntel_colab" id="btntel_colab" type="tel" class="form-control form-control-sm" required oninput="tel(this)">';
                                echo '    <div class="input-group-append">';
                                echo '    </div>';
                                echo '    </div>';
                              ?>
                            </div>
                          </div>
                          <p id="error-message" style="color: #DDDDDD;"></p>
                          



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
                  $_SESSION['contel_colab'] = $_POST['cd_pais'].$_POST['btntel_colab'];
                  $query = "SELECT * FROM tb_pessoa WHERE tipo_pessoa = 'colab' AND tel1_pessoa = '".$_SESSION['contel_colab']."'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);

                  // Exibe as informações do usuário no formulário
                  if($row) {
                    $_SESSION['concd_colab'] = $row['cd_pessoa']; 
                  }      
                }
                if(!isset($_SESSION['concd_colab'])){
                  $_SESSION['concd_colab'] = 0;
                }
                
              ?>
              <?php
                if(isset($_POST['atualizaCliente'])) {
                  $updatecliente = "UPDATE tb_pessoa SET
                  pnome_pessoa = '".$_POST['btnpnome_colab']."',
                  snome_pessoa = '".$_POST['btnsnome_colab']."',
                  cpf_pessoa = '".$_POST['btncpf_colab']."',
                  tel1_pessoa = '".$_POST['cd_pais'].$_POST['btntel_colab']."',
                  email_pessoa = '".$_POST['btnemail_colab']."'
                  WHERE cd_pessoa = ".$_POST['btncd_colab']."";
                  mysqli_query($conn, $updatecliente);
                }

                if(isset($_POST['outroCliente'])) { 
                  $_SESSION['concd_colab'] = 0;
                }
              ?>
              <?php
                if($_SESSION['concd_colab'] > 0){
                  echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                  echo '<div class="col-12 grid-margin">';
                  echo '<div class="card" '.$_SESSION['c_card'].'>';
                  echo '<div class="card-body" id="editaCliente"><!--FORMULÁRIO PARA CRIAR OS-->';
                  echo '<div class="kt-portlet__body">';
                  echo '<div class="row">';
          
                  $select_colab = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$_SESSION['concd_colab']."'";
                  $result_colab = mysqli_query($conn, $select_colab);
                  $row_colab = mysqli_fetch_assoc($result_colab);

                  // Exibe as informações do usuário no formulário
                  if($row_colab) {
                      echo '<div class="col-12 col-md-12">';
                      echo '<div class="nc-form-tac">';
                      echo '<h3 class="card-title">Dados Pessoais</h3>';
                      echo '<form method="POST">';
                      echo '<label for="btncd_colab">CD</label>';
                      //echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" style="display:block;">';
                      echo '<input value="'.$row_colab['cd_pessoa'].'" name="btncd_colab" type="text" id="btncd_colab" class="aspNetDisabled form-control form-control-sm" readonly style="display: block;"/>';
                      echo '<label for="btnpnome_colab">Nome</label>';
                      echo '<input value="'.$row_colab['pnome_pessoa'].'" name="btnpnome_colab" type="text" id="btnpnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btnsnome_colab">sobrenome</label>';
                      echo '<input value="'.$row_colab['snome_pessoa'].'" name="btnsnome_colab" type="text" id="btnsnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btncpf_colab">CPF</label>';

                      $resultadoCPF = $t->validarCPF($row_colab['cpf_pessoa']);
                        
                        //echo "CPF Formatado: " . $resultadoCPF['cpf_formatado'] . "<br>";
                        //echo "Bloco 1: " . $resultadoCPF['bloco1'] . "<br>";
                        //echo "Bloco 2: " . $resultadoCPF['bloco2'] . "<br>";
                        //echo "Bloco 3: " . $resultadoCPF['bloco3'] . "<br>";
                        //echo "Dígito Verificador: " . $resultadoCPF['digito_verificador'] . "<br>";
                        //echo "Válido: " . ($resultadoCPF['valido'] ? "Sim" : "Não") . "<br>";

                      echo '<input value="'.$row_colab['cpf_pessoa'].'" oninput="cpf(this)" name="btncpf_colab" type="tel"  id="btncpf_colab" class="aspNetDisabled form-control form-control-sm"/>';
                      
                      echo '<script>document.getElementById("btncpf_colab").style.border = "'.($resultadoCPF['valido'] ? '' : '2px solid red').'";</script>';

                      //echo '<script>document.getElementById("btncpf_colab").style.border = "2px solid red";</script>';

                      echo '<label for="btntel_colab">Telefone</label>';
                      $resultado = $t->telefone($row_colab['tel1_pessoa']);
                      echo '<div class="input-group">';
                      echo '    <div class="input-group-prepend">';
                      echo '      <select name="cd_pais" id="cd_pais"  class="input-group-text" required>';
                      echo '      <option selected="selected" value="'.$resultado['codigo_pais'].'">'.$resultado['nome_pais'].'</option>';
                      echo $resultado['lista_paises'];

                      echo '      </select>  ';
                      echo '    </div>';
                      echo '    <input placeholder="Telefone" type="tel" value="'.$resultado['ddd'].$resultado['numero'].'" name="btntel_colab" id="btntel_colab" type="tel" class="form-control form-control-sm" required oninput="tel(this)">';
                      echo '    <div class="input-group-append">';

                      echo '    </div>';
                      echo '    </div>';

                      //echo '<input value="'.$row_colab['tel1_pessoa'].'" name="btntel_colab" type="tel"  id="btntel_colab" class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btnemail_colab">Email</label>';
                      echo '<input value="'.$row_colab['email_pessoa'].'" name="btnemail_colab" type="email"  id="btnemail_colab" maxlenth="40" class="aspNetDisabled form-control form-control-sm"/>';
                      
                      //echo '</div>';        
                      echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="atualizaCliente" id="atualizaCliente" style="margin-top: 20px; margin-bottom: 20px;">Atualizar cadastro</button>';
                      echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="outroCliente" id="outroCliente" style="margin-top: 20px; margin-bottom: 20px;">Sair</button>';
                    
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      
                    }
                    ?>
                          
                          


                          <p id="error-message" style="color: #DDDDDD;"></p>
                      
                          <script>
                          //    function validateInput(inputElement) {
                          //        var inputValue = inputElement.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                          //        var errorMessageElement = document.getElementById("error-message");
                      
                          //        if (inputValue.length === 11) {
                          //            errorMessageElement.textContent = "";
                          //            inputElement.setCustomValidity("");
                          //        } else if (inputValue.length === 10) {
                          //            errorMessageElement.textContent = "Insira um número válido com DDD.";
                          //            inputElement.setCustomValidity("Insira um número válido com DDD.");
                          //        } else if (inputValue.length === 9) {
                          //            errorMessageElement.textContent = "Insira o DDD e o número completo.";
                          //            inputElement.setCustomValidity("Insira o DDD e o número completo.");
                          //        } else {
                          //            errorMessageElement.textContent = "Insira um número válido.";
                          //            inputElement.setCustomValidity("Insira um número válido.");
                          //        }
                          //    }
                      
                          //    var phoneInput = document.getElementById("contel_colab");
                          //    phoneInput.addEventListener("input", function () {
                          //        validateInput(phoneInput);
                          //    });
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
                    echo '<input value="'.$_SESSION['cd_colab'].'" name="btncd_colab" type="text" id="showcd_colab" style="display: none;"/>';
                    //echo '<label for="btnpnome_colab">Nome</label>';
                    echo '<input value="'.$_SESSION['pnome_colab'].'" name="btnpnome_colab" type="text" id="btnpnome_colab" maxlength="40" readonly/>';
                    //echo '<label for="btnsnome_colab">sobrenome</label>';
                    echo '<input value="'.$_SESSION['snome_colab'].'" name="btnsnome_colab" type="text" id="btnsnome_colab" maxlength="40" readonly/>';
                    //echo '<label for="btntel_colab">Telefone</label>';
                    echo '<input value="'.$_SESSION['tel_colab'].'" name="btntel_colab" type="tel"  id="btntel_colab" oninput="tel(this)" readonly/>';
                    echo '<script>document.getElementById("showcd_colab").value = "'.$_SESSION['cd_colab'].'"</script>';
                    echo '<script>document.getElementById("btnpnome_colab").value = "'.$_SESSION['pnome_colab'].'"</script>';
                    echo '<script>document.getElementById("btnsnome_colab").value = "'.$_SESSION['snome_colab'].'"</script>';
                    echo '<script>document.getElementById("btntel_colab").value = "'.$_SESSION['tel_colab'].'"</script>';

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
                    echo '<button type="submit" name="via_colab" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente <i class="mdi mdi-printer btn-icon-append"></i></button>';
                    echo '<button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente <i class="mdi mdi-whatsapp"></i></button>';
                    //echo '<button type="submit" class="btn btn-danger" name="limparOS-" style="margin: 5px;">Nova Consulta</button>';     
                    echo '</form>';
                    echo '<form method="post">';//echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Nova Consulta</button>';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-warning" name="editaOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-file-check btn-icon-append"></i> Editar</button>';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-reload btn-icon-prepend"></i> Nova Consulta</button>';
                    //<i class="mdi mdi-alert btn-icon-prepend"></i>  
                    echo '</form>';
                    */

                }else if($_SESSION['concd_colab'] == 0 && isset($_SESSION['contel_colab'])){


                  echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                  echo '<div class="col-12 grid-margin">';
                  echo '<div class="card" '.$_SESSION['c_card'].'>';
                  echo '<div class="card-body" id="cadastraCliente"><!--FORMULÁRIO PARA CRIAR OS-->';
                  echo '<div class="kt-portlet__body">';
                  echo '<div class="row">';
          
                  echo '<div class="col-12 col-md-12">';
                  echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                  echo '<h3 class="card-title">Cadastrar Funcionário</h3>';
                  echo '<form method="POST">';
                  echo '<div class="form-group-custom">';
                  echo '<label for="btnpnome_colab">Nome</label>';
                  echo '<input  name="btnpnome_colab" type="text" id="btnpnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                  echo '</div>';
                  echo '<div class="form-group-custom">';
                  echo '<label for="btnsnome_colab">sobrenome</label>';
                  echo '<input  name="btnsnome_colab" type="text" id="btnsnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                  echo '</div>';
                  echo '<div class="form-group-custom">';
                  echo '<label for="btncpf_colab">CPF</label>';

                      $resultadoCPF = $t->validarCPF(0);
                        
                        //echo "CPF Formatado: " . $resultadoCPF['cpf_formatado'] . "<br>";
                        //echo "Bloco 1: " . $resultadoCPF['bloco1'] . "<br>";
                        //echo "Bloco 2: " . $resultadoCPF['bloco2'] . "<br>";
                        //echo "Bloco 3: " . $resultadoCPF['bloco3'] . "<br>";
                        //echo "Dígito Verificador: " . $resultadoCPF['digito_verificador'] . "<br>";
                        //echo "Válido: " . ($resultadoCPF['valido'] ? "Sim" : "Não") . "<br>";

                      echo '<input oninput="cpf(this)" name="btncpf_colab" type="tel"  id="btncpf_colab" class="aspNetDisabled form-control form-control-sm"/>';
                      echo '</div>';
                      //echo '<script>document.getElementById("btncpf_colab").style.border = "'.($resultadoCPF['valido'] ? '' : '2px solid red').'";</script>';

                      //echo '<script>document.getElementById("btncpf_colab").style.border = "2px solid red";</script>';

                      echo '<div class="form-group-custom">';
                      
                      $resultado = $t->telefone($_SESSION['contel_colab']);
                      echo '<div class="input-group">';
                      echo '<div class="input-group-prepend">';
                      echo '<select name="cd_pais" id="cd_pais"  class="input-group-text" required>';
                      echo '<option selected="selected" value="'.$resultado['codigo_pais'].'">'.$resultado['nome_pais'].'</option>';
                      echo $resultado['lista_paises'];

                      echo '</select>  ';
                      echo '</div>';
                      echo '<label for="btntel_colab">Telefone</label>';
                      echo '<input placeholder="Telefone" type="tel" value="'.$resultado['ddd'].$resultado['numero'].'" name="btntel_colab" id="btntel_colab" type="tel" class="form-control form-control-sm" required oninput="tel(this)">';
                      echo '<div class="input-group-append">';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';

                      echo '<div class="form-group-custom">';
                      echo '<label for="btnemail_colab">Email</label>';
                      echo '<input name="btnemail_colab" type="email"  id="btnemail_colab" maxlenth="40" class="aspNetDisabled form-control form-control-sm"/>';
                      echo '</div>';

                      echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="cadastrarColab" id="cadastrarColab" style="margin-top: 20px; margin-bottom: 20px;">Cadastrar</button>';
                      echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="outroColab" id="outroColab" style="margin-top: 20px; margin-bottom: 20px;">Sair</button>';
                    
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      
                    
                    ?>
                          
                          


                          <p id="error-message" style="color: #DDDDDD;"></p>
                      
                          <script>
                          //    function validateInput(inputElement) {
                          //        var inputValue = inputElement.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                          //        var errorMessageElement = document.getElementById("error-message");
                      
                          //        if (inputValue.length === 11) {
                          //            errorMessageElement.textContent = "";
                          //            inputElement.setCustomValidity("");
                          //        } else if (inputValue.length === 10) {
                          //            errorMessageElement.textContent = "Insira um número válido com DDD.";
                          //            inputElement.setCustomValidity("Insira um número válido com DDD.");
                          //        } else if (inputValue.length === 9) {
                          //            errorMessageElement.textContent = "Insira o DDD e o número completo.";
                          //            inputElement.setCustomValidity("Insira o DDD e o número completo.");
                          //        } else {
                          //            errorMessageElement.textContent = "Insira um número válido.";
                          //            inputElement.setCustomValidity("Insira um número válido.");
                          //        }
                          //    }
                      
                          //    var phoneInput = document.getElementById("contel_colab");
                          //    phoneInput.addEventListener("input", function () {
                          //        validateInput(phoneInput);
                          //    });
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
                    echo '<input value="'.$_SESSION['cd_colab'].'" name="btncd_colab" type="text" id="showcd_colab" style="display: none;"/>';
                    //echo '<label for="btnpnome_colab">Nome</label>';
                    echo '<input value="'.$_SESSION['pnome_colab'].'" name="btnpnome_colab" type="text" id="btnpnome_colab" maxlength="40" readonly/>';
                    //echo '<label for="btnsnome_colab">sobrenome</label>';
                    echo '<input value="'.$_SESSION['snome_colab'].'" name="btnsnome_colab" type="text" id="btnsnome_colab" maxlength="40" readonly/>';
                    //echo '<label for="btntel_colab">Telefone</label>';
                    echo '<input value="'.$_SESSION['tel_colab'].'" name="btntel_colab" type="tel"  id="btntel_colab" oninput="tel(this)" readonly/>';
                    echo '<script>document.getElementById("showcd_colab").value = "'.$_SESSION['cd_colab'].'"</script>';
                    echo '<script>document.getElementById("btnpnome_colab").value = "'.$_SESSION['pnome_colab'].'"</script>';
                    echo '<script>document.getElementById("btnsnome_colab").value = "'.$_SESSION['snome_colab'].'"</script>';
                    echo '<script>document.getElementById("btntel_colab").value = "'.$_SESSION['tel_colab'].'"</script>';

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
                    echo '<button type="submit" name="via_colab" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente <i class="mdi mdi-printer btn-icon-append"></i></button>';
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