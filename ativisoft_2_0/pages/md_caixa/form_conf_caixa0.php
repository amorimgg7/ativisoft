<?php
session_start();
if (!isset($_SESSION['cd_colab'])) {
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
    <title>Abrir Caixa</title>
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

<!--<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">-->

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php include("../../partials/_navbar.php"); ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php include("../../partials/_sidebar.php"); ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper" <?php echo $_SESSION['c_body']; ?>>
                    <div class="row">
                        <div class="col-sm-12 mb-4 mb-xl-0">
                            <script>
                                document.getElementById("c_body").style = '<?php echo $_SESSION['c_body']; ?>';
                                document.getElementById("c_card").style = '<?php echo $_SESSION['c_card']; ?>';
                            </script>
                            <p>
                                <?php echo $_SESSION['c_body']; ?>
                            </p>
                            <p>
                                <?php echo $_SESSION['c_card']; ?>
                            </p>
                            <p class="font-weight-normal mb-2 text-muted"><span id="data-atual"></span></p>
                            <script>
                                var data = new Date();
                                var mesPorExtenso = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(data).toUpperCase();
                                var dia = data.getDate();
                                var ano = data.getFullYear();
                                document.getElementById("data-atual").innerHTML = 'HOJE É ' + dia + ' DE ' + mesPorExtenso + ', ' + ano;
                            </script>
                        </div>
                    </div>
                   
                            
                                <?php


                        
                    echo '<div class="card-body" id="abrirOS2" '.$_SESSION['c_card'].'><!--FORMULÁRIO PARA CRIAR OS-->';
                    echo '<div class="kt-portlet__body">';
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-12">';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                            
                  
                    
                    
                    //echo '<form method="POST">';
                    
                    //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" '.$_SESSION['c_card'].' style="display:block;">';
                    echo '<h3 class="kt-portlet__head-title">Caixa'.$_SESSION['cx_conferir'].'</h3>';
                    echo '<form method="POST">';
                    echo '<label for="conf_cd_caixa">ID CAIXA</label>';
                    echo '<input value="'.$_SESSION['conf_cd_caixa'].'" name="conf_cd_caixa" type="text" id="conf_cd_caixa" class="aspNetDisabled form-control form-control-sm" readonlypages/md_caixa/form_conf_caixa.php/>';
                    echo '<label for="conf_abertura_caixa">Abertura</label>';
                    echo '<input value="'.$_SESSION['conf_abertura_caixa'].'" name="conf_abertura_caixa" type="text" id="conf_abertura_caixa" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="conf_fechamento_caixa">Fechamento</label>';
                    echo '<input value="'.$_SESSION['conf_fechamento_caixa'].'" name="conf_fechamento_caixa" type="text" id="conf_fechamento_caixa" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="conf_responsavel_caixa">Responsável</label>';
                    echo '<input value="'.$_SESSION['conf_responsavel_caixa'].'" name="conf_responsavel_caixa" type="tel"  id="conf_responsavel_caixa" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '</form>';
                    echo '</div>';
                    //echo '<script>document.getElementById("showcd_cliente").value = "'.$_SESSION['cd_cliente'].'"</script>';
                    //echo '<script>document.getElementById("btnpnome_cliente").value = "'.$_SESSION['pnome_cliente'].'"</script>';
                    //echo '<script>document.getElementById("btnsnome_cliente").value = "'.$_SESSION['snome_cliente'].'"</script>';
                    //echo '<script>document.getElementById("btntel_cliente").value = "'.$_SESSION['tel_cliente'].'"</script>';

                    //echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" '.$_SESSION['c_card'].' style="display: block;">';
                    echo '<form method="POST" action="cadastro_servico.php">';
                    
                    echo '<label for="btncd_servico">CAIXA</label>';
                    echo '<input value="'.$_SESSION['cd_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" class="aspNetDisabled form-control form-control-sm" readonly>';
                    
                    echo '<label for="btnobs_servico">Descrição Geral</label>';
                    echo '<input value="'.$_SESSION['obs_servico'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="..." readonly>';
                    echo '<label for="btnprioridade_servico">...</label>';
                    echo '<select name="btnprioridade_servico" id="btnprioridade_servico"  class="aspNetDisabled form-control form-control-sm" style="display:none;">';
                    echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >'.$_SESSION['prioridade_servico'].'</option>';
                    echo '</select>';
                    if($_SESSION['prioridade_servico'] == 'U'){
                      echo '<input value="Urgente" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
                    }
                    if($_SESSION['prioridade_servico'] == 'A'){
                      echo '<input value="Alta" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
                    }
                    if($_SESSION['prioridade_servico'] == 'M'){
                      echo '<input value="Média" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
                    }
                    if($_SESSION['prioridade_servico'] == 'B'){
                      echo '<input value="Baixa" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
                    }
                    echo '<label for="btnentrada_servico">/...</label>';
                    echo '<input value="'.$_SESSION['entrada_servico'].'" name="bbtnentrada_servico" type="datetime-local" id="bbtnentrada_servico" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btnprazo_servico">Prazo</label>';
                    echo '<input value="'.$_SESSION['prazo_servico'].'" name="btnprazo_servico" type="datetime-local" id="btnprazo_servico" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    
                    //echo '<td><button type="submit" name="con_edit_os" id="con_edit_os" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Editar</button></td>';
                    echo '</form>';
                    echo '</div>';
                    echo '<script>document.getElementById("btncd_servico").value = "'.$_SESSION['cd_servico'].'"</script>';
                    echo '<script>document.getElementById("btnobs_servico").value = "'.$_SESSION['obs_servico'].'"</script>';
                    echo '<script>document.getElementById("btnprioridade_servico").value = "'.$_SESSION['prioridade_servico'].'"</script>';
                    echo '<script>document.getElementById("btnentrada_servico").value = "'.$_SESSION['entrada_servico'].'"</script>';
                    echo '<script>document.getElementById("btnprazo_servico").value = "'.$_SESSION['prazo_servico'].'"</script>';

                    //$select_orcamento = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['cd_servico']."' ORDER BY cd_orcamento ASC";
                    //$result_orcamento = mysqli_query($conn, $select_orcamento);
                    //$row_atividade = mysqli_fetch_assoc($result_atividade);
        
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
                    //echo '<h3 class="kt-portlet__head-title">Serviços adicionados</h3>';
                    $_SESSION['vtotal_orcamento'] = 0;

                    while($row_orcamento = $result_orcamento->fetch_assoc()) {

                      echo '<div name="listaOrcamento" id="listaOrcamento" class="typeahead" '.$_SESSION['c_card'].'>';
                      //echo '<form method="POST">';
                      echo '<div class="horizontal-form">';
                      echo '<div class="form-group">';
                      $count = $count + 1;
                      
                      echo '<input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class="aspNetDisabled form-control form-control-sm" style="display:none;">';
                      echo '<label for="listatitulo_orcamento">#'.$count.'</label>';
                      echo '<input value="'.$row_orcamento['titulo_orcamento'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
                      echo '<label for="listavalor_orcamento">R$: </label>';
                      echo '<input value="'.$row_orcamento['vcusto_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
                      //echo '<label for="listaremover_orcamento"></label>';
                      //echo '<input type="submit" value="X" onclick="location.reload()" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                      //echo '<input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                      
                      $vtotal = $vtotal + $row_orcamento['vcusto_orcamento'];
                      $_SESSION['vtotal_orcamento'] = $vtotal;
                      echo '</div>';
                      echo '</div>';
                      //echo '</form>';
                      echo '</div>';
                      //$i = 0;
                    } 
                    $_SESSION['falta_pagar_orcamento'] = $_SESSION['vtotal_orcamento'] - $_SESSION['vpag_orcamento'];
                    echo '<div class="typeahead" '.$_SESSION['c_body'].'">';
                    echo '<div class="horizontal-form"'.$_SESSION['c_card'].'>';
                    echo '<div class="form-group"'.$_SESSION['c_card'].'>';
                    
                    
                    if($_SESSION['vpag_servico'] == $_SESSION['vtotal_orcamento']){
                      echo '<label for="showobs_servico">Total Pago:</label>';
                      echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                    }else{
                      $_SESSION['falta_pagar_servico'] = $_SESSION['vtotal_orcamento'] - $_SESSION['vpag_servico'];
                      echo '<label for="showobs_servico">Total:</label>';
                      echo '<input value="'.$_SESSION['vtotal_orcamento'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                      echo '<label for="showobs_servico">Pago:</label>';
                      echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                      echo '<label for="showobs_servico">Falta:</label>';
                      echo '<input value="'.$_SESSION['falta_pagar_servico'].'" type="tel" name="btn_falta_pagar_orcamento" id="btn_falta_pagar_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
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

                    
                    
                    
                      $_SESSION['tela_movimento_financeiro'] = "VENDA_SERVICO";
                      //echo '<div class="col-12 grid-margin stretch-card btn-success">';//
                      //echo '<div class="card">';
                      //echo '<div class="card-body">';
                      include("../md_caixa/movimento_financeiro.php");
                      //echo '</div>';
                      //echo '</div>';
                      //echo '</div>';
                    

                    


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
                    //echo '<button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarPosicaoMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Localização<i class="mdi mdi-whatsapp"></i></button>';
                    //echo '<button type="submit" class="btn btn-danger" name="limparOS-" style="margin: 5px;">Nova Consulta</button>';     
                    echo '</form>';
                    echo '<form method="post"'.$_SESSION['c_card'].'>';//echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Nova Consulta</button>';
                    //echo '<button type="submit" class="btn btn-block btn-lg btn-warning" name="editaOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-file-check btn-icon-append"></i> Editar</button>';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-reload btn-icon-prepend"></i> Nova Consulta</button>';
                    //<i class="mdi mdi-alert btn-icon-prepend"></i>  
                    echo '</form>';




                                ?>

                                
                                




                           
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">

            </div>
        </div>
    </div>
    </div>
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