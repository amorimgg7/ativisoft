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
  <link rel="stylesheet" href="../../css/custom.css">
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
                      $insertcontrato = "INSERT INTO tb_contrato_servico(cd_cliente_comercial, titulo_contrato, vcusto_contrato, status_contrato) VALUES(
                        '".$_SESSION['cadcd_cliente_comercial']."',
                        '".$_POST['data_fatura']."',
                        '".$_POST['vcusto_fatura']."',
                        '0')
                      ";
                      if(!mysqli_query($conn, $insertcontrato)){
                        echo "<script>window.alert('Erro ao lançar a fatura na TB_contrato_SERVICO!');</script>"; 
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

                  if(isset($_POST['pagar'])){//pagar a fatura
                    $insert_pagar = "INSERT INTO tb_movimento_financeiro(tipo_movimento, cd_caixa_movimento, cd_cliente_comercial, cd_colab_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES(
                        1,
                        '".$_SESSION['cd_caixa']."',
                        '".$_SESSION['cd_cliente_comercial']."',
                        '".$_SESSION['cd_colab']."',
                        '".$_POST['fpag_movimento']."',
                        '".$_POST['vpag_movimento']."',
                        now(),
                        'PAGAMENTO DA FATURA DO CLIENTE: ".$_SESSION['cd_cliente_comercial']."'
                         )
                     ";
                    mysqli_query($conn, $insert_pagar);
                    //echo "<script>window.alert('Movimento Financeiro Lançado!');</script>";
                    
                    $fechar_caixa = "UPDATE tb_cliente_comercial SET
                        fatura_devida_cliente_fiscal = '".($_SESSION['fatura_devida_cliente_fiscal'] - $_POST['vpag_movimento'])."'
                        WHERE cd_cliente_comercial = ".$_SESSION['cd_cliente_comercial']."";
                        if(!mysqli_query($conn, $fechar_caixa)){
                          echo "<script>window.alert('Erro ao lançar na tb_cliente_comercial!');</script>";
                        }
                        
                        $_SESSION['vpag_servico'] = $_POST['vpag_movimento'] - $_SESSION['fatura_devida_cliente_fiscal'];
                        $_SESSION['falta_pagar_servico'] = $_SESSION['vtotal_contrato'] - $_SESSION['vpag_servico'];
                        echo  '<script>document.getElementById("btn_falta_pagar_contrato").value = "'.$_SESSION['fatura_devida_cliente_fiscal'].'";</script>';
        
                        if($_SESSION['fatura_devida_cliente_fiscal'] == 0){
                            echo '<script>document.getElementById("tela_pagamento").style.display = "none";</script>';//tela_pagamento
                        }
                        //$_SESSION['cd_servico'] = 0;
                        //$_SESSION['cd_servico'] = 0;
                        //$_SESSION['cd_cliente'] = 0;
                        //echo '<script>location.href="../../index.php";</script>';
                  }

                  if(isset($_POST['listaremover_contrato'])) {//DELETE FROM `tb_contrato_servico` WHERE `tb_contrato_servico`.`cd_contrato` = 198
                    if(($_SESSION['vtotal_contrato'] - $_POST['listavalor_contrato'])>=$_SESSION['vpag_servico']){
                      //echo "<script>window.alert('OK, pode remover');</script>";
                      //$vtotal = $_SESSION['falta_pagar_servico'] - $_POST['listavalor_contrato'];
                      $removecontrato = "DELETE FROM `tb_contrato_servico` WHERE `tb_contrato_servico`.`cd_contrato` = ".$_POST['listaid_contrato']."";
                      if(!mysqli_query($conn, $removecontrato)){
                        echo "<script>window.alert('Erro ao deletar da tb_contrato_servico!');</script>";  
                      }
                      $fatura = $_SESSION['falta_pagar_servico'] - $_POST['listavalor_contrato'];

                      $dtvalidlicenca_cliente_comercial = date('Y-m-d', strtotime('-1 month', strtotime($_POST['listatitulo_contrato'])));

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
                              <input  name="cadcd_cliente_comercial" type="hidden" id="cadcd_cliente_comercial" class="aspNetDisabled form-control form-control-sm" style="display: block;" readonly/>
                              <div class="form-group-custom">
                              <label for="cadrsocial_cliente_comercial">Razão Social</label>
                              <input name="cadrsocial_cliente_comercial" type="text" id="cadrsocial_cliente_comercial" maxlength="100"   class="aspNetDisabled form-control form-control-sm" required/>
                              </div>
                              
                              <div class="form-group-custom">
                              <label for="cadnfantasia_cliente_comercial">Nome Fantasia</label>
                              <input name="cadnfantasia_cliente_comercial" type="text" id="cadnfantasia_cliente_comercial" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>
                              </div>
                              
                              <div class="form-group-custom">
                              <label for="cadcnpj_cliente_comercial">CNPJ</label>
                              <input name="cadcnpj_cliente_comercial" type="text" id="cadcnpj_cliente_comercial" maxlength="90" oninput="cnpj(this)" class="aspNetDisabled form-control form-control-sm" readonly/>                            
                              </div>
                              
                              <div class="form-group-custom">
                              <label for="btntel_cliente">Data do Vencimento</label>
                              <input name="caddtvalidlicenca_cliente_comercial" type="date" id="caddtvalidlicenca_cliente_comercial" class="aspNetDisabled form-control form-control-sm" required/>
                              </div>
                              
                              <div class="form-group-custom">
                              <label for="btntel_cliente">Observações dos contatos</label>
                              <input name="cadobs_cliente_comercial" type="text"  id="cadobs_cliente_comercial" class="aspNetDisabled form-control form-control-sm"/>
                              </div>
                              
                              <div class="form-group-custom">
                              <label for="btntel_cliente">Telefone Filial</label>
                              <input name="cadtel_cliente_comercial" type="tel"  id="cadtel_cliente_comercial" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" required/>
                              </div>
                              
                              <div class="form-group-custom">
                              <label for="btntel_cliente">Email Filial</label>
                              <input name="cademail_cliente_comercial" type="email"  id="cademail_cliente_comercial" class="aspNetDisabled form-control form-control-sm" required/>
                              </div>
                              
                              <div class="form-group-custom">
                              <label for="btntel_cliente">Fatura Prevista</label>
                              <input name="cadfatura_prevista_cliente_fiscal" type="tel"  id="cadfatura_prevista_cliente_fiscal" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly required/>
                              </div>
                              
                              <div class="form-group-custom">
                              <label for="btntel_cliente">Fatura Devida</label>
                              <input name="cadfatura_devida_cliente_fiscal" type="tel"  id="cadfatura_devida_cliente_fiscal" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly required/>
                              </div>
                              
                              <td><button type="hidden" name="cad_cliente_comercial" id="cad_cliente_comercial" class="btn btn-block btn-outline-success"><i class="icon-cog">Gravar</i></button></td>
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
                    //echo "<script>window.alert('...');</script>";

                  }
                  if($_SESSION['concnpj_cliente_comercial'] > 0) { //CHAMAR CLIENTE CADASTRADO PARA SESSION
                    //echo "<script>window.alert('.".$_SESSION['concnpj_cliente_comercial'].".');</script>";

                    $result_empresa = $u->conEmpresa('CCNPJ', $_SESSION['concnpj_cliente_comercial'], true);
                    echo $result_empresa['partial_empresa'];

                    $select_cliente_comercial = "SELECT * FROM tb_empresa WHERE cnpj_empresa = '".$_SESSION['concnpj_cliente_comercial']."' LIMIT 1";
                    //$select_cliente_comercial = "SELECT * FROM tb_empresa WHERE cnpj_empresa = '".$_SESSION['concnpj_cliente_comercial']."' ORDER BY cd_empresa DESC";
                    $result_cliente_comercial = mysqli_query($conn, $select_cliente_comercial);
                    $row_cliente_comercial = mysqli_fetch_assoc($result_cliente_comercial);
                    // Exibe as informações do usuário no formulário
                    if($row_cliente_comercial) {
                      
                      echo "<script>window.alert('.".$_SESSION['concnpj_cliente_comercial'].".');</script>";

                      //echo "<script>window.alert('Cliente encontrado!');</script>";
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                      echo '<script>document.getElementById("cadastroCliente").style.display = "block";</script>';
                      $_SESSION['cd_cliente_comercial'] = $row_cliente_comercial['cd_empresa'];
                      $_SESSION['servico'] = 0;
                      $data_fatura_prevista = date('Y-m-d', strtotime('+1 month', strtotime($row_cliente_comercial['dt_validade'])));
                      echo '<script>document.getElementById("cadcd_cliente_comercial").value = "'. $row_cliente_comercial['cd_empresa'] .'";</script>';
                      $_SESSION['cd_empresa'] = $row_cliente_comercial['cd_empresa'];
                      echo '<script>document.getElementById("cadrsocial_cliente_comercial").value = "'. $row_cliente_comercial['rsocial_empresa'] .'";</script>';
                      echo '<script>document.getElementById("cadnfantasia_cliente_comercial").value = "'. $row_cliente_comercial['nfantasia_empresa'] .'";</script>';
                      echo '<script>document.getElementById("cadcnpj_cliente_comercial").value = "'. strval($row_cliente_comercial['cnpj_empresa']) .'";</script>';
                      //echo '<script>document.getElementById("caddtcadastro_cliente_comercial").value = "' . date('Y-m-d', strtotime($row_cliente_comercial['dtcadastro_cliente_comercial'])) . '";</script>';
                      echo '<script>document.getElementById("caddtvalidlicenca_cliente_comercial").value = "' . date('Y-m-d', strtotime($row_cliente_comercial['dt_validade'])) .'";</script>';
                      echo '<script>document.getElementById("cadobs_cliente_comercial").value = "'. $row_cliente_comercial['ds_contrato'] .'";</script>';
                      echo '<script>document.getElementById("cadtel_cliente_comercial").value = "'. $row_cliente_comercial['tel1_empresa'] .'";</script>';
                      echo '<script>document.getElementById("cademail_cliente_comercial").value = "'. $row_cliente_comercial['email_empresa'] .'";</script>';
                      //echo '<script>document.getElementById("cadobs_tel_cliente_comercial").value = "'. $row_cliente_comercial['obs_tel1_empresa'] .'";</script>';
                      echo '<script>document.getElementById("cadfatura_prevista_cliente_fiscal").value = "'. $row_cliente_comercial['vl_licenca'] .'";</script>';
                      echo '<script>document.getElementById("cadfatura_devida_cliente_fiscal").value = "'. $row_cliente_comercial['vl_contrato'] .'";</script>';
                      
                      echo '<div class="card-body" '.$_SESSION['c_card'].'>';
                      echo '<div class="kt-portlet__body">';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div  class="nc-form-tac">';
                      
                      if($row_cliente_comercial['cd_empresa'] > 0){
                        $select_contrato = "SELECT * FROM tb_contrato WHERE cd_empresa = '".$_SESSION['cd_cliente_comercial']."' ORDER BY cd_contrato ASC";
                        $result_contrato = mysqli_query($conn, $select_contrato);
                                                      
                        echo '
                        <h3 class="kt-portlet__head-title">Lançar novo Contrato</h3>
                        <script>document.getElementById("listaContrato").style.display = "block";</script>
                        <form method="post">
                          <div class="typeahead" style="background-color: #C6C6C6;">
                            <div class="horizontal-form">
                              <div class="form-group">
                                <label for="data_fatura"></label>
                                <input value="'.$data_fatura_prevista.'"type="date" style="width: 20%;" name="data_fatura" id="data_fatura" class="form-control form-control-sm">
                                <label for="vcusto_fatura"></label>
                                <input type="tel" oninput="tel(this)" id="vcusto_fatura" name="vcusto_fatura" class="form-control form-control-sm" placeholder="Quanto custa este serviço?">
                                <label for="lancarFatura"></label>
                                <button type="submit" name="lancarFatura" id="lancarFatura" class="btn btn-success">Enviar</button>
                              </div>
                            </div>
                          </div>
                        </form>
                        <h3 class="kt-portlet__head-title">Contratos gerados</h3>';
                        $_SESSION['vtotal_contrato'] = 0;
                        $_SESSION['vpag_contrato'] = 0;
                        $count = 0;
                        $vcusto_contrato = 0;
                        $vpag_contrato = 0;
                        $_SESSION['vpag_servico'] = 10;
                        while($row_contrato = $result_contrato->fetch_assoc()) {
                          $count = $count + 1;
                          
                          // Criando os objetos DateTime para as datas de contrato e validade
                          $data_inicial = new DateTime($row_contrato['dt_contrato']);
                          $data_final = new DateTime($row_contrato['dt_validade']);

                          // Calculando a diferença entre as duas datas
                          $intervalo = $data_inicial->diff($data_final);

                          // Obtendo os anos e meses da diferença
                          $anos = $intervalo->y;
                          $meses = $intervalo->m;

                          // Exibindo a diferença no formato desejado
                          $vigencia = ($anos > 0 ? $anos . ' ano' . ($anos > 1 ? 's' : '') : '') .
                                      ($anos > 0 && $meses > 0 ? ' e ' : '') .
                                      ($meses > 0 ? $meses . ' mês' . ($meses > 1 ? 'es' : '') : '');

                                      
                          $status_contrato = $row_contrato['status_contrato'];

                          switch ($status_contrato) {
                              case 'A':
                                  $ds_status_contrato = "Aberto";
                                  break;
                              case 'F':
                                  $ds_status_contrato = "Fechado";
                                  break;
                              case 'C':
                                  $ds_status_contrato = "Cancelado";
                                  break;
                              default:
                                  $ds_status_contrato = "Desconhecido";
                                  break;
                          }
                          //echo '<div name="listaContrato" id="listaContrato" class="typeahead" '.$_SESSION['c_card'].'>';
                          echo '
                          <form method="POST">
                            <div class="horizontal-wrapper">
                              <div class="horizontal-id">#'.$count.'/'.$row_contrato['cd_contrato'].' </div>
                              <input value="'.$row_contrato['cd_contrato'].'" name="listaid_contrato" id="listaid_contrato" class="form-control form-control-sm" style="display:none;" readonly>
                              <div class="horizontal-content">
                                <div class="form-group-custom full-width">
                                  <label for="listatitulo_contrato">Descrição</label>
                                  <input value="'.$row_contrato['ds_contrato'].'" name="listatitulo_contrato" id="listatitulo_contrato" type="text" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="horizontal-form-custom">
                                  <div class="form-group-custom">
                                  <label for="listavigencia_contrato">Vigência (' . $vigencia . ')</label>
                                  <input value="'.date('d/m/Y', strtotime($row_contrato['dt_contrato'])).' a '.date('d/m/Y', strtotime($row_contrato['dt_validade'])).'" name="listavigencia_contrato" id="listavigencia_contrato" type="tel" class="form-control form-control-sm" readonly>
                                  </div>
                                  <div class="form-group-custom">
                                  <label for="listavalor_licenca">Valor da Licença</label>
                                  <input value="'.$row_contrato['vl_licenca'].'" name="listavalor_licenca" id="listavalor_licenca" type="tel" class="form-control form-control-sm" readonly>
                                  </div>                       
                                  <div class="form-group-custom">
                                  <label for="listavalor_contrato">Valor do contrato</label>
                                  <input value="'.$row_contrato['vl_contrato'].'" name="listavalor_contrato" id="listavalor_contrato" type="tel" class="form-control form-control-sm" readonly>
                                  </div>
                                  <div class="form-group-custom">
                                  <label for="listastatus_contrato">Status</label>
                                  <input value="'.$ds_status_contrato.'" name="listastatus_contrato" id="listastatus_contrato" type="text" class="form-control form-control-sm" placeholder="" readonly>
                                  </div>
                                </div>
                              </div>
                              <input class="horizontal-action" type="submit" value="Editar">
                            </div>
                          ';
                          
                          $vcusto_contrato = $vcusto_contrato + $row_contrato['vcusto_contrato'];
                          $vpag_contrato += $row_contrato['vpag_contrato'];
                          $_SESSION['vcusto_contrato'] = $vcusto_contrato;
                          $_SESSION['vtotal_contrato'] = $vcusto_contrato;
                          $_SESSION['vpag_servico'] = $vpag_contrato;
                          //echo '</div>';
                          //echo '</div>';
                          echo '</form>';
                          //echo '</div>';
                        }
                        
                        $select_pagamentos = "SELECT * FROM tb_movimento_financeiro WHERE cd_cliente_comercial = '".$_SESSION['cd_cliente_comercial']."'";
                        if(!$result_pagamentos = mysqli_query($conn, $select_pagamentos)){
                          echo "<script>window.alert('Erro ao consultar o movimento financeiro na tb_movimento_financeiro!');</script>"; 
                        }
                        while($row_pagamentos = $result_pagamentos->fetch_assoc()) {
                          $_SESSION['vpag_servico'] = $_SESSION['vpag_servico'] + $row_pagamentos['valor_movimento'];
                        }

                        $_SESSION['falta_pagar_servico'] = 0;
                        $select_contrato = "SELECT * FROM tb_contrato_servico WHERE cd_cliente_comercial = '".$_SESSION['cd_cliente_comercial']."'";
                        if(!$result_contrato = mysqli_query($conn, $select_contrato)){
                          echo "<script>window.alert('Erro ao consultar uma fatura na tb_movimento_financeiro!');</script>"; 
                        }
                        while($row_contrato = $result_contrato->fetch_assoc()) {
                          $_SESSION['falta_pagar_servico'] = $_SESSION['vpag_servico'] + $row_contrato['vcusto_contrato'];
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
                                    
                        //$_SESSION['falta_pagar_servico'] = $_SESSION['vtotal_contrato'] - $_SESSION['vpag_servico'];
                        echo '<label for="cadobs_servico">Total:</label>';
                        echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_contrato" id="btnvpag_contrato" class="aspNetDisabled form-control form-control-sm" readonly>';
                        echo '<label for="cadobs_servico">Falta:</label>';
                        echo '<input value="'.$_SESSION['fatura_devida_cliente_fiscal'].'" type="tel" name="btn_falta_pagar_contrato" id="btn_falta_pagar_contrato" class="aspNetDisabled form-control form-control-sm" readonly>';
                                      
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                
                                    
                                    
                                    
                
                        if($vcusto_contrato == 0){
                        }else{
                          echo '<form method="POST">';
                          echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="totalizador" name="totalizador" style="display: none;">';
                          echo '<label for="btncd_servico">CD_CLIENTE_COMERCIAL</label>';
                          echo '<input value="'.$_SESSION['cd_cliente_comercial'].'" type="tel" name="btncd_cliente_comercial" id="btncd_cliente_comercial" class="aspNetDisabled form-control form-control-sm">';
                          echo '</div>';
                          echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6;">';
                          echo '<div class="horizontal-form">';
                          echo '<div class="form-group">';
                          if($vpag_contrato == $vcusto_contrato){
                            echo '<label for="cadobs_servico">Total Pago:</label>';
                            echo '<input value="'.$vpag_contrato.'" type="tel" name="btnvpag_contrato" id="btnvpag_contrato" class="aspNetDisabled form-control form-control-sm" readonly>';
                          }else{
                            $_SESSION['falta_pagar_servico'] = $vcusto_contrato - $_SESSION['vpag_servico'];
                            echo '<label for="cadobs_servico">Total:</label>';
                            echo '<input value="'.$vcusto_contrato.'" type="tel" name="btnvtotal_contrato" id="btnvtotal_contrato" class="aspNetDisabled form-control form-control-sm" readonly>';
                            echo '<label for="cadobs_servico">Pago:</label>';
                            echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_contrato" id="btnvpag_contrato" class="aspNetDisabled form-control form-control-sm" readonly>';
                            echo '<label for="cadobs_servico">Falta:</label>';
                            echo '<input value="'.$_SESSION['falta_pagar_servico'].'" type="tel" name="btn_falta_pagar_contrato" id="btn_falta_pagar_contrato" class="aspNetDisabled form-control form-control-sm" readonly>';
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
                        echo '<input value="999'.$_SESSION['vtotal_contrato'].'" type="tel" name="btnvtotal_contrato" id="btnvtotal_contrato" class="aspNetDisabled form-control form-control-sm" readonly>';
                        echo '<label for="cadobs_servico">Pago</label>';
                        echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_contrato" id="btnvpag_contrato" class="aspNetDisabled form-control form-control-sm" placeholder="Valor Pago">';
                        echo '<label for="lancarPagamento"></label>';
                        echo '<input type="submit" name="lancarPagamento" id="lancarPagamento" class="btn btn-success"">';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                                    
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                                    
                                            
                                            
                        //echo '<button type="submit" name="lancarcontrato" class="btn btn-success">Lançarcontrato</button>';
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
                      $select_cliente_comercial = "SELECT * FROM tb_empresa WHERE cnpj_empresa = '".$_SESSION['concnpj_cliente_comercial']."' LIMIT 1";
                      //$select_cliente_comercial = "SELECT * FROM tb_empresa WHERE cnpj_empresa = '".$_SESSION['concnpj_cliente_comercial']."' ORDER BY cd_empresa DESC";
                      $result_cliente_comercial = mysqli_query($conn, $select_cliente_comercial);
                      $row_cliente_comercial = mysqli_fetch_assoc($result_cliente_comercial);
                      // Exibe as informações do usuário no formulário
                      if($row_cliente_comercial) {
                        //echo "<script>window.alert('Cliente encontrado!');</script>";
                        echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                        echo '<script>document.getElementById("cadastroCliente").style.display = "block";</script>';
                        $_SESSION['cd_cliente_comercial'] = $row_cliente_comercial['cd_empresa'];
                        //$_SESSION['fatura_devida_cliente_fiscal'] = $row_cliente_comercial['fatura_devida_cliente_fiscal'];
                        $_SESSION['servico'] = 0;
                        //$data_fatura_prevista = date('Y-m-d', strtotime('+1 month', strtotime($row_cliente_comercial['dt_validade'])));
                        echo '<script>document.getElementById("cadcd_cliente_comercial").value = "'. $row_cliente_comercial['cd_empresa'] .'";</script>';
                        $_SESSION['cd_empresa'] = $row_cliente_comercial['cd_empresa'];
                        echo '<script>document.getElementById("cadrsocial_cliente_comercial").value = "'. $row_cliente_comercial['rsocial_empresa'] .'";</script>';
                        echo '<script>document.getElementById("cadnfantasia_cliente_comercial").value = "'. $row_cliente_comercial['nfantasia_empresa'] .'";</script>';
                        echo '<script>document.getElementById("cadcnpj_cliente_comercial").value = "'. strval($row_cliente_comercial['cnpj_empresa']) .'";</script>';
//                        echo '<script>document.getElementById("caddtcadastro_cliente_comercial").value = "' . date('Y-m-d', strtotime($row_cliente_comercial['dtcadastro_cliente_comercial'])) . '";</script>';
                        //echo '<script>document.getElementById("caddtvalidlicenca_cliente_comercial").value = "' . date('Y-m-d', strtotime($row_cliente_comercial['dt_validade'])) .'";</script>';
                        echo '<script>document.getElementById("cadobs_cliente_comercial").value = "Cliente sem contrato";</script>';
                        echo '<script>document.getElementById("cadtel_cliente_comercial").value = "'. $row_cliente_comercial['tel1_empresa'] .'";</script>';
                        echo '<script>document.getElementById("cademail_cliente_comercial").value = "'. $row_cliente_comercial['email_empresa'] .'";</script>';
                        //echo '<script>document.getElementById("cadobs_tel_cliente_comercial").value = "'. $row_cliente_comercial['obs_tel1_empresa'] .'";</script>';



                      }else{
                      
                        echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                        echo '<script>document.getElementById("cadastroCliente").style.display = "block";</script>';
                        echo '<script>document.getElementById("cadcnpj_cliente_comercial").value = "'. $_SESSION['concnpj_cliente_comercial'] .'";</script>';
                        echo '<script>document.getElementById("caddtcadastro_cliente_comercial").value = "'. date('Y-m-d') .'";</script>';
                        echo '<script>document.getElementById("caddtvalidlicenca_cliente_comercial").value = "' .date('Y-m-d', strtotime('+1 month')). '";</script>';
                      }
                    }
                  }
                ?>     
                
                
                


                
                
              

                

              </div>
            </div>
          </div>
        
          <?php

?>




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