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
                
                <!--<div class="card-body" id="consulta" >
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
                </div>-->

                
                <?php
                  if(isset($_POST['concnpj_cliente_comercial'])){
                    $_SESSION['concnpj_cliente_comercial'] = $_POST['concnpj_cliente_comercial'];
                    //echo "<script>window.alert('...');</script>";

                  }
                  if($_SESSION['concnpj_cliente_comercial'] > 0) { //CHAMAR CLIENTE CADASTRADO PARA SESSION
                    //echo "<script>window.alert('.".$_SESSION['concnpj_cliente_comercial'].".');</script>";

                //echo '<h1>'.$_SESSION['concnpj_cliente_comercial'] .'</h1>';

                    $result_empresa = $u->conEmpresa('CCNPJ', $_SESSION['concnpj_cliente_comercial'], true);
                    if($result_empresa['status'] == 'OK'){
                      echo $result_empresa['partial_empresa'];
                    }else{
                      echo $result_empresa['status'];
                    }

                  }
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