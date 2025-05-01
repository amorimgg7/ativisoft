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
                  <h3 class="card-title"<?php echo $_SESSION['c_card'];?>>Consultar Carrinho</h3>
                  <p class="card-description"<?php echo $_SESSION['c_card'];?>>Consulte o Carrinho pelo Código do seu cliente.</p>
                  <div class="kt-portlet__body" >
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        <form method="POST">
                          
                          <input placeholder="Código do Cliente" type="tel" name="concd_cliente_carrinho" id="concd_cliente_carrinho" type="tel" maxlength="10" class="aspNetDisabled form-control form-control-sm" required>
                          <br>
                          <button type="submit" name="consulta" class="btn btn-success">Consulta</button>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php
                  if(isset($_POST['limpaTELA'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    //session_start();
                    $_SESSION['cd_cliente_carrinho'] = 0;
                    $_SESSION['cd_cliente'] = 0;
                    $_SESSION['vtotal_orcamento'] = 0;
                    $_SESSION['vpag_servico'] = 0;
                    
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                    
                    
                }
                ?>
                
                <?php
                  if(isset($_POST['concd_cliente_carrinho'])){
                    $select_cliente = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$_POST['concd_cliente_carrinho']."'";
                    $result_cliente = mysqli_query($conn, $select_cliente);
                    $row_cliente = mysqli_fetch_assoc($result_cliente);
                    if($row_cliente) {
                      $_SESSION['cd_cliente'] = $row_cliente['cd_cliente'];
                      $_SESSION['pnome_cliente'] = $row_cliente['pnome_cliente'];
                      $_SESSION['snome_cliente'] = $row_cliente['snome_cliente'];
                      $_SESSION['cpf_cliente'] = $row_cliente['cpf_cliente'];
                      $_SESSION['tel_cliente'] = $row_cliente['tel_cliente'];                
                      $_SESSION['email_cliente'] = $row_cliente['email_cliente'];                
                    }
                  }
                ?>

                <?php
                  if($_SESSION['cd_cliente'] > 0){

                    echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                  
                    echo '<div class="card-body" id="abrirOS2" '.$_SESSION['c_card'].'><!--FORMULÁRIO PARA CRIAR OS-->';
                    echo '<div class="kt-portlet__body">';
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-12">';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                    
                    //echo '<form method="POST">';
                    
                    //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" '.$_SESSION['c_card'].' style="display:block;">';
                    echo '<form method="POST" action="../cad_geral/consulta_cliente.php">';
                    echo '<input value="'.$_SESSION['cd_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                    echo '<label for="btnpnome_cliente">Nome</label>';
                    echo '<input value="'.$_SESSION['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btnsnome_cliente">sobrenome</label>';
                    echo '<input value="'.$_SESSION['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">CPF</label>';
                    echo '<input value="'.$_SESSION['cpf_cliente'].'" name="btncpf_cliente" type="tel"  id="btncpf_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">Telefone</label>';
                    echo '<input value="'.$_SESSION['tel_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">Email</label>';
                    echo '<input value="'.$_SESSION['email_cliente'].'" name="btnemail_cliente" type="email" id="btnemail_cliente" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<td><button type="submit" name="con_cliente" id="con_cliente" class="btn btn-block btn-outline-warning"><i class="icon-cog">Editar</i></button></td>';
                    echo '</form>';
                    echo '</div>';
                    echo '<script>document.getElementById("showcd_cliente").value = "'.$_SESSION['cd_cliente'].'"</script>';
                    echo '<script>document.getElementById("btnpnome_cliente").value = "'.$_SESSION['pnome_cliente'].'"</script>';
                    echo '<script>document.getElementById("btnsnome_cliente").value = "'.$_SESSION['snome_cliente'].'"</script>';
                    echo '<script>document.getElementById("btntel_cliente").value = "'.$_SESSION['tel_cliente'].'"</script>';


                    $sql_loja_virtual = "SELECT SUM(ca.qtd_prod_serv_carrinho) AS qtde_total, SUM(ps.preco_prod_serv) AS valor_total, MIN(ca.dt_add_carrinho) AS primeira_data, MAX(ca.dt_add_carrinho) AS ultima_data " .
                      "FROM tb_carrinho ca " .
                      "JOIN tb_cliente cl ON ca.cd_cliente_carrinho = cl.cd_cliente ".
                      "JOIN tb_prod_serv ps ON ca.cd_prod_serv_carrinho = ps.cd_prod_serv " .
                      "WHERE status_carrinho = 1 " .
                      "GROUP BY ca.cd_cliente_carrinho " .
                      "ORDER BY cd_cliente_carrinho ASC; ";

                    $resulta_loja_virtual = $conn->query($sql_loja_virtual);
                    if ($resulta_loja_virtual->num_rows > 0){
                      

                      while ( $loja_virtual = $resulta_loja_virtual->fetch_assoc()){
                        //echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                        echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" '.$_SESSION['c_card'].' style="display: block;">';
                        
                        echo '<form method="POST" action="../cad_geral/consulta_carrinho.php">';
                        echo '<label for="btncd_servico">Quantidade</label>';
                        echo '<input value="'.$loja_virtual['qtde_total'].'" type="tel" class="aspNetDisabled form-control form-control-sm" readonly>';
                        
                        echo '<label for="btnobs_servico">Valor</label>';
                        echo '<input value="'.$loja_virtual['valor_total'].'" type="tel" class="aspNetDisabled form-control form-control-sm" readonly>';
                        
                        echo '<label for="btnobs_servico">Inicio</label>';
                        echo '<input value="'.date('Y-m-d', strtotime($loja_virtual['primeira_data'])).'" type="date" class="aspNetDisabled form-control form-control-sm" readonly>';
                        
                        echo '<label for="btnobs_servico">Fim</label>';
                        echo '<input value="'.date('Y-m-d', strtotime($loja_virtual['ultima_data'])).'" type="date" class="aspNetDisabled form-control form-control-sm" readonly>';
                        echo '<td><button type="submit" name="con_cliente" id="con_cliente" class="btn btn-block btn-outline-warning"><i class="icon-cog">Editar</i></button></td>';
                        echo '</form>';
                        echo '</div>';
                      }
                    }
                    //$select_carrinho = "SELECT * FROM tb_carrinho WHERE cd_cliente_carrinho = '".$_SESSION['cd_cliente']."' ORDER BY dt_add_carrinho DESC";
                    $select_carrinho = "SELECT ps.cd_prod_serv, ps.titulo_prod_serv, ps.preco_prod_serv, sum(c.qtd_prod_serv_carrinho) as qtd_total, sum(ps.preco_prod_serv) as valor_total FROM tb_carrinho c, tb_prod_serv ps WHERE cd_cliente_carrinho = '".$_SESSION['cd_cliente']."' and ps.cd_prod_serv = c.cd_prod_serv_carrinho GROUP BY ps.titulo_prod_serv ORDER BY c.qtd_prod_serv_carrinho DESC";
                    //SELECT ps.titulo_prod_serv, c.qtd_prod_serv_carrinho, sum(ps.preco_prod_serv) as valor_total FROM tb_carrinho c, tb_prod_serv ps WHERE cd_cliente_carrinho = 3 and ps.cd_prod_serv = c.cd_prod_serv_carrinho GROUP BY ps.titulo_prod_serv ORDER BY c.qtd_prod_serv_carrinho DESC
                    $result_carrinho = mysqli_query($conn, $select_carrinho);
                    
                    // Exibe as informações do usuário no formulário
                    echo '<style>';
                    echo '.horizontal-form {';
                    echo 'display: table;';
                    echo 'width: 100%;';
                    echo '}';
                    echo '.form-group {';
                    echo 'display: table-row;';
                    echo '}';

                    echo '.form-group label,';
                    echo '.form-group input {';
                    echo 'display: table-cell;';
                    echo 'padding: 5px;';
                    echo '}';
                    echo '</style>';
                    echo '';
                    echo '<h3 class="kt-portlet__head-title">Produtos DFDFDF adicionados</h3>';
                    
                    $count = 0;
                    $_SESSION['falta_pagar_carrinho'] = 0;
                    $_SESSION['vtotal_carrinho'] = 0;
                    $_SESSION['vpag_carrinho'] = 0;

                    while($row_carrinho = $result_carrinho->fetch_assoc()) {
                      echo '<div name="listaOrcamento" id="listaOrcamento" class="typeahead" '.$_SESSION['c_card'].'>';
                      echo '<div class="horizontal-form">';
                      echo '<div class="form-group">';
                      $count = $count + 1;
                      echo '<input value="'.$row_carrinho['cd_prod_serv'].'" name="listaid_orcamento" id="listaid_orcamento" class="aspNetDisabled form-control form-control-sm" style="display:none;">';
                      echo '<label for="listatitulo_orcamento">#'.$count.'</label>';
                      echo '<input value="'.$row_carrinho['titulo_prod_serv'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
                      echo '<label for="listavalor_orcamento">Preço</label>';
                      echo '<input value="'.$row_carrinho['preco_prod_serv'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
                      echo '<label for="listavalor_orcamento">QTD</label>';
                      echo '<input value="'.$row_carrinho['qtd_total'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
                      echo '<label for="listavalor_orcamento">Total</label>';
                      echo '<input value="'.$row_carrinho['valor_total'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      $_SESSION['falta_pagar_carrinho'] += $row_carrinho['valor_total'];
                    } 
                    $_SESSION['falta_pagar_carrinho'] = $_SESSION['vtotal_carrinho'] - $_SESSION['vpag_carrinho'];
                    echo '<div class="typeahead" '.$_SESSION['c_body'].'">';
                    echo '<div class="horizontal-form"'.$_SESSION['c_card'].'>';
                    echo '<div class="form-group"'.$_SESSION['c_card'].'>';
                    
                    
                    if($_SESSION['vpag_carrinho'] == $_SESSION['vtotal_carrinho']){
                      echo '<label for="showobs_servico">Total Pago:</label>';
                      echo '<input value="'.$_SESSION['vpag_carrinho'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                    }else{
                      $_SESSION['falta_pagar_carrinho'] = $_SESSION['vtotal_carrinho'] - $_SESSION['vpag_carrinho'];
                      echo '<label for="showobs_servico">Total:</label>';
                      echo '<input value="'.$_SESSION['vtotal_carrinho'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                      echo '<label for="showobs_servico">Pago:</label>';
                      echo '<input value="'.$_SESSION['vpag_carrinho'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                      echo '<label for="showobs_servico">Falta:</label>';
                      echo '<input value="'.$_SESSION['falta_pagar_carrinho'].'" type="tel" name="btn_falta_pagar_orcamento" id="btn_falta_pagar_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                      //echo '<label for="lancarPagamento"></label>';
                      //echo '<input type="submit" name="lancarPagamento" id="lancarPagamento" class="btn btn-success"">';
                    }
                    //echo '</form>';
                    


                    //echo '<label for="lancarPagamento"></label>';
                    //echo '<input type="submit" name="lancarPagamento" id="lancarPagamento" class="btn btn-success"">';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    $_SESSION['tela_movimento_financeiro'] = "VENDA_PRODUTO";
                    //echo '<div class="col-12 grid-margin stretch-card btn-success">';//
                    //echo '<div class="card">';
                    //echo '<div class="card-body">';
                    include("../md_caixa/movimento_financeiro.php");
                    //echo '</div>';
                    //echo '</div>';
                    //echo '</div>';
                    echo '<form action="impresso.php" method="POST" target="_blank" '.$_SESSION['c_card'].'>';
                    echo '<div style="display: none;" '.$_SESSION['c_card'].'">';
                    echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                    echo '<label for="btncd_cliente">cd</label>';
                    echo '<input value="'.$_SESSION['cd_cliente'].'" name="btncd_cliente" type="text" id="btncd_cliente" style="display: block;"/>';
                    echo '<label for="btnpnome_cliente">Nome</label>';
                    echo '<input value="'.$_SESSION['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40" readonly/>';
                    echo '<label for="btnsnome_cliente">sobrenome</label>';
                    echo '<input value="'.$_SESSION['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40" readonly/>';
                    echo '<label for="btntel_cliente">Telefone</label>';
                    echo '<input value="'.$_SESSION['tel_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" readonly/>';
                    echo '<script>document.getElementById("btncd_cliente").value = "'.$_SESSION['cd_cliente'].'"</script>';
                    echo '<script>document.getElementById("btnpnome_cliente").value = "'.$_SESSION['pnome_cliente'].'"</script>';
                    echo '<script>document.getElementById("btnsnome_cliente").value = "'.$_SESSION['snome_cliente'].'"</script>';
                    echo '<script>document.getElementById("btntel_cliente").value = "'.$_SESSION['tel_cliente'].'"</script>';

                    //echo '<label for="showobs_servico">Total</label>';
                    echo '<input value="'.$_SESSION['vtotal_orcamento'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" readonly>';
                    //echo '<label for="showobs_servico">Pago</label>';
                    echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" readonly>';
                    
                    echo '<script>document.getElementById("btnvtotal_orcamento").value = "'.$_SESSION['vtotal_orcamento'].'"</script>';
                    echo '<script>document.getElementById("btnvpag_orcamento").value = "'.$_SESSION['vpag_servico'].'"</script>';
                    echo '</div>';

                    echo '<button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Lembrete de Carrinho <i class="mdi mdi-whatsapp"></i></button>';
                    echo '</form>';
                    echo '<form method="post"'.$_SESSION['c_card'].'>';//echo '<button type="submit" class="btn btn-danger" name="limpaTELA" style="margin: 5px;">Nova Consulta</button>';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limpaTELA" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-reload btn-icon-prepend"></i> Nova Consulta</button>';
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
                <script>
                          function enviarMensagemWhatsApp() {
                            // Obter os valores dos campos do formulário
                            var cdCliente = document.getElementById("btncd_cliente").value;
                            var pnomeCliente = document.getElementById("btnpnome_cliente").value;
                            var snomeCliente = document.getElementById("btnsnome_cliente").value;
                            var telefoneCliente = document.getElementById("btntel_cliente").value;

                            //faltaPagar = vtotalServico - vpagServico;
                              // Construir a mensagem com todos os dados do formulário
                            var mensagem = "*Olá, " + pnomeCliente + "!*\n";
                            mensagem += "Sou *<?php echo $_SESSION['pnome_colab'].' '.$_SESSION['snome_colab'];?>*.\n\n";
                            
                            mensagem += "Notei que voce se interessou em nussos produtos e estou entrando em contato com voce para saber como posso te ajudar a ter uma melhor experiência em nossa loja virtual.\n";
                            mensagem += "Confira já seu carrinho em <?php echo $_SESSION['dominio'].'pages/web/index.php?cnpj='.$_SESSION['cnpj_empresa'].'&tel='.$_SESSION['tel_cliente'].'&carrinho=true'; ?>.\n";
                            //mensagem += "Confira já seu carrinho em " + <?php //echo 'https://';?> + ".\n";
                            <?php
                              $select_carrinho_whatsapp = "SELECT ps.cd_prod_serv, ps.titulo_prod_serv, ps.preco_prod_serv, sum(c.qtd_prod_serv_carrinho) as qtd_total, sum(ps.preco_prod_serv) as valor_total FROM tb_carrinho c, tb_prod_serv ps WHERE cd_cliente_carrinho = '".$_SESSION['cd_cliente']."' and ps.cd_prod_serv = c.cd_prod_serv_carrinho GROUP BY ps.titulo_prod_serv ORDER BY c.qtd_prod_serv_carrinho DESC";
                              //$select_carrinho_whatsapp = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['cd_servico']."' ORDER BY cd_orcamento ASC";
                              $result_carrinho_whatsapp = mysqli_query($conn, $select_carrinho_whatsapp);
                              echo 'mensagem += "*Produtos em seu carrinho*\n";';
                              $counter = 0;
                              $vtotalServico = 0;
                              
                              $counter = 0;
                              while($row_carrinho_whatsapp = $result_carrinho_whatsapp->fetch_assoc()) {
                                  $counter = $counter + 1;
                                  //$vtotalServico = $vtotalServico + $row_carrinho_whatsapp['titulo_prod_serv'];
                                  echo 'mensagem += "' . '*'.$counter.'* - ' . $row_carrinho_whatsapp['titulo_prod_serv'] . ' - R$:' . $row_carrinho_whatsapp['valor_total'] . '\n";';
                              }


                              echo 'mensagem += "\n"';
                            ?>
                            //mensagem += "Total: *R$:" + vtotalServico + "*\n\n";
                            //mensagem += "Valor pago: R$:*" + vpagServico + "*\n";
                            //mensagem += "Falta pagar: R$:*" + faltaPagar + "*\n\n";

                            //mensagem += "OBS: *_<?php //echo $_SESSION['saudacoes_filial'];?>_*\n\n";//$_SESSION['endereco_filial']
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

                <script>
                  var data = new Date();
                  var mes = data.getMonth() + 1;
                  var dia = data.getDate();
                  var ano = data.getFullYear();
                  var hora = data.getHours();
                  var minuto = data.getMinutes();

                  document.getElementById("data_hora_ponto").value = `${ano}-${mes.toString().padStart(2, '0')}-${dia.toString().padStart(2, '0')}T${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}`;
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