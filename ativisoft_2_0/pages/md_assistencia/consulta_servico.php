<?php 
    session_start();
    if(!isset($_SESSION['cd_colab']))
    {
        header("location: ../../pages/samples/login.php");
        exit;
    }
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    include("../../classes/financeiro.php");
    $u = new Usuario;

    $f = new Financeiro;
    


?><!--Validar sessão aberta, se usuário está logado.-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
<?php 
    if(isset($_SESSION['bloqueado'])){
      
      if($_SESSION['bloqueado'] == 1){
        //echo "<meta http-equiv='refresh' content='15;url=../auto_pagamento/payment.php'>";
        
      }else if($_SESSION['bloqueado'] == 2){
        echo "<meta http-equiv='refresh' content='1;url=../auto_pagamento/payment.php'>";
      }
    }
  ?>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Consulta Servico</title>
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
  <!--<link rel="shortcut icon" href="<?php //echo $_SESSION['logo_empresa']; ?>" />-->


  
  



</head>

<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">
<script src="../../js/gtag.js"></script>
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
              <h1><?php //echo $_SESSION['bloqueado'];?></h1>
              <div class="card" <?php $_SESSION['c_card'];?>>
                


                <div class="card-body" id="consulta" <?php echo $_SESSION['c_card'];?> style="display: block;" >
                  <h3 class="card-title"<?php echo $_SESSION['c_card'];?>>Consultar pela OS</h3>
                  <p class="card-description"<?php echo $_SESSION['c_card'];?>>Consulte a Ordem de Serviço para lançar as atividades e avisar ao cliente sobre o status atual.</p>
                  <div class="kt-portlet__body" >
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                        <form method="POST">
                          
                          <input placeholder="Ordem de Serviço" type="tel" name="conos_servico" id="conos_servico" type="tel" maxlength="10" class="aspNetDisabled form-control form-control-sm" required>
                          <br>
                          <button type="submit" name="consulta" class="btn btn-success">Consulta</button>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php
                  if(isset($_POST['limparOS'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    //session_start();
                    $_SESSION['cd_cliente'] = 0;
                    $_SESSION['cd_servico'] = 0;
                    $_SESSION['vcusto_orcamento'] = 0;
                    $_SESSION['vpag_servico'] = 0;
                    
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                    
                    
                  }else{
                    if(!isset($_SESSION['cd_servico'])){
                      $_SESSION['cd_servico'] = 0;
                    }
                  }
                

                  if(isset($_POST['pagar'])){

                    $retorno = $f->movimentoFinanceiro(
                                'R',
                                $_SESSION['cd_empresa'],
                                $_SESSION['cd_caixa'],
                                $_SESSION['cd_cliente'],
                                $_SESSION['cd_colab'],
                                $_SESSION['cd_servico'],
                                '',
                                $_POST['fpag_movimento'],
                                $_POST['vpag_movimento']
                              );

                    if($retorno['status'] == 'OK'){
                      echo "<script>alert('Total pago: " . $retorno['vpag'] . "');</script>";
                    }else{
                      echo "<script>alert('| - | - | - | ". $retorno['status'] . " | - | - | - |');</script>";
                    }
                  }

                  if(isset($_POST['marcartitulo_atividade'])){
                    if(isset($_POST['confirmacao'])){
                      $confirmacao = isset($_POST['confirmacao']);
                    }else{
                      $confirmacao = '';
                    }

                    $nova_atividade = $u->lancaAtividade(
                      $_POST['atividadecd_servico'],
                      $_POST['atividadecd_colab'],
                      $_POST['marcartitulo_atividade'],
                      $confirmacao,
                      $_POST['obs_atividade']
                    );
                    if($nova_atividade['status'] == 'OK'){
                      echo "<script>alert('| - | - | - | Atividade gerada (".$nova_atividade['cd_atividade'].") | - | - | - |');</script>";
                    }else{
                      echo "<script>alert('| - | - | - | ".$nova_atividade['status']." | - | - | - |');</script>";
                    }
                  }


                  if(isset($_POST['conos_servico']) || $_SESSION['cd_servico'] > 0){
                    if(isset($_POST['conos_servico'])){
                      $_SESSION['cd_servico'] = $_POST['conos_servico'];
                    }

                    $select_servico = "SELECT * FROM tb_servico WHERE cd_servico = '".$_SESSION['cd_servico']."' AND cd_filial = '".$_SESSION['cd_empresa']."'";
                    $result_servico = mysqli_query($conn, $select_servico);
                    $row_servico = mysqli_fetch_assoc($result_servico);
                    // Exibe as informações do usuário no formulário
                    if($row_servico) {
                      $_SESSION['cd_cliente'] = $row_servico['cd_cliente'];
                      $_SESSION['servico'] = $row_servico['cd_servico'];
                      $_SESSION['cd_servico'] = $row_servico['cd_servico'];

                      $_SESSION['titulo_servico'] = $row_servico['titulo_servico'];
                      $_SESSION['obs_con_servico'] = $row_servico['obs_servico'];
                      $_SESSION['prioridade_servico'] = $row_servico['prioridade_servico'];
                      $_SESSION['entrada_servico'] = $row_servico['entrada_servico'];
                      $_SESSION['prazo_servico'] = $row_servico['prazo_servico'];
                      $_SESSION['orcamento_servico'] = $row_servico['orcamento_servico'];
                      $_SESSION['vpag_servico'] = $row_servico['vpag_servico'];
                    }else{
                      echo "<script>alert('Serviço (".$_SESSION['cd_servico']."), não encontrado');</script>";

                      $_SESSION['cd_cliente'] = 0;
                      $_SESSION['cd_servico'] = 0;
                      $_SESSION['vcusto_orcamento'] = 0;
                      $_SESSION['vpag_servico'] = 0;



                    
                    //echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    //echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                    }

                    $select_cliente = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$_SESSION['cd_cliente']."'";
                    $result_cliente = mysqli_query($conn, $select_cliente);
                    $row_cliente = mysqli_fetch_assoc($result_cliente);
                    if($row_cliente) {
                      $_SESSION['cd_cliente'] = $row_cliente['cd_pessoa'];
                      $_SESSION['pnome_cliente'] = $row_cliente['pnome_pessoa'];
                      $_SESSION['snome_cliente'] = $row_cliente['snome_pessoa'];
                      $_SESSION['tel_cliente'] = $row_cliente['tel1_pessoa'];                
                    }
                  }
                  
                ?>
                <?php

                  


                ?>
                <?php //página se for consultado servico
                  if(isset($_SESSION['cd_servico']) && $_SESSION['cd_servico']  > 0){


                      $_SESSION['servico'] = $_SESSION['cd_servico'];
                      $_SESSION['cd_cliente_comercial'] = 0;

                    echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                  
                    echo '<div class="card-body" id="abrirOS2" '.$_SESSION['c_card'].'><!--FORMULÁRIO PARA CRIAR OS-->';
                    echo '<div class="kt-portlet__body">';
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-12">';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                            
                  
                    
                    
                    //echo '<form method="POST">';
                    
                    //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                    echo '<div class="typeahead" id="botoes" name="botoes" '.$_SESSION['c_card'].' style="display:block;">';
                    echo '<form method="POST" action="../cad_geral/consulta_cliente.php">';
                    echo '<div class="form-group-custom">';
                    //echo '<label for="btncd_cliente">Código</label>';
                    echo '<input value="'.$_SESSION['cd_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                    echo '</div>';
                    echo '<div class="form-group-custom">';
                    echo '<label for="btnpnome_cliente">Nome</label>';
                    echo '<input value="'.$_SESSION['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '</div>';
                    echo '<div class="form-group-custom">';
                    echo '<label for="btnsnome_cliente">Sobrenome</label>';
                    echo '<input value="'.$_SESSION['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '</div>';
                    echo '<div class="form-group-custom">';
                    echo '<label for="btntel_cliente">Telefone</label>';
                    echo '<input value="'.$_SESSION['tel_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '</div>';
                    echo '<td><button type="submit" name="con_cliente" id="con_cliente" class="btn btn-block btn-outline-warning"><i class="icon-cog">Editar</i></button></td>';
                    echo '</form>';
                    echo '</div>';
                    echo '<script>document.getElementById("showcd_cliente").value = "'.$_SESSION['cd_cliente'].'"</script>';
                    echo '<script>document.getElementById("btnpnome_cliente").value = "'.$_SESSION['pnome_cliente'].'"</script>';
                    echo '<script>document.getElementById("btnsnome_cliente").value = "'.$_SESSION['snome_cliente'].'"</script>';
                    echo '<script>document.getElementById("btntel_cliente").value = "'.$_SESSION['tel_cliente'].'"</script>';

                    //echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" '.$_SESSION['c_card'].' style="display: block;">';
                    echo '<form method="POST" action="cadastro_servico.php">';
                    
                    echo '<div class="form-group-custom">';
                    echo '<label for="btncd_servico">OS</label>';
                    echo '<input value="'.$_SESSION['cd_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" class="aspNetDisabled form-control form-control-sm" readonly>';
                    echo '</div>';
                    echo '<div class="form-group-custom">';
                    echo '<label for="btnobs_servico">Descrição Geral</label>';
                    echo '<input value="'.$_SESSION['obs_con_servico'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="Caracteristica geral do serviço" readonly>';
                    echo '</div>';
                    echo '<div class="form-group-custom">';
                    echo '<label for="btnprioridade_servico">Prioridade</label>';
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
                    echo '</div>';
                    echo '<div class="form-group-custom">';
                    echo '<label for="btnentrada_servico">Entrada</label>';
                    echo '<input value="'.$_SESSION['entrada_servico'].'" name="btnentrada_servico" type="datetime-local" id="btnentrada_servico" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '</div>';
                    echo '<div class="form-group-custom">';
                    echo '<label for="btnprazo_servico">Prazo</label>';
                    echo '<input value="'.$_SESSION['prazo_servico'].'" name="btnprazo_servico" type="datetime-local" id="btnprazo_servico" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '</div>';
                    echo '<td><button type="submit" name="con_edit_os" id="con_edit_os" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Editar</button></td>';
                    echo '</form>';
                    echo '</div>';
                    echo '<script>document.getElementById("btncd_servico").value = "'.$_SESSION['cd_servico'].'"</script>';
                    echo '<script>document.getElementById("btnobs_servico").value = "'.$_SESSION['obs_con_servico'].'"</script>';
                    echo '<script>document.getElementById("btnprioridade_servico").value = "'.$_SESSION['prioridade_servico'].'"</script>';
                    echo '<script>document.getElementById("btnentrada_servico").value = "'.$_SESSION['entrada_servico'].'"</script>';
                    echo '<script>document.getElementById("btnprazo_servico").value = "'.$_SESSION['prazo_servico'].'"</script>';

                    $select_orcamento = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['cd_servico']."' ORDER BY cd_orcamento ASC";
                    $result_orcamento = mysqli_query($conn, $select_orcamento);
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
                    echo '<h3 class="kt-portlet__head-title">Serviços adicionados</h3>';
                    $_SESSION['vcusto_orcamento'] = 0;

                    $count = 0;
                    $vtotal = 0;
                    while($row_orcamento = $result_orcamento->fetch_assoc()) {

                      echo '<div name="listaOrcamento" id="listaOrcamento" class="typeahead">';
                        echo '<form method="POST">';
                        echo '<div class="horizontal-form">';
                        echo '<div class="form-group">';
                        $count = $count + 1;
                        if($row_orcamento['tipo_orcamento'] == 'AVULSO'){
                          echo '<div class="col-lg-12 col-sm-12">';
                          echo '<div class="input-group">';
                          
                          echo '<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">';
                          echo '<div class="input-group-prepend">';
                          echo '<span class="input-group-text btn-outline-info">'.$count.'</span>';
                          echo '<input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class="aspNetDisabled form-control form-control-sm" style="display:none;">';
                          echo '<input value="'.$row_orcamento['titulo_orcamento'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
                          echo '</div>';
                          echo '</div>';

                          echo '<div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">';
                          echo '<div class="input-group-prepend">';
                          echo '<span class="input-group-text btn-outline-info">SubTotal</span>';
                          echo '<input value="'.$row_orcamento['vcusto_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
                          //echo '<input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                          echo '</div>';
                          echo '</div>';

                          //echo '<input type="submit" value="X" onclick="location.reload()" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                          
                          echo '</div>';
                          echo '</div>';
                          $vtotal = $vtotal + $row_orcamento['vcusto_orcamento'];
                          $_SESSION['vcusto_orcamento'] = $vtotal;
                        }else if($row_orcamento['tipo_orcamento'] == 'CADASTRADO'){
 
                          echo '<div class="col-lg-12 col-sm-12">';
                          echo '<div class="input-group">';
                          echo '<div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">';
                          echo '<div class="input-group-prepend">';
                          echo '<span class="input-group-text btn-outline-info">'.$count.'</span>';
                                
                          echo '<input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class="aspNetDisabled form-control form-control-sm" style="display:none;">';
                          echo '<input value="'.$row_orcamento['titulo_orcamento'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
                          
                          echo '</div>';
                          echo '</div>';

                          echo '<div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">';
                          echo '<div class="input-group-prepend">';
                          echo '<span class="input-group-text btn-outline-info">Valor</span>';
                          echo '<input value="'.$row_orcamento['vprod_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';

                          echo '</div>';
                          echo '</div>';

                          echo '<div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">';
                          echo '<div class="input-group-prepend">';
                          echo '<span class="input-group-text btn-outline-info">QTD</span>';
                          echo '<input value="'.$row_orcamento['qtd_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';

                          echo '</div>';
                          echo '</div>';
                          
                          echo '<div class="col-sm-6 col-md-3 col-lg-3 col-xl-3">';
                          echo '<div class="input-group-prepend">';
                          echo '<span class="input-group-text btn-outline-info">SubTotal</span>';
                          echo '<input value="'.$row_orcamento['vcusto_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
                          //echo '<input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                          
                          echo '</div>';
                          echo '</div>';
                          //echo '<label for="listaremover_orcamento"></label>';
                          //echo '<input type="submit" value="X" onclick="location.reload()" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                          
                          
                          echo '</div>';
                          echo '</div>';
                          $vtotal = $vtotal + $row_orcamento['vcusto_orcamento'];
                          $_SESSION['vcusto_orcamento'] = $vtotal;

                        }
                        
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                    } 
                    //$_SESSION['falta_pagar_orcamento'] = $_SESSION['vcusto_orcamento'] - $_SESSION['vpag_orcamento'];
                    echo '<div class="typeahead" '.$_SESSION['c_body'].'">';
                    echo '<div class="horizontal-form"'.$_SESSION['c_card'].'>';
                    echo '<div class="form-group"'.$_SESSION['c_card'].'>';
                    
                    
                    if($_SESSION['vpag_servico'] == $_SESSION['vcusto_orcamento']){
                      echo '<label for="showobs_servico">Total Pago:</label>';
                      echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                    }else{
                      $_SESSION['falta_pagar_servico'] = $_SESSION['vcusto_orcamento'] - $_SESSION['vpag_servico'];
                      echo '<label for="showobs_servico">Total:</label>';
                      echo '<input value="'.$_SESSION['vcusto_orcamento'].'" type="tel" name="btnvcusto_orcamento" id="btnvcusto_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
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
                    

                    

                      $result_impressao   = $u->impressao1($_SESSION['tipo_impressao'], 'SERVICO', $_SESSION['cd_empresa'], $_SESSION['cd_servico']);
                      
                      $result_mensagem   = $u->mensagem1($_SESSION['tipo_mensagem'], 'SERVICO', $_SESSION['cd_empresa'], $_SESSION['cd_servico']);

                      $result_atividade   = $u->fragAtividade($_SESSION['cd_servico']);

                      echo $result_mensagem['partial_mensagem'];


                      echo $result_impressao['partial_impressao'];


                    ////echo '<form method="post"'.$_SESSION['c_card'].'>';//echo '<button type="submit" class="btn btn-danger" name="limparOS" style="margin: 5px;">Nova Consulta</button>';
                    //echo '<button type="submit" class="btn btn-block btn-lg btn-warning" name="editaOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-file-check btn-icon-append"></i> Editar</button>';
                    ////echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparOS" style="margin-top: 20px; margin-bottom: 20px;"><i class="mdi mdi-reload btn-icon-prepend"></i> Nova Consulta</button>';
                    //<i class="mdi mdi-alert btn-icon-prepend"></i>  
                    ////echo '</form>';


                      echo $result_atividade['partial_atividade'];
                      

                  }
                ?>
 <!-- #region -->
  
 

 <!-- #endregion -->
                </div>
                


                


              
                <?php
  
?>
                
             

                

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