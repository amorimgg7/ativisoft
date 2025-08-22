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
                
<?php
  include 'index.php';
?>

                <div class="card-body" id="consulta" <?php echo $_SESSION['c_card'];?> style="display: block;" >
                  <h3 class="card-title"<?php echo $_SESSION['c_card'];?>>Comissões a pagar</h3>
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
                

                  

                  if(isset($_POST['corrige_inconsistencia'])){

                    $retorno = $u->corrigeInconsistencia(
                      $_SESSION['cd_filial'],
                      $_POST['os_corrigir'],
                      '',
                      $_POST['valor_correto'],
                      'FINANCEIRO SERVICO'
                    );

                    if($retorno['status'] == 'OK'){
                      echo "<script>alert('Parametro Corrigido: " . $retorno['param_corrigido'] . "');</script>";
                    }else{
                      echo "<script>alert('| - | - | - | ". $retorno['status'] . " | - | - | - |');</script>";
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

                      $result_servico     = $u->conServico($_SESSION['cd_servico'], $_SESSION['cd_empresa'], false);
                      $result_cliente     = $u->conPessoa('cliente', 'codigo', $result_servico['cd_cliente']);
                      $result_orcamento   = $u->listOrcamentoServico($_SESSION['cd_servico'], $_SESSION['cd_empresa'], false, false);
                      $result_financeiro  = $u->movimentoFinanceiro($_SESSION['dt_caixa'], $_SESSION['cd_empresa'], $_SESSION['cd_servico'], '', $result_orcamento['falta_pagar']);
                      $result_impressao   = $u->impressao1($_SESSION['tipo_impressao'], 'SERVICO', $_SESSION['cd_empresa'], $_SESSION['cd_servico']);
                      $result_mensagem   = $u->mensagem1($_SESSION['tipo_mensagem'], 'SERVICO', $_SESSION['cd_empresa'], $_SESSION['cd_servico']);
                      $result_atividade   = $u->fragAtividade($_SESSION['cd_servico']);

                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';


                      echo $result_servico['partial_servico']; 

                      echo $result_orcamento['partial_orcamento'];

                      echo $result_financeiro['partial_financeiro'];

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