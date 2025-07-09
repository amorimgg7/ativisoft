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
                          
                          <input placeholder="Ordem de Serviço" type="tel" name="concd_venda" id="concd_venda" type="tel" maxlength="10" class="aspNetDisabled form-control form-control-sm" required>
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
                    $_SESSION['cd_venda'] = 0;
                    $_SESSION['vcusto_orcamento'] = 0;
                    $_SESSION['vpag_servico'] = 0;
                    
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                    
                    
                  }else{
                    if(!isset($_SESSION['cd_venda'])){
                      $_SESSION['cd_venda'] = 0;
                    }
                  }
                

                  if(isset($_POST['pagar_servico'])){

                    $retorno = $f->movimentoFinanceiro(
                                'R',
                                $_SESSION['cd_empresa'],
                                $_SESSION['cd_caixa'],
                                $_SESSION['cd_cliente'],
                                $_SESSION['cd_colab'],
                                $_SESSION['cd_venda'],
                                '',
                                $_POST['fpag_movimento'],
                                $_POST['vpag_movimento']
                              );

                    if($retorno['status'] == 'OK'){
                      echo "<script>alert('Total pago: " . $retorno['servico_vpag'] . "');</script>";
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
                      $_POST['atividadecd_venda'],
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


                  if(isset($_POST['concd_venda']) || $_SESSION['cd_venda'] > 0){
                    if(isset($_POST['concd_venda'])){
                      $_SESSION['cd_venda'] = $_POST['concd_venda'];
                    }

                    $select_servico = "SELECT * FROM tb_venda WHERE cd_venda = '".$_SESSION['cd_venda']."' AND cd_filial = '".$_SESSION['cd_empresa']."'";
                    $result_servico = mysqli_query($conn, $select_servico);
                    $row_servico = mysqli_fetch_assoc($result_servico);
                    // Exibe as informações do usuário no formulário
                    if($row_servico) {
                      $_SESSION['cd_cliente'] = $row_servico['cd_cliente'];
                      $_SESSION['venda'] = $row_servico['cd_venda'];
                      $_SESSION['cd_venda'] = $row_servico['cd_venda'];

                    }else{
                      echo "<script>alert('Serviço (".$_SESSION['cd_venda']."), não encontrado');</script>";

                      $_SESSION['cd_cliente'] = 0;
                      $_SESSION['cd_venda'] = 0;
                      $_SESSION['vcusto_orcamento'] = 0;
                      $_SESSION['vpag_servico'] = 0;
                    }

                    
                  }
                  
                 //página se for consultado servico
                  if(isset($_SESSION['cd_venda']) && $_SESSION['cd_venda']  > 0){


                      $result_venda       = $u->conVenda('CV', $_SESSION['cd_venda'], $_SESSION['cd_empresa']);
                        $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_venda['cd_cliente']);
                        $result_orcamento   = $u->listOrcamentoVenda($result_venda['cd_venda'], $_SESSION['cd_empresa'], false);
                        $result_financeiro  = $u->movimentoFinanceiro($_SESSION['dt_caixa'], $_SESSION['cd_empresa'], $_SESSION['cd_venda'], '', $result_orcamento['falta_pagar']);
                        $result_impressao   = $u->impressao1($_SESSION['tipo_impressao'], 'VENDA', $_SESSION['cd_empresa'], $_SESSION['cd_venda']);
                        $result_mensagem   = $u->mensagem1($_SESSION['tipo_mensagem'], 'VENDA', $_SESSION['cd_empresa'], $_SESSION['cd_venda']);
                        echo '<script>document.getElementById("consulta").style.display = "none";</script>';

                        //echo '<p>Cliente</p>';
                        //echo $result_cliente['partial_cliente'];
                        
                        //echo '<p>Venda</p>';
                        echo $result_venda['partial_venda']; 
     
                        //echo '<p>Orcamento</p>';
                        echo $result_orcamento['partial_orcamento']; 
                        
                        //echo '<p>Financeiro</p>';
                        echo $result_financeiro['partial_financeiro'];
                            
                        echo $result_mensagem['partial_mensagem']; 


                        //echo '<p>Impressão</p>';
                        echo $result_impressao['partial_impressao'];
                            

        

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