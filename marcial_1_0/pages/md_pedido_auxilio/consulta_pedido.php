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
  <title>Pedido</title>
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
                <div class="card-body" id="consulta" style="display: block;" >
                  <h3 class="card-title">Consultar pela Solicitação</h3>
                  <p class="card-description">Consulte a solicitação de auxílio pela ID.</p>
                  <div class="kt-portlet__body" >
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        <form method="POST">
                          <input placeholder="Pedido" type="tel" name="concd_pedido" id="concd_pedido" type="tel" maxlength="10" class="aspNetDisabled form-control form-control-sm" required>
                          <br>
                          <button type="submit" name="consulta" class="btn btn-success">Consulta</button>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php
                  if(isset($_POST['limparSolicitacao'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    session_start();
                    $_SESSION['cd_pessoa_pedido'] = 0;
                    $_SESSION['cd_pedido'] = 0;
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                    
                    
                }
                ?>
                
                <?php
                if(isset($_POST['concd_pedido'])){
                  $select_pedido_auxilio = "SELECT * FROM tb_pedido_auxilio WHERE cd_pedido_auxilio = '".$_POST['concd_pedido']."'";
                  $result_pedido_auxilio = mysqli_query($conn, $select_pedido_auxilio);
                  $row_pedido_auxilio = mysqli_fetch_assoc($result_pedido_auxilio);
                  // Exibe as informações do usuário no formulário
                  if($row_pedido_auxilio) {
                    $_SESSION['cd_pessoa_pedido'] = $row_pedido_auxilio['cd_pessoa'];
                    $_SESSION['pedido'] = $row_pedido_auxilio['cd_pedido_auxilio'];
                    $_SESSION['cd_pedido'] = $row_pedido_auxilio['cd_pedido_auxilio'];
                    $_SESSION['obs_con_pedido'] = $row_pedido_auxilio['obs_pedido_auxilio'];
                    $_SESSION['cd_pessoa_conferente_1'] = $row_pedido_auxilio['cd_quem_abriu_primeiro'];
                    $_SESSION['cd_pessoa_conferente_2'] = $row_pedido_auxilio['cd_quem_abriu_ultimo'];
                  }

                  $select_cliente = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$_SESSION['cd_pessoa_pedido']."'";
                  $result_cliente = mysqli_query($conn, $select_cliente);
                  $row_cliente = mysqli_fetch_assoc($result_cliente);
                  if($row_cliente) {
                    $_SESSION['cd_pessoa_pedido'] = $row_cliente['cd_pessoa'];
                    $_SESSION['pnome_pessoa_pedido'] = $row_cliente['pnome_pessoa'];
                    $_SESSION['snome_pessoa_pedido'] = $row_cliente['snome_pessoa'];
                    $_SESSION['tel_pessoa_pedido'] = $row_cliente['tel_pessoa'];                
                  }
                }
                  
                ?>

                <?php
                if(isset($_SESSION['cd_pedido'])){

                
                  if($_SESSION['cd_pedido'] > 0){


                      $_SESSION['pedido'] = $_SESSION['cd_pedido'];
                      

                    echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                  
                    echo '<div class="card-body" id="abrirOS2"><!--FORMULÁRIO PARA CRIAR OS-->';
                    echo '<div class="kt-portlet__body">';
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-12">';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                            
                  
                    
                    
                    //echo '<form method="POST">';
                    
                    //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" style="display:block;">';
                    echo '<form method="POST" action="../cad_geral/consulta_cliente.php">';
                    echo '<input value="'.$_SESSION['cd_pessoa_pedido'].'" name="btncd_pessoa_pedido" type="text" id="btncd_pessoa_pedido" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                    echo '<label for="btnpnome_cliente">Nome</label>';
                    echo '<input value="'.$_SESSION['pnome_pessoa_pedido'].'" name="btnpnome_pessoa_pedido" type="text" id="btnpnome_pessoa_pedido" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btnsnome_cliente">sobrenome</label>';
                    echo '<input value="'.$_SESSION['snome_pessoa_pedido'].'" name="btnsnome_pessoa_pedido" type="text" id="btnsnome_pessoa_pedido" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">Telefone</label>';
                    echo '<input value="'.$_SESSION['tel_pessoa_pedido'].'" name="btntel_pessoa_pedido" type="tel"  id="btntel_pessoa_pedido" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<td><button type="submit" name="con_pessoa_pedido" id="con_pessoa_pedido" class="btn btn-block btn-outline-warning"><i class="icon-cog">Ficha Cadastral</i></button></td>';
                    echo '</form>';
                    echo '</div>';
                    echo '<script>document.getElementById("showcd_pessoa_pedido").value = "'.$_SESSION['cd_pessoa_pedido'].'"</script>';
                    echo '<script>document.getElementById("btnpnome_pessoa_pedido").value = "'.$_SESSION['pnome_pessoa_pedido'].'"</script>';
                    echo '<script>document.getElementById("btnsnome_pessoa_pedido").value = "'.$_SESSION['snome_pessoa_pedido'].'"</script>';
                    echo '<script>document.getElementById("btntel_pessoa_pedido").value = "'.$_SESSION['tel_pessoa_pedido'].'"</script>';

                    //echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="display: block;">';
                    echo '<form method="POST" action="cadastro_servico.php">';
                    
                    echo '<label for="btncd_servico">ID Pedido</label>';
                    echo '<input value="'.$_SESSION['cd_pedido'].'" type="tel" name="btncd_pedido" id="btncd_pedido" class="aspNetDisabled form-control form-control-sm" readonly>';
                    
                    echo '<label for="btnobs_servico">Descrição Geral</label>';
                    echo '<input value="'.$_SESSION['obs_con_pedido'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="Caracteristica geral do serviço" readonly>';
                    
                    
                    //echo '<td><button type="submit" name="con_edit_os" id="con_edit_os" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Editar</button></td>';
                    echo '</form>';
                    echo '</div>';
                    echo '<script>document.getElementById("btncd_servico").value = "'.$_SESSION['cd_pedido'].'"</script>';
                    echo '<script>document.getElementById("btnobs_servico").value = "'.$_SESSION['obs_con_pedido'].'"</script>';
                    
                    
                    
                    
                            
                    
                    
                    

                  
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '<form action="impresso.php" method="POST" target="_blank" >';
                    echo '<div style="display:none; ">';
                    //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                    echo '<input value="'.$_SESSION['cd_pessoa_pedido'].'" name="btncd_cliente" type="text" id="showcd_cliente" style="display: none;"/>';
                    //echo '<label for="btnpnome_cliente">Nome</label>';
                    echo '<input value="'.$_SESSION['pnome_pessoa_pedido'].'" name="btnpnome_pessoa_pedido" type="text" id="btnpnome_pessoa_pedido" maxlength="40" readonly/>';
                    //echo '<label for="btnsnome_cliente">sobrenome</label>';
                    echo '<input value="'.$_SESSION['snome_pessoa_pedido'].'" name="btnsnome_pessoa_pedido" type="text" id="btnsnome_pessoa_pedido" maxlength="40" readonly/>';
                    //echo '<label for="btntel_cliente">Telefone</label>';
                    echo '<input value="'.$_SESSION['tel_pessoa_pedido'].'" name="btntel_pessoa_pedido" type="tel"  id="btntel_pessoa_pedido" oninput="tel(this)" readonly/>';
                    echo '<script>document.getElementById("showcd_cliente").value = "'.$_SESSION['cd_pessoa_pedido'].'"</script>';
                    echo '<script>document.getElementById("btnpnome_cliente").value = "'.$_SESSION['pnome_pessoa_pedido'].'"</script>';
                    echo '<script>document.getElementById("btnsnome_cliente").value = "'.$_SESSION['snome_pessoa_pedido'].'"</script>';
                    echo '<script>document.getElementById("btntel_cliente").value = "'.$_SESSION['tel_pessoa_pedido'].'"</script>';

                    //echo '<label for="btncd_servico">OS</label>';
                    echo '<input value="'.$_SESSION['cd_pedido'].'" type="tel" name="btncd_pedido" id="btncd_pedido" readonly>';
                    //echo '<label for="btnobs_servico">Descrição Geral</label>';
                    echo '<input value="'.$_SESSION['obs_con_pedido'].'" type="text" name="btnobs_pedido" maxlength="999" id="btnobs_pedido" placeholder="Caracteristica geral do Pedido" readonly>';
                    //echo '<label for="btnprioridade_servico">Prioridade</label>';
                    
                    echo '<script>document.getElementById("btncd_pedido").value = "'.$_SESSION['cd_pedido'].'"</script>';
                    echo '<script>document.getElementById("btnobs_pedido").value = "'.$_SESSION['obs_con_pedido'].'"</script>';
                    
                    echo '</div>';

                    
                    //echo '<button type="submit" name="lancarOrcamento" class="btn btn-success">LançarOrcamento</button>';
                    echo '<button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente <i class="mdi mdi-whatsapp"></i></button>';
                    //echo '<button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarPosicaoMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Localização<i class="mdi mdi-whatsapp"></i></button>';
                    //echo '<button type="submit" class="btn btn-danger" name="limparOS-" style="margin: 5px;">Nova Consulta</button>';     
                    echo '</form>';
                    echo '<form method="post">';//echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Nova Consulta</button>';
                    //echo '<button type="submit" class="btn btn-block btn-lg btn-warning" name="editaOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-file-check btn-icon-append"></i> Editar</button>';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparPedido" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-reload btn-icon-prepend"></i> Nova Consulta</button>';
                    //<i class="mdi mdi-alert btn-icon-prepend"></i>  
                    echo '</form>';


                  }
                }




                  
                ?>
                <script>
                          function enviarMensagemWhatsApp() {
                            // Obter os valores dos campos do formulário
                            var nomeCliente = document.getElementById("btnpnome_pessoa_pedido").value;
                            var telefoneCliente = document.getElementById("btntel_pessoa_pedido").value;
                            var numeroOP = document.getElementById("btncd_pedido").value;

                            var observacoesServico = document.getElementById("btnobs_pedido").value;

                            // Montar a data organizada
                            // Construir a mensagem com todos os dados do formulário
                            var mensagem = "Olá, _" + nomeCliente + "_ !\n";
                            mensagem += "Sou _<?php echo $_SESSION['pnome_pessoa'].' '.$_SESSION['snome_pessoa'];?>_ ,  e fui designado a te ajudar.\n\n";
                            
                            mensagem += "_Porque somos criação de Deus realizada em Cristo Jesus para fazermos boas obras, as quais Deus preparou antes para nós as praticarmos._ \n*Efésios 2:10*\n\n";//$_SESSION['endereco_filial']
                            mensagem += "\n__________________________________\n";
                            mensagem += "```AtiviSoft © | Release: B E T A```";//$_SESSION['endereco_filial']
                            mensagem += "\n__________________________________\n";
                            // Codificar a mensagem para uso na URL
                            var mensagemCodificada = encodeURIComponent(mensagem);
                            // Construir a URL do WhatsApp
                            var urlWhatsApp = "https://api.whatsapp.com/send?phone=" + telefoneCliente + "&text=" + mensagemCodificada;
                            // Abrir a janela do WhatsApp com a mensagem preenchida
                            window.open(urlWhatsApp, "_blank");
                          }



                          

                </script>
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