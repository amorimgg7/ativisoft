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
  <title>Cadastro de cliente</title>
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
        <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card" <?php $_SESSION['c_card'];?>>
                <div class="card-body" id="consulta" <?php echo $_SESSION['c_card'];?> style="display: block;" >
                  <h3 class="card-title"<?php echo $_SESSION['c_card'];?>>Consultar pelo CNPJ</h3>
                  <p class="card-description"<?php echo $_SESSION['c_card'];?>>Consulte o cliente comercial pelo cnpj.</p>
                  <div class="kt-portlet__body" >
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        <form method="POST">
                          
                          <input placeholder="CNPJ Cliente Comercial" type="tel" name="concnpj_cliente_comercial" id="concnpj_cliente_comercial" type="tel" maxlength="40" class="aspNetDisabled form-control form-control-sm" required>
                          <br>
                          <button type="submit" name="consulta" class="btn btn-success">Consulta</button>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php
                  if(isset($_POST['limparDados'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    session_start();
                    $_SESSION['editcd_cliente_comercial'] =                 0;
                    $_SESSION['editcnpj_cliente_comercial'] =               0;
                    $_SESSION['editrsocial_cliente_comercial'] =            0;
                    $_SESSION['editnfantasia_cliente_comercial'] =          0;
                    $_SESSION['editdtcadastro_cliente_comercial'] =         0;
                    $_SESSION['editdtvalidlicenca_cliente_comercial'] =     0;
                    $_SESSION['editobs_cliente_comercial'] =                0;
                    $_SESSION['edittel_cliente_comercial'] =                0;
                    $_SESSION['editobs_tel_cliente_comercial'] =            0;
                    $_SESSION['editemail_cliente_comercial'] =              0;
                    $_SESSION['editfatura_prevista_cliente_fiscal'] =       0;
                    $_SESSION['editfatura_devida_cliente_fiscal'] =         0;
                    $_SESSION['editsenha_cliente_comercial'] =              0;
                    
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                    
                    
                }
                ?>
                
                <?php
                  $select_cliente_comercial = "SELECT * FROM tb_cliente_comercial WHERE cnpj_cliente_comercial = '".$_POST['concnpj_cliente_comercial']."'";
                  $result_cliente_comercial = mysqli_query($conn, $select_cliente_comercial);
                  $row_cliente_comercial = mysqli_fetch_assoc($result_cliente_comercial);
                  // Exibe as informações do usuário no formulário
                  if($row_cliente_comercial) {
                    echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                  
                    echo '<div class="card-body" id="abrirOS2" '.$_SESSION['c_card'].'><!--FORMULÁRIO PARA CRIAR OS-->';
                    echo '<div class="kt-portlet__body">';
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-12">';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                    
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" '.$_SESSION['c_card'].' style="display:block;">';
                    echo '<form method="POST" action="cadastrar_cliente_comercial.php">';
                    echo '<input value="'.$row_cliente_comercial['cd_cliente_comercial'].'" name="showcd_cliente_comercial" type="text" id="showcd_cliente_comercial" class="aspNetDisabled form-control form-control-sm" style="display: block;" readonly/>';
                    echo '<label for="showrsocial_cliente_comercial">Razão Social</label>';
                    echo '<input value="'.$row_cliente_comercial['rsocial_cliente_comercial'].'" name="showrsocial_cliente_comercial" type="text" id="showrsocial_cliente_comercial" maxlength="100"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="shownfantasia_cliente_comercial">Nome Fantasia</label>';
                    echo '<input value="'.$row_cliente_comercial['nfantasia_cliente_comercial'].'" name="shownfantasia_cliente_comercial" type="text" id="shownfantasia_cliente_comercial" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="showcnpj_cliente_comercial">CNPJ</label>';
                    echo '<input value="'.$row_cliente_comercial['cnpj_cliente_comercial'].'" name="concnpj_cliente_comercial" type="tel" id="concnpj_cliente_comercial" maxlength="90"   class="aspNetDisabled form-control form-control-sm" readonly/>';          
                    echo '<label for="btntel_cliente">Data do Cadastro</label>';
                    echo '<input value="'.$row_cliente_comercial['dtcadastro_cliente_comercial'].'" name="showdtcadastro_cliente_comercial" type="tel"  id="showdtcadastro_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">Data do Vencimento</label>';
                    echo '<input value="'.$row_cliente_comercial['dtvalidlicenca_cliente_comercial'].'" name="showdtvalidlicenca_cliente_comercial" type="tel"  id="showdtvalidlicenca_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">Obs Cliente _ Status.</label>';
                    echo '<input value="'.$row_cliente_comercial['obs_cliente_comercial'].'" name="showobs_cliente_comercial" type="tel"  id="showobs_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">Telefone Filial</label>';
                    echo '<input value="'.$row_cliente_comercial['tel_cliente_comercial'].'" name="showtel_cliente_comercial" type="tel"  id="showtel_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">Email Filial</label>';
                    echo '<input value="'.$row_cliente_comercial['email_cliente_comercial'].'" name="showemail_cliente_comercial" type="tel"  id="showemail_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">Observações dos contatos</label>';
                    echo '<input value="'.$row_cliente_comercial['obs_tel_cliente_comercial'].'" name="showobs_tel_cliente_comercial" type="tel"  id="showobs_tel_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">Fatura Prevista</label>';
                    echo '<input value="'.$row_cliente_comercial['fatura_prevista_cliente_fiscal'].'" name="showfatura_prevista_cliente_fiscal" type="tel"  id="showfatura_prevista_cliente_fiscal" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">Fatura Devida</label>';
                    echo '<input value="'.$row_cliente_comercial['fatura_devida_cliente_fiscal'].'" name="showfatura_devida_cliente_fiscal" type="tel"  id="showfatura_devida_cliente_fiscal" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    
                    echo '<td><button type="submit" name="#" id="#" class="btn btn-block btn-outline-warning"><i class="icon-cog">Editar</i></button></td>';
                    echo '</form>';
                    echo '</div>';
                    

                    
                    
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '</div>';
                    echo '</div>';

                      
                    

                    


                    echo '<!--';
                    echo '<form action="impresso.php" method="POST" target="_blank" '.$_SESSION['c_card'].'>';
                    echo '<div style="display:none; '.$_SESSION['c_card'].'">';
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
                    echo '<input value="'.$_SESSION['obs_con_servico'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico" placeholder="Caracteristica geral do serviço" readonly>';
                    //echo '<label for="btnprioridade_servico">Prioridade</label>';
                    echo '<select name="btnprioridade_servico" id="btnprioridade_servico">';
                    echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >'.$_SESSION['prioridade_servico'].'</option>';
                    echo '</select>';
                    //echo '<!--<label for="btnprazo_servico">Entrada</label>-->';
                    echo '<input value="'.$_SESSION['entrada_servico'].'" name="btnentrada_servico" type="datetime-local" id="btnentrada_servico" readonly/>';
                    //echo '<label for="btnprazo_servico">Prazo</label>';
                    echo '<input value="'.$_SESSION['prazo_servico'].'" name="btnprazo_servico" type="datetime-local" id="btnprazo_servico" readonly/>';
                    
                    
                    echo '<script>document.getElementById("btncd_servico").value = "'.$_SESSION['cd_servico'].'"</script>';
                    echo '<script>document.getElementById("btnobs_servico").value = "'.$_SESSION['obs_con_servico'].'"</script>';
                    echo '<script>document.getElementById("btnprioridade_servico").value = "'.$_SESSION['prioridade_servico'].'"</script>';
                    echo '<script>document.getElementById("btnentrada_servico").value = "'.$_SESSION['entrada_servico'].'"</script>';
                    echo '<script>document.getElementById("btnprazo_servico").value = "'.$_SESSION['prazo_servico'].'"</script>';

                    //echo '<label for="showobs_servico">Total</label>';
                    ////echo '<input value="'.$_SESSION['vtotal_orcamento'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" readonly>';
                    //echo '<label for="showobs_servico">Pago</label>';
                    echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" readonly>';
                    

                    
                    
                    echo '</div>';

                    
                    //echo '<button type="submit" name="lancarOrcamento" class="btn btn-success">LançarOrcamento</button>';
                    echo '<button type="submit" name="imprimir_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">OS <i class="mdi mdi-printer btn-icon-append"></i></button>';
                    echo '<button type="submit" name="historico_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Histórico <i class="mdi mdi-printer btn-icon-append"></i></button>';
                    echo '<button type="submit" name="via_cliente" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente <i class="mdi mdi-printer btn-icon-append"></i></button>';
                    echo '<button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente <i class="mdi mdi-whatsapp"></i></button>';
                    //echo '<button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarPosicaoMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Localização<i class="mdi mdi-whatsapp"></i></button>';
                    //echo '<button type="submit" class="btn btn-danger" name="limparDados-" style="margin: 5px;">Nova Consulta</button>';     
                    echo '</form>';
                    echo '-->';
                    echo '<form method="post"'.$_SESSION['c_card'].'>';//echo '<button type="submit" class="btn btn-danger" name="limparDados" style="margin: 5px;">Nova Consulta</button>';
                    //echo '<button type="submit" class="btn btn-block btn-lg btn-warning" name="editaOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-file-check btn-icon-append"></i> Editar</button>';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparDados" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-reload btn-icon-prepend"></i> Nova Consulta</button>';
                    //<i class="mdi mdi-alert btn-icon-prepend"></i>  
                    echo '</form>';


                  }

                  if(isset($_POST['lancarPagamento'])) {
                    $updateVpagServico = "UPDATE tb_servico SET
                    vpag_servico = ".$_POST['btnvpag_orcamento']."
                    WHERE cd_servico = ".$_SESSION['cd_servico']."";
                    mysqli_query($conn, $updateVpagServico);
                    $_SESSION['vpag_servico'] = $_POST['btnvpag_orcamento'];
                    echo  '<script>document.getElementById("btnvpag_orcamento").value = "'.$_POST['btnvpag_orcamento'].'";</script>';
                    header("location: consulta_servico.php");
                  }


                  
                ?>
                <?php
                  if(isset($_POST['lancarPagamento'])) {
                    $updateVpagServico = "UPDATE tb_servico SET
                    vpag_servico = ".$_POST['btnvpag_orcamento']."
                    WHERE cd_servico = ".$_SESSION['cd_servico']."";
                    mysqli_query($conn, $updateVpagServico);
                    $_SESSION['vpag_servico'] = $_POST['btnvpag_orcamento'];
                    echo  '<script>document.getElementById("btnvpag_orcamento").value = "'.$_POST['btnvpag_orcamento'].'";</script>';
                    header("location: consulta_servico.php");
                  }

                  if(isset($_POST['pagar_servico'])){
                    $insert_pagar_servico = "INSERT INTO tb_movimento_financeiro(tipo_movimento, cd_caixa_movimento, cd_cliente_movimento, cd_colab_movimento, cd_os_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES(
                        1,
                        '".$_SESSION['cd_caixa']."',
                        '".$_SESSION['cd_cliente']."',
                        '".$_SESSION['cd_colab']."',
                        '".$_SESSION['cd_servico']."',
                        '".$_POST['fpag_movimento']."',
                        '".$_POST['vpag_movimento']."',
                        '".date('Y-m-d H:i', strtotime('+1 hour'))."',
                        'PAGAMENTO DA OS: ".$_SESSION['cd_servico']."'
                         )
                     ";
                    mysqli_query($conn, $insert_pagar_servico);
                    //echo "<script>window.alert('Movimento Financeiro Lançado!');</script>";
                    
        
                    $fechar_caixa = "UPDATE tb_servico SET
                        vpag_servico = '".($_POST['vpag_movimento'] + $_SESSION['vpag_servico'])."'
                        WHERE cd_servico = ".$_SESSION['cd_servico']."";
                        mysqli_query($conn, $fechar_caixa);
                        //echo "<script>window.alert('Pagamento do Serviço Lançado!');</script>";
                        $_SESSION['vpag_servico'] = $_POST['vpag_movimento'] + $_SESSION['vpag_servico'];
                        $_SESSION['falta_pagar_servico'] = $_SESSION['vtotal_orcamento'] - $_SESSION['vpag_servico'];
                        //echo  '<script>document.getElementById("btn_falta_pagar_orcamento").value = "'.$_SESSION['falta_pagar_servico'].'";</script>';
        
                        if($_SESSION['falta_pagar_servico'] == 0){
                            echo '<script>document.getElementById("tela_pagamento").style.display = "none";</script>';//tela_pagamento
                        }
                        //$_SESSION['cd_servico'] = 0;
                        //$_SESSION['cd_servico'] = 0;
                        //$_SESSION['cd_cliente'] = 0;
                        //echo '<script>location.href="../../index.php";</script>';
                }


                ?>
                <?php
                  




                  
                ?>
                <script>
                          function enviarMensagemWhatsApp() {
                            // Obter os valores dos campos do formulário
                            var nomeCliente = document.getElementById("btnpnome_cliente").value;
                            var telefoneCliente = document.getElementById("btntel_cliente").value;
                            var numeroOS = document.getElementById("btncd_servico").value;
                            var entradaServico = document.getElementById("btnentrada_servico").value;

                            var observacoesServico = document.getElementById("btnobs_servico").value;
                            var prioridadeServico = document.getElementById("btnprioridade_servico").value;
                            var prazoServico = document.getElementById("btnprazo_servico").value;

                            var vtotalServico = document.getElementById("btnvtotal_orcamento").value;
                            var vpagServico = document.getElementById("btnvpag_orcamento").value;


                            var anoEntrada = entradaServico.substring(0, 4);
                            var mesEntrada = entradaServico.substring(5, 7);
                            var diaEntrada = entradaServico.substring(8, 10);
                            var horaEntrada = entradaServico.substring(11, 13);
                            var minutoEntrada = entradaServico.substring(14, 16);

                            var anoPrazo = prazoServico.substring(0, 4);
                            var mesPrazo = prazoServico.substring(5, 7);
                            var diaPrazo = prazoServico.substring(8, 10);
                            var horaPrazo = prazoServico.substring(11, 13);
                            var minutoPrazo = prazoServico.substring(14, 16)

                            // Montar a data organizada
                            var entradaOrganizada = diaEntrada + "/" + mesEntrada + "/" + anoEntrada + " às " + horaEntrada + ":" + minutoEntrada;
                            var prazoOrganizado = diaPrazo + "/" + mesPrazo + "/" + anoPrazo + " às " + horaPrazo + ":" + minutoPrazo;
                            if(prioridadeServico == "U"){
                              prioridadeOrganizada = "Urgente";
                            }
                            if(prioridadeServico == "A"){
                              prioridadeOrganizada = "Alta";
                            }
                            if(prioridadeServico == "M"){
                              prioridadeOrganizada = "Média";
                            }
                            if(prioridadeServico == "B"){
                              prioridadeOrganizada = "Baixa";
                            }
                            faltaPagar = vtotalServico - vpagServico;
                              // Construir a mensagem com todos os dados do formulário
                            var mensagem = "*Olá, " + nomeCliente + "!*\n";
                            mensagem += "Sou *<?php echo $_SESSION['pnome_colab'].' '.$_SESSION['snome_colab'];?>* , da empresa *<?php echo $_SESSION['nfantasia_filial'];?>* e fico no endereço *<?php echo $_SESSION['endereco_filial'];?>*.\n\n";
                            
                            mensagem += "Sua ordem de serviço de número *OS" + numeroOS + "*, deu entrada em nossa loja *" + entradaOrganizada + "*.\n";
                            mensagem += "Descrição da atividade: " + observacoesServico + "\n";
                            //mensagem += "Prioridade Requerida: *" + prioridadeOrganizada + "*\n";//Marcia pediu para tirar
                            mensagem += "O prazo previsto para entrega é: *" + prazoOrganizado + "*\n\n";
                            <?php
                              $select_orcamento_whatsapp = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['cd_servico']."' ORDER BY cd_orcamento ASC";
                              $result_orcamento_whatsapp = mysqli_query($conn, $select_orcamento_whatsapp);
                              echo 'mensagem += "*Lista detalhada*\n";';
                              while($row_orcamento_whatsapp = $result_orcamento_whatsapp->fetch_assoc()) {
                                $counter = $counter + 1;
                                //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
                                ?>mensagem += "<?php echo '*'.$counter.'* - '.$row_orcamento_whatsapp['titulo_orcamento'].' - R$:'.$row_orcamento_whatsapp['vcusto_orcamento']; ?>\n";<?php
                              }
                              echo 'mensagem += "\n";';
                            ?>
                            mensagem += "Total: *R$:" + vtotalServico + "*\n";
                            mensagem += "Valor pago: R$:*" + vpagServico + "*\n";
                            mensagem += "Falta pagar: R$:*" + faltaPagar + "*\n\n";

                            mensagem += "\n__________________________________\n";
                            <?php
                              echo 'mensagem += "Acompanhe seu histórico pelo link:'.$_SESSION['dominio'].'pages/md_assistencia/acompanha_servico.php?cnpj='.$_SESSION['cnpj_empresa'].'&tel=" + telefoneCliente + "\n";';
                            ?>
                            mensagem += "\n__________________________________\n";


                            mensagem += "OBS: *_<?php echo $_SESSION['saudacoes_filial'];?>_*\n\n";//$_SESSION['endereco_filial']
                            mensagem += "```NuvemSoft © | Release: B E T A```";//$_SESSION['endereco_filial']
                            // Codificar a mensagem para uso na URL
                            var mensagemCodificada = encodeURIComponent(mensagem);
                            // Construir a URL do WhatsApp
                            var urlWhatsApp = "https://api.whatsapp.com/send?phone=" + telefoneCliente + "&text=" + mensagemCodificada;
                            // Abrir a janela do WhatsApp com a mensagem preenchida
                            window.open(urlWhatsApp, "_blank");
                          }



                          

                </script>
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
                <?php






                  //$sql_atividade = "SELECT * FROM tb_atividade WHERE cd_servico = '".$_SESSION['cd_servico']."' ORDER BY cd_atividade ASC";
                  //$sql_atividade = "SELECT * FROM (
                  //  SELECT * FROM tb_atividade 
                  //  WHERE cd_servico = '".$_SESSION['cd_servico']."' 
                  //  ORDER BY cd_atividade ASC
                  //) as temp_table 
                  //WHERE temp_table.rownum < (SELECT COUNT(*) FROM tb_atividade WHERE cd_servico = '".$_SESSION['cd_servico']."')";


                  //Um exemplo alternativo usando MySQL é usar variáveis de usuário para emular a função ROW_NUMBER():
                  //Isso atribuirá um número de linha a cada linha na tabela tb_atividade e a consulta principal então selecionará todas as linhas exceto a última.
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