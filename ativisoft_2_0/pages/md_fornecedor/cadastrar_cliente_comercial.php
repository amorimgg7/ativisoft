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
    if(isset($_SESSION['os_cliente'])){
      echo '<script>document.getElementById("abrirOS").style.display = "block";</script>';      
    }
?><!--Validar sessão aberta, se usuário está logado.-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Serviços</title>
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
              <div class="card">
                

                <?php
                  if(isset($_POST['CancelarCadastro'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    ////session_start();
                    $_SESSION['concnpj_cliente_comercial'] = 0;
                    echo '<script>document.getElementById("cadastroCliente").style.display = "none";</script>';//botoes
                  }

                  
                  //cadastra cliente e consulta para abrir ordem de serviço
                  
                  if(isset($_POST['cadcnpj_cliente_comercial'])) { //CADASTRAR E CHAMAR CADASTRADO PARA SESSION
                    if($_POST['cadcd_cliente_comercial'] > 0){

                      $update_cliente_comercial = "UPDATE tb_cliente_comercial SET 
                        rsocial_cliente_comercial = '".$_POST['cadrsocial_cliente_comercial']."',
                        nfantasia_cliente_comercial = '".$_POST['cadnfantasia_cliente_comercial']."',
                        dtvalidlicenca_cliente_comercial = '".$_POST['caddtvalidlicenca_cliente_comercial']."',
                        obs_cliente_comercial = '".$_POST['cadobs_cliente_comercial']."',
                        tel_cliente_comercial = '".$_POST['cadtel_cliente_comercial']."',
                        obs_tel_cliente_comercial = '".$_POST['cadobs_tel_cliente_comercial']."',
                        email_cliente_comercial = '".$_POST['cademail_cliente_comercial']."',
                        fatura_prevista_cliente_fiscal = ".$_POST['cadfatura_prevista_cliente_fiscal'].",
                        fatura_devida_cliente_fiscal = ".$_POST['cadfatura_devida_cliente_fiscal']."
                        WHERE cd_cliente_comercial = ".$_POST['cadcd_cliente_comercial'];


                      if(mysqli_query($conn, $update_cliente_comercial)){
                      }else{
                        echo "<script>window.alert('Erro ao Update da tb_cliente_comercial!');</script>";
                      }
                      
                      //update
                    }else{
                      ////echo "<script>window.alert('Realizando Insert Into!');</script>";
                      //include("../../partials/load.html");
                      
                      $insert_cliente_comercial = "INSERT INTO tb_cliente_comercial (rsocial_cliente_comercial, nfantasia_cliente_comercial, cnpj_cliente_comercial, dtcadastro_cliente_comercial, dtvalidlicenca_cliente_comercial, obs_cliente_comercial, tel_cliente_comercial, obs_tel_cliente_comercial, email_cliente_comercial, fatura_prevista_cliente_fiscal, fatura_devida_cliente_fiscal) VALUES(
                        '".$_POST['cadrsocial_cliente_comercial']."',
                        '".$_POST['cadnfantasia_cliente_comercial']."',
                        ".$_POST['cadcnpj_cliente_comercial'].",
                        '".$_POST['caddtcadastro_cliente_comercial']."',
                        '".$_POST['caddtvalidlicenca_cliente_comercial']."',
                        '".$_POST['cadobs_cliente_comercial']."',
                        '".$_POST['cadtel_cliente_comercial']."',
                        '".$_POST['cadobs_tel_cliente_comercial']."',
                        '".$_POST['cademail_cliente_comercial']."',
                        ".$_POST['cadfatura_prevista_cliente_fiscal'].",
                        ".$_POST['cadfatura_devida_cliente_fiscal']."
                      )
                      ";
                      if(mysqli_query($conn, $insert_cliente_comercial) == true){
                        echo "<script>window.alert('Cliente Cadastrado!');</script>";
                      }else{
                        echo "<script>window.alert('Erro ao Insert Into!');</script>";
                      }
                      $select_cliente_comercial = "SELECT * FROM tb_cliente_comercial WHERE cnpj_cliente_comercial = '".$_POST['cadcnpj_cliente_comercial']."' ORDER BY cd_cliente_comercial DESC LIMIT 1";
                      $result_cliente_comercial = mysqli_query($conn, $select_cliente_comercial);
                      $row_cliente_comercial = mysqli_fetch_assoc($result_cliente_comercial);
                      // Exibe as informações do usuário no formulário
                      if($row_cliente_comercial) {
                        $_SESSION['concd_cliente_comercial'] = $row_cliente_comercial['cd_cliente_comercial'];
                      }
                    }
                  }


                  if(isset($_POST['lancarFatura'])) {
                              
                    if($_POST['data_fatura']==false){
                      $_SESSION['data_fatura'] = $_POST['data_fatura'];
                      $_SESSION['vcusto_fatura'] = $_POST['vcusto_fatura'];
                      echo "<script>window.alert('Descreva a Fatura!');</script>"; 
                    }else if($_POST['vcusto_fatura']==false){
                      $_SESSION['data_fatura'] = $_POST['data_fatura'];
                      $_SESSION['vcusto_fatura'] = $_POST['vcusto_fatura'];
                      echo "<script>window.alert('Insira o Valor da Fatura!');</script>";  
                    }else{
                      $_SESSION['data_fatura'] = false;
                      $_SESSION['vcusto_fatura'] = false;
                      $insertOrcamento = "INSERT INTO tb_orcamento_servico(cd_cliente_comercial, titulo_orcamento, vcusto_orcamento, status_orcamento) VALUES(
                        '".$_SESSION['cadcd_cliente_comercial']."',
                        '".$_POST['data_fatura']."',
                        '".$_POST['vcusto_fatura']."',
                        '0')
                      ";
                      if(!mysqli_query($conn, $insertOrcamento)){
                        echo "<script>window.alert('Erro ao lançar a fatura na TB_ORCAMENTO_SERVICO!');</script>"; 
                      }
                      $fatura = $_POST['vcusto_fatura'] + $_SESSION['falta_pagar_servico'];
                      $_SESSION['vtotal_servico'] = $_SESSION['vtotal_servico'] + $_POST['vcusto_fatura'];
                      $updateFaturaClienteComercial = "UPDATE tb_cliente_comercial SET
                        dtvalidlicenca_cliente_comercial = '".$_POST['data_fatura']."',
                        fatura_devida_cliente_fiscal = ".$fatura."
                        WHERE cd_cliente_comercial = ".$_SESSION['cd_cliente_comercial']."";
                        if(!mysqli_query($conn, $updateFaturaClienteComercial)){
                          echo "<script>window.alert('Erro ao lançar a fatura na TB_CLIENTE_COMERCIAL!');</script>"; 
                        }
                    }            
                  }

                  if(isset($_POST['pagar_servico'])){//pagar a fatura
                    $insert_pagar_servico = "INSERT INTO tb_movimento_financeiro(tipo_movimento, cd_caixa_movimento, cd_cliente_comercial, cd_colab_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES(
                        1,
                        '".$_SESSION['cd_caixa']."',
                        '".$_SESSION['cd_cliente_comercial']."',
                        '".$_SESSION['cd_colab']."',
                        '".$_POST['fpag_movimento']."',
                        '".$_POST['vpag_movimento']."',
                        '".date('Y-m-d H:i', strtotime('+1 hour'))."',
                        'PAGAMENTO DA FATURA DO CLIENTE: ".$_SESSION['cd_cliente_comercial']."'
                         )
                     ";
                    mysqli_query($conn, $insert_pagar_servico);
                    //echo "<script>window.alert('Movimento Financeiro Lançado!');</script>";
                    
                    $fechar_caixa = "UPDATE tb_cliente_comercial SET
                        fatura_devida_cliente_fiscal = '".($_SESSION['fatura_devida_cliente_fiscal'] - $_POST['vpag_movimento'])."'
                        WHERE cd_cliente_comercial = ".$_SESSION['cd_cliente_comercial']."";
                        if(!mysqli_query($conn, $fechar_caixa)){
                          echo "<script>window.alert('Erro ao lançar na tb_cliente_comercial!');</script>";
                        }
                        
                        $_SESSION['vpag_servico'] = $_POST['vpag_movimento'] - $_SESSION['fatura_devida_cliente_fiscal'];
                        $_SESSION['falta_pagar_servico'] = $_SESSION['vtotal_orcamento'] - $_SESSION['vpag_servico'];
                        echo  '<script>document.getElementById("btn_falta_pagar_orcamento").value = "'.$_SESSION['fatura_devida_cliente_fiscal'].'";</script>';
        
                        if($_SESSION['fatura_devida_cliente_fiscal'] == 0){
                            echo '<script>document.getElementById("tela_pagamento").style.display = "none";</script>';//tela_pagamento
                        }
                        //$_SESSION['cd_servico'] = 0;
                        //$_SESSION['cd_servico'] = 0;
                        //$_SESSION['cd_cliente'] = 0;
                        //echo '<script>location.href="../../index.php";</script>';
                  }


                  if(isset($_POST['listaremover_orcamento'])) {//DELETE FROM `tb_orcamento_servico` WHERE `tb_orcamento_servico`.`cd_orcamento` = 198
                    if(($_SESSION['vtotal_orcamento'] - $_POST['listavalor_orcamento'])>=$_SESSION['vpag_servico']){
                      //echo "<script>window.alert('OK, pode remover');</script>";
                      //$vtotal = $_SESSION['falta_pagar_servico'] - $_POST['listavalor_orcamento'];
                      $removeOrcamento = "DELETE FROM `tb_orcamento_servico` WHERE `tb_orcamento_servico`.`cd_orcamento` = ".$_POST['listaid_orcamento']."";
                      if(!mysqli_query($conn, $removeOrcamento)){
                        echo "<script>window.alert('Erro ao deletar da tb_orcamento_servico!');</script>";  
                      }
                      $fatura = $_SESSION['falta_pagar_servico'] - $_POST['listavalor_orcamento'];

                      $dtvalidlicenca_cliente_comercial = date('Y-m-d', strtotime('-1 month', strtotime($_POST['listatitulo_orcamento'])));

                      $updateVtotalServico = "UPDATE tb_cliente_comercial SET
                        dtvalidlicenca_cliente_comercial = '".$dtvalidlicenca_cliente_comercial."',
                        fatura_devida_cliente_fiscal = ".$fatura."
                        WHERE cd_cliente_comercial = ".$_SESSION['cd_cliente_comercial']."";
                      if(!mysqli_query($conn, $updateVtotalServico)){
                        echo "<script>window.alert('erro ao atualizar a tb_cliente_comercial!');</script>";  
                      }
                      echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_fornecedor/cadastrar_cliente_comercial.php";</script>';             
                    }else{
                      echo "<script>window.alert('O valor pago não pode ser menor que o que o valor devido!');</script>";  
                    }
                  }
                ?>
                
                <div class="card-body" id="consulta" >
                  <h4 class="card-title">Identifique o cliente</h4>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                            <form method="POST"> 
                                <div class="form-group" style="display: flex;">
                                <div class="input-group">
                                    <input placeholder="CNPJ do Cliente" type="tel" name="concnpj_cliente_comercial" id="concnpj_cliente_comercial" oninput="cnpj(this)" class="aspNetDisabled form-control form-control-sm" required oninput="validateInput(this)">
                                </div>
                                </div>
                                <button type="submit" name="consulta" class="btn btn-block btn-success">Consulta</button>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-body" id="cadastroCliente" style="display:none;">
                  <h3 class="kt-portlet__head-title">Dados do cliente</h3>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST">
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                              <input  name="cadcd_cliente_comercial" type="tel" id="cadcd_cliente_comercial" class="aspNetDisabled form-control form-control-sm" style="display: block;" readonly/>
                              <label for="cadrsocial_cliente_comercial">Razão Social</label>
                              <input name="cadrsocial_cliente_comercial" type="text" id="cadrsocial_cliente_comercial" maxlength="100"   class="aspNetDisabled form-control form-control-sm" required/>
                              <label for="cadnfantasia_cliente_comercial">Nome Fantasia</label>
                              <input name="cadnfantasia_cliente_comercial" type="text" id="cadnfantasia_cliente_comercial" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>
                              <label for="cadcnpj_cliente_comercial">CNPJ</label>
                              <input name="cadcnpj_cliente_comercial" type="text" id="cadcnpj_cliente_comercial" maxlength="90" oninput="cnpj(this)" class="aspNetDisabled form-control form-control-sm" readonly/>                            
                              <label for="btntel_cliente">Data do Cadastro</label>
                              <input name="caddtcadastro_cliente_comercial" type="date"  id="caddtcadastro_cliente_comercial"  class="aspNetDisabled form-control form-control-sm" readonly/>
                              <label for="btntel_cliente">Data do Vencimento</label>
                              <input name="caddtvalidlicenca_cliente_comercial" type="date" id="caddtvalidlicenca_cliente_comercial" class="aspNetDisabled form-control form-control-sm" required/>
                              <label for="btntel_cliente">Obs Cliente _ Status.</label>
                              <input name="cadobs_cliente_comercial" type="text"  id="cadobs_cliente_comercial" class="aspNetDisabled form-control form-control-sm"/>
                              <label for="btntel_cliente">Telefone Filial</label>
                              <input name="cadtel_cliente_comercial" type="tel"  id="cadtel_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required/>
                              <label for="btntel_cliente">Email Filial</label>
                              <input name="cademail_cliente_comercial" type="email"  id="cademail_cliente_comercial" class="aspNetDisabled form-control form-control-sm" required/>
                              <label for="btntel_cliente">Observações dos contatos</label>
                              <input name="cadobs_tel_cliente_comercial" type="text"  id="cadobs_tel_cliente_comercial" class="aspNetDisabled form-control form-control-sm"/>
                              <label for="btntel_cliente">Fatura Prevista</label>
                              <input name="cadfatura_prevista_cliente_fiscal" type="tel"  id="cadfatura_prevista_cliente_fiscal" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required/>
                              <label for="btntel_cliente">Fatura Devida</label>
                              <input name="cadfatura_devida_cliente_fiscal" type="tel"  id="cadfatura_devida_cliente_fiscal" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required/>
                              <td><button type="submit" name="cad_cliente_comercial" id="cad_cliente_comercial" class="btn btn-block btn-outline-success"><i class="icon-cog">Gravar</i></button></td>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                
                <?php
                  if(isset($_POST['concnpj_cliente_comercial'])){
                    $_SESSION['concnpj_cliente_comercial'] = $_POST['concnpj_cliente_comercial'];
                  }
                  if($_SESSION['concnpj_cliente_comercial'] > 0) { //CHAMAR CLIENTE CADASTRADO PARA SESSION
                    $select_cliente_comercial = "SELECT * FROM tb_cliente_comercial WHERE cnpj_cliente_comercial = '".$_SESSION['concnpj_cliente_comercial']."' ORDER BY cd_cliente_comercial DESC";
                    $result_cliente_comercial = mysqli_query($conn, $select_cliente_comercial);
                    $row_cliente_comercial = mysqli_fetch_assoc($result_cliente_comercial);
                    // Exibe as informações do usuário no formulário
                    if($row_cliente_comercial) {
                      //echo "<script>window.alert('Cliente encontrado!');</script>";
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                      echo '<script>document.getElementById("cadastroCliente").style.display = "block";</script>';
                      $_SESSION['cd_cliente_comercial'] = $row_cliente_comercial['cd_cliente_comercial'];
                      $_SESSION['fatura_devida_cliente_fiscal'] = $row_cliente_comercial['fatura_devida_cliente_fiscal'];
                      $_SESSION['servico'] = 0;
                      $data_fatura_prevista = date('Y-m-d', strtotime('+1 month', strtotime($row_cliente_comercial['dtvalidlicenca_cliente_comercial'])));
                      echo '<script>document.getElementById("cadcd_cliente_comercial").value = "'. $row_cliente_comercial['cd_cliente_comercial'] .'";</script>';
                      $_SESSION['cadcd_cliente_comercial'] = $row_cliente_comercial['cd_cliente_comercial'];
                      echo '<script>document.getElementById("cadrsocial_cliente_comercial").value = "'. $row_cliente_comercial['rsocial_cliente_comercial'] .'";</script>';
                      echo '<script>document.getElementById("cadnfantasia_cliente_comercial").value = "'. $row_cliente_comercial['nfantasia_cliente_comercial'] .'";</script>';
                      echo '<script>document.getElementById("cadcnpj_cliente_comercial").value = "'. strval($row_cliente_comercial['cnpj_cliente_comercial']) .'";</script>';
                      echo '<script>document.getElementById("caddtcadastro_cliente_comercial").value = "' . date('Y-m-d', strtotime($row_cliente_comercial['dtcadastro_cliente_comercial'])) . '";</script>';
                      echo '<script>document.getElementById("caddtvalidlicenca_cliente_comercial").value = "' . date('Y-m-d', strtotime($row_cliente_comercial['dtvalidlicenca_cliente_comercial'])) .'";</script>';
                      echo '<script>document.getElementById("cadobs_cliente_comercial").value = "'. $row_cliente_comercial['obs_cliente_comercial'] .'";</script>';
                      echo '<script>document.getElementById("cadtel_cliente_comercial").value = "'. $row_cliente_comercial['tel_cliente_comercial'] .'";</script>';
                      echo '<script>document.getElementById("cademail_cliente_comercial").value = "'. $row_cliente_comercial['email_cliente_comercial'] .'";</script>';
                      echo '<script>document.getElementById("cadobs_tel_cliente_comercial").value = "'. $row_cliente_comercial['obs_tel_cliente_comercial'] .'";</script>';
                      echo '<script>document.getElementById("cadfatura_prevista_cliente_fiscal").value = "'. $row_cliente_comercial['fatura_prevista_cliente_fiscal'] .'";</script>';
                      echo '<script>document.getElementById("cadfatura_devida_cliente_fiscal").value = "'. $row_cliente_comercial['fatura_devida_cliente_fiscal'] .'";</script>';
                      
                      echo '<div class="card-body" '.$_SESSION['c_card'].'>';
                      echo '<div class="kt-portlet__body">';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      
                      if($row_cliente_comercial['cd_cliente_comercial'] > 0){
                        $select_orcamento = "SELECT * FROM tb_orcamento_servico WHERE cd_cliente_comercial = '".$_SESSION['cd_cliente_comercial']."' ORDER BY cd_orcamento ASC";
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
                              
                        echo '<h3 class="kt-portlet__head-title">Lançar nova Fatura</h3>';
                        echo '<script>document.getElementById("listaOrcamento").style.display = "block";</script>';
                        echo '<form method="post">';
                        echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6;">';
                        echo '<div class="horizontal-form">';
                        echo '<div class="form-group">';
                        
                        echo '<label for="data_fatura"></label>';
                        

                        echo '<input value="'.$data_fatura_prevista.'"type="date" style="width: 20%;" name="data_fatura" id="data_fatura" class="aspNetDisabled form-control form-control-sm">';
                        echo '<label for="vcusto_fatura"></label>';
                        echo '<input type="tel" oninput="tel(this)" id="vcusto_fatura" name="vcusto_fatura" class="aspNetDisabled form-control form-control-sm" placeholder="Quanto custa este serviço?">';
                        
                        echo '<label for="lancarFatura"></label>';
                        echo '<button type="submit" name="lancarFatura" id="lancarFatura" class="btn btn-success">Enviar</button>';
                        
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                        
                        echo '<h3 class="kt-portlet__head-title">Faturas Geradas</h3>';
                        $_SESSION['vtotal_orcamento'] = 0;
                        $_SESSION['vpag_orcamento'] = 0;
                        $count = 0;
                        $vcusto_orcamento = 0;
                        $vpag_orcamento = 0;
                        $_SESSION['vpag_servico'] = 10;
                        while($row_orcamento = $result_orcamento->fetch_assoc()) {
                          echo '<div name="listaOrcamento" id="listaOrcamento" class="typeahead" '.$_SESSION['c_card'].'>';
                          echo '<form method="POST">';
                          echo '<div class="horizontal-form">';
                          echo '<div class="form-group">';
                          $count = $count + 1;
                          echo '<input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class="aspNetDisabled form-control form-control-sm" style="display:none;">';
                          echo '<label for="listatitulo_orcamento">#'.$count.'</label>';
                          echo '<input value="'.$row_orcamento['titulo_orcamento'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="date" style="width: 20%;" class="aspNetDisabled form-control form-control-sm" readonly>';
                          echo '<label for="listavalor_orcamento">R$: </label>';
                          echo '<input value="'.$row_orcamento['vcusto_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
                          echo '<label for="listaremover_orcamento"></label>';
                          echo '<input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                        
                          $vcusto_orcamento = $vcusto_orcamento + $row_orcamento['vcusto_orcamento'];
                          $vpag_orcamento += $row_orcamento['vpag_orcamento'];
                          $_SESSION['vcusto_orcamento'] = $vcusto_orcamento;
                          $_SESSION['vtotal_orcamento'] = $vcusto_orcamento;
                          $_SESSION['vpag_servico'] = $vpag_orcamento;
                          echo '</div>';
                          echo '</div>';
                          echo '</form>';
                          echo '</div>';
                        }
                        
                        $select_pagamentos = "SELECT * FROM tb_movimento_financeiro WHERE cd_cliente_comercial = '".$_SESSION['cd_cliente_comercial']."'";
                        if(!$result_pagamentos = mysqli_query($conn, $select_pagamentos)){
                          echo "<script>window.alert('Erro ao consultar o movimento financeiro na tb_movimento_financeiro!');</script>"; 
                        }
                        while($row_pagamentos = $result_pagamentos->fetch_assoc()) {
                          $_SESSION['vpag_servico'] = $_SESSION['vpag_servico'] + $row_pagamentos['valor_movimento'];
                        }

                        $_SESSION['falta_pagar_servico'] = 0;
                        $select_orcamento = "SELECT * FROM tb_orcamento_servico WHERE cd_cliente_comercial = '".$_SESSION['cd_cliente_comercial']."'";
                        if(!$result_orcamento = mysqli_query($conn, $select_orcamento)){
                          echo "<script>window.alert('Erro ao consultar uma fatura na tb_movimento_financeiro!');</script>"; 
                        }
                        while($row_orcamento = $result_orcamento->fetch_assoc()) {
                          $_SESSION['falta_pagar_servico'] = $_SESSION['vpag_servico'] + $row_orcamento['vcusto_orcamento'];
                        }
                        //$_SESSION['falta_pagar_servico']

                        ////echo '</div>';
                        ////echo '</div>';
                        ////echo '</div>';
                        ////echo '</div>';
                        ////echo '</div>';
                        
                        
                        echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6; display:none;">';
                        echo '<div class="horizontal-form">';
                        echo '<div class="form-group">';
                                    
                        //$_SESSION['falta_pagar_servico'] = $_SESSION['vtotal_orcamento'] - $_SESSION['vpag_servico'];
                        echo '<label for="cadobs_servico">Total:</label>';
                        echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                        echo '<label for="cadobs_servico">Falta:</label>';
                        echo '<input value="'.$_SESSION['fatura_devida_cliente_fiscal'].'" type="tel" name="btn_falta_pagar_orcamento" id="btn_falta_pagar_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                                      
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                
                                    
                                    
                                    
                
                        if($vcusto_orcamento == 0){
                        }else{
                          echo '<form method="POST">';
                          echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="totalizador" name="totalizador" style="display: none;">';
                          echo '<label for="btncd_servico">CD_CLIENTE_COMERCIAL</label>';
                          echo '<input value="'.$_SESSION['cd_cliente_comercial'].'" type="tel" name="btncd_cliente_comercial" id="btncd_cliente_comercial" class="aspNetDisabled form-control form-control-sm">';
                          echo '</div>';
                          echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6;">';
                          echo '<div class="horizontal-form">';
                          echo '<div class="form-group">';
                          if($vpag_orcamento == $vcusto_orcamento){
                            echo '<label for="cadobs_servico">Total Pago:</label>';
                            echo '<input value="'.$vpag_orcamento.'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                          }else{
                            $_SESSION['falta_pagar_servico'] = $vcusto_orcamento - $_SESSION['vpag_servico'];
                            echo '<label for="cadobs_servico">Total:</label>';
                            echo '<input value="'.$vcusto_orcamento.'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                            echo '<label for="cadobs_servico">Pago:</label>';
                            echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                            echo '<label for="cadobs_servico">Falta:</label>';
                            echo '<input value="'.$_SESSION['falta_pagar_servico'].'" type="tel" name="btn_falta_pagar_orcamento" id="btn_falta_pagar_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                            //echo '<label for="lancarPagamento"></label>';
                            //echo '<input type="submit" name="lancarPagamento" id="lancarPagamento" class="btn btn-success"">';
                          }
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';

                        }          
                        
                        echo '</form>';           
                        $_SESSION['tela_movimento_financeiro'] = "VENDA_SERVICO";

                        echo '<div class="col-12 grid-margin stretch-card btn-success">';//
                        echo '<div class="card">';
                        include("../md_caixa/movimento_financeiro.php");         
                        echo '</div>';
                        echo '</div>';

                        echo '<form action="impresso.php" method="POST" target="_blank">';
                        echo '<div class="card-body" id="formBtn"><!--FORMULÁRIO DOS BOTOES-->';
                        echo '<div class="kt-portlet__body">';
                        echo '<div class="row">';
                        echo '<div class="col-12 col-md-12">';
                        echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                        //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                        echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" style="display:none;">';
                        echo '<input value="'.$_SESSION['os_cliente'].'" name="btncd_cliente" type="text" id="cadcd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                        echo '<label for="btnpnome_cliente">Nome</label>';
                        echo '<input value="'.$_SESSION['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                        echo '<label for="btnsnome_cliente">sobrenome</label>';
                        echo '<input value="'.$_SESSION['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                        echo '<label for="btntel_cliente">Telefone</label>';
                        echo '<input value="'.$_SESSION['tel_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm"/>';
                        echo '</div>';
                                            
                        //echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                        echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="display: none;">';
                        echo '<label for="btncd_servico">OS</label>';
                        echo '<input value="'.$_SESSION['os_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" class="aspNetDisabled form-control form-control-sm">';
                        echo '<label for="btnobs_servico">Descrição Geral</label>';
                        echo '<input value="'.$_SESSION['obs_servico'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="Caracteristica geral do serviço">';
                        echo '<label for="btnprioridade_servico">Prioridade</label>';
                        echo '<select name="btnprioridade_servico" id="btnprioridade_servico"  class="aspNetDisabled form-control form-control-sm">';
                        echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >'.$_SESSION['prioridade_servico'].'</option>';
                        echo '</select>';
                        echo '<!--<label for="btnprazo_servico">Entrada</label>-->';
                        echo '<input value="'.$_SESSION['entrada_servico'].'" name="btnentrada_servico" type="datetime-local" id="btnentrada_servico" class="aspNetDisabled form-control form-control-sm" />';
                        echo '<label for="btnprazo_servico">Prazo</label>';
                        echo '<input value="'.$_SESSION['prazo_servico'].'" name="btnprazo_servico" type="datetime-local" id="btnprazo_servico" class="aspNetDisabled form-control form-control-sm"/>';
                        echo '</div>';
                                    
                        echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6; display:none;">';
                        echo '<div class="horizontal-form">';
                        echo '<div class="form-group">';
                        echo '<label for="cadobs_servico">Total</label>';
                        echo '<input value="999'.$_SESSION['vtotal_orcamento'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                        echo '<label for="cadobs_servico">Pago</label>';
                        echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" placeholder="Valor Pago">';
                        echo '<label for="lancarPagamento"></label>';
                        echo '<input type="submit" name="lancarPagamento" id="lancarPagamento" class="btn btn-success"">';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                                    
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                                    
                                            
                                            
                        //echo '<button type="submit" name="lancarOrcamento" class="btn btn-success">LançarOrcamento</button>';
                        echo '<button type="submit" name="imprimir_os" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Imprimir OS</button>';
                        echo '<button type="submit" name="via_cliente" class="btn btn-block btn-lg btn-info" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Impressão)</button>';
                        echo '<button type="button" class="btn btn-block btn-lg btn-success" onclick="enviarMensagemWhatsApp()" style="margin-top: 20px; margin-bottom: 20px;">Via do Cliente (Whatsapp)</button>';
                        //echo '<button type="submit" class="btn btn-danger" name="limparCadastro" style="margin: 5px;">Novo Serviço</button>';
                                            
                                    
                        echo '</div>';
                        echo '</form>';
                        echo '<form method="post">';
                        echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="CancelarCadastro" style="margin-top: 20px; margin-bottom: 20px;">Novo Serviço</button>';
                        echo '</form>';
                
                                    
                                  
                      }
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';

                    }else{
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                      echo '<script>document.getElementById("cadastroCliente").style.display = "block";</script>';
                      echo '<script>document.getElementById("cadcnpj_cliente_comercial").value = "'. $_SESSION['concnpj_cliente_comercial'] .'";</script>';
                      echo '<script>document.getElementById("caddtcadastro_cliente_comercial").value = "'. date('Y-m-d') .'";</script>';
                      echo '<script>document.getElementById("caddtvalidlicenca_cliente_comercial").value = "' .date('Y-m-d', strtotime('+1 month')). '";</script>';
                    }
                  }
                ?>     
                
                
                


                
                
              

                

              </div>
            </div>
          </div>
        
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
  mensagem += "Somos da *<?php echo $_SESSION['nfantasia_filial'];?>* e ficamos no endereço *<?php echo $_SESSION['endereco_filial'];?>*.\n\n";
                            
  mensagem += "Sua ordem de serviço de número *OS" + numeroOS + "*, deu entrada em nossa loja *" + entradaOrganizada + "*.\n";
  mensagem += "Descrição da atividade: " + observacoesServico + "\n";
  //mensagem += "Prioridade Requerida: *" + prioridadeOrganizada + "*\n";
  mensagem += "O prazo previsto para entrega é: *" + prazoOrganizado + "*\n\n";
  <?php 
  

  $select_orcamento_whatsapp = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['os_servico']."' ORDER BY cd_orcamento ASC";
  $result_orcamento_whatsapp = mysqli_query($conn, $select_orcamento_whatsapp);
  echo 'mensagem += "*Lista detalhada*\n";';
                        
  while($row_orcamento_whatsapp = $result_orcamento_whatsapp->fetch_assoc()) {
    $counter = $counter + 1;
    //echo 'mensagem += count + " - '.$row_orcamento_whatsapp['titulo_orcamento'].' - '.$row_orcamento_whatsapp['vcusto_orcamento'].'"\n";';
    ?>mensagem += "<?php echo '*'.$counter.'* - '.$row_orcamento_whatsapp['titulo_orcamento'].' - R$:'.$row_orcamento_whatsapp['vcusto_orcamento']; ?>\n";<?php
  }
  echo 'mensagem += "\n";';


  ?>
  if(faltaPagar > 0 ){
    mensagem += "Total: *R$:" + vtotalServico + "*\n";
    //mensagem += "Valor pago: R$:*" + vpagServico + "*\n";
    mensagem += "Falta pagar: R$:" + faltaPagar + "*\n\n";
  }else if(faltaPagar < 0){
    mensagem += "Voce tem cupom de: *R$:" + faltaPagar + "* conosco!\n\n";
  }else{
    mensagem += "Total Pago: R$:*" + vpagServico + "*\n";
  }
  //mensagem += "Total: *R$:" + vtotalServico + "*\n";
  //mensagem += "Valor pago: R$:*" + vpagServico + "*\n";
  //mensagem += "Falta pagar: R$:" + faltaPagar + "*\n\n";

  mensagem += "\n __________________________________\n";
  <?php
    echo 'mensagem += "Acompanhe seu histórico pelo link:\n'.$_SESSION['dominio'].'pages/md_assistencia/acompanha_servico.php?cnpj='.$_SESSION['cnpj_empresa'].'&tel=" + telefoneCliente + "\n";';
  ?>
  mensagem += "\n __________________________________\n";


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

<script>
                          function generatePDF() {
                            // Crie uma instância do objeto jsPDF
                            var doc = new jsPDF();

                            // Defina os campos do formulário
                            var nome = document.getElementById("cadpnome_cliente").value;
                            var sobrenome = document.getElementById("cadsnome_cliente").value;
                            var telefone = document.getElementById("cadtel_cliente").value;

                            var cdServico = document.getElementById("cadcd_servico").value;
                            var tituloServico = document.getElementById("cadtitulo_servico").value;
                            var obsServico = document.getElementById("cadobs_servico").value;
                            var prioridadeServico = document.getElementById("cadprioridade_servico").value;
                            var prazoServico = document.getElementById("cadprazo_servico").value;
                            var orcamentoServico = document.getElementById("cadorcamento_servico").value;
                            var vpagServico = document.getElementById("cadvpag_servico").value;

                            // Defina as posições da tabela no documento
                            var startX = 10;
                            var startY = 10;
                            var rowHeight = 10;
                            var columnWidth = 40;

                            // Defina a estrutura da tabela
                            var rows = [
                              ["Nome", "Sobrenome", "Telefone", "cadcd_servico", "cadtitulo_servico", "cadobs_servico", "cadprioridade_servico","cadprazo_servico", "cadorcamento_servico", "cadvpag_servico"],
                              [nome, sobrenome, telefone, cadcd_servico, cadtitulo_servico, cadobs_servico, cadprioridade_servico, cadprazo_servico, cadorcamento_servico, cadvpag_servico]
                            ];

                            // Adicione a tabela ao documento PDF
                            for (var i = 0; i < rows.length; i++) {
                              var rowData = rows[i];
                              for (var j = 0; j < rowData.length; j++) {
                                doc.text(startX + j * columnWidth, startY + (i + 1) * rowHeight, rowData[j]);
                              }
                            }

                              // Salve ou abra o arquivo PDF
                            doc.save("formulario.pdf");
                          }
                        </script>

<script>
    var data = new Date();
    var mes = data.getMonth() + 1;
    var dia = data.getDate();
    var ano = data.getFullYear();
    var hora = data.getHours();
    var minuto = data.getMinutes();

    document.getElementById("data_hora_ponto").value = `${ano}-${mes.toString().padStart(2, '0')}-${dia.toString().padStart(2, '0')}T${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}`;
</script>


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