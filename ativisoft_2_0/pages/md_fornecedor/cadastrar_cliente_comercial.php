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
  <title>Empresa</title>
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
                  
                  if (isset($_POST['cadcd_cliente_comercial'])) { // CADASTRAR E CHAMAR CADASTRADO PARA SESSION

                    $cd_empresa = (int) ($_POST['cadcd_cliente_comercial'] ?? 0);

                    // Array de módulos
                    $modulos = [
                        'caixa'       => 'Caixa',
                        'assistencia' => 'Assistência',
                        'venda'       => 'Venda',
                        'patrimonio'  => 'Patrimônio',
                        'folhaponto'  => 'Folha de Ponto',
                        'financeiro'  => 'Financeiro',
                        'cadastro'    => 'Cadastro',
                        'pdv'         => 'PDV',
                        'cameras'     => 'Câmeras',
                    ];
                  
                    // Escapa campos fixos
                    //$rsocial   = mysqli_real_escape_string($conn, $_POST['cadrsocial_cliente_comercial']);
                    //$nfantasia = mysqli_real_escape_string($conn, $_POST['cadnfantasia_cliente_comercial']);
                    //$tel1      = mysqli_real_escape_string($conn, $_POST['cadtel_cliente_comercial']);
                    //$email     = mysqli_real_escape_string($conn, $_POST['cademail_cliente_comercial']);
                    //$obs       = mysqli_real_escape_string($conn, $_POST['cadobs_cliente_comercial'] ?? '');
                    //$obs_tel   = mysqli_real_escape_string($conn, $_POST['cadobs_tel_cliente_comercial'] ?? '');
                    //$dtvalid   = mysqli_real_escape_string($conn, $_POST['caddtvalidlicenca_cliente_comercial'] ?? '');
                    //$fatura_prevista = (float) ($_POST['cadfatura_prevista_cliente_fiscal'] ?? 0);
                    //$fatura_devida   = (float) ($_POST['cadfatura_devida_cliente_fiscal'] ?? 0);
                  
                    if ($cd_empresa > 0) {
                        
                      foreach ($modulos as $key => $label) {
                        // pega o valor enviado (1 ou 0)
                        $ativo = (int) ($_POST["cadmd_{$key}_cliente_comercial"] ?? 0);

                        $param = $ativo && !empty($_POST["cadmd_{$key}_param_cliente_comercial"])
                            ? "'" . mysqli_real_escape_string($conn, $_POST["cadmd_{$key}_param_cliente_comercial"]) . "'"
                            : "NULL";

                        $update_fields[] = "md_$key = $ativo";
                        $update_fields[] = "md_{$key}_param = $param";

                        $update_modulos[] = "md_$key = $ativo";
                        $update_modulos[] = "md_{$key}_param = $param";
                      }

                      // transforma em STRING
                      $update_modulos = implode(", ", $update_modulos);

                      $retCadEmpresa = $u->editEmpresa(
                          '',
                          $_POST['cadcd_cliente_comercial'], 
                          $_POST['cadrsocial_cliente_comercial'], 
                          $_POST['cadnfantasia_cliente_comercial'], 
                          $_POST['cadcnpj_cliente_comercial'], 
                          '', 
                          '', 
                          '', 
                          '', 
                          $_POST['cadtel_cliente_comercial'], 
                          '', 
                          '', 
                          '', 
                          $_POST['cademail_cliente_comercial'], 
                          $_POST['cadsaudacao_cliente_comercial'],
                          $_POST['cadtipo_mensagem_cliente_comercial'],
                          $_POST['cadtipo_impressao_cliente_comercial'],
                          $update_modulos // agora é string
                      );


                        // DEBUG
                        // echo $update_sql;

                        if($retCadEmpresa['status'] == 'OK'){
                            echo "<script>window.alert('Dados atualizados com sucesso!');</script>";
                            echo "<script>window.alert('cd_empresa: ".$retCadEmpresa['cd_empresa']."!');</script>";
                            echo "<script>window.alert('sql_update: ".$retCadEmpresa['sql_update']."!');</script>";
                        }else{
                            echo "<script>window.alert('status: ".$retCadEmpresa['status']."!');</script>";
                            echo "<script>window.alert('sql_update: ".$retCadEmpresa['sql_update']."!');</script>";
                        }
                      
                    } else {
                        // ===== INSERT =====
                        //$cd_cnpj = mysqli_real_escape_string($conn, $_POST['cadcnpj_cliente_comercial']);
                        //$dtcadastro = mysqli_real_escape_string($conn, $_POST['caddtcadastro_cliente_comercial'] ?? date('Y-m-d'));
                    
                        $insert_sql = "
                            INSERT INTO tb_cliente_comercial (
                                rsocial_cliente_comercial, nfantasia_cliente_comercial, cnpj_cliente_comercial,
                                dtcadastro_cliente_comercial, dtvalidlicenca_cliente_comercial, obs_cliente_comercial,
                                tel_cliente_comercial, obs_tel_cliente_comercial, email_cliente_comercial,
                                fatura_prevista_cliente_fiscal, fatura_devida_cliente_fiscal
                            ) VALUES (
                                '$rsocial', '$nfantasia', '$cd_cnpj',
                                '$dtcadastro', '$dtvalid', '$obs',
                                '$tel1', '$obs_tel', '$email',
                                $fatura_prevista, $fatura_devida
                            )
                        ";
                    
                        if (mysqli_query($conn, $insert_sql)) {
                            echo "<script>window.alert('Cliente Cadastrado!');</script>";
                        } else {
                            echo "<script>window.alert('Erro ao cadastrar cliente!');</script>";
                            echo mysqli_error($conn);
                        }
                      
                        // Busca o cadastro recente para SESSION
                        $select_sql = "SELECT * FROM tb_cliente_comercial WHERE cnpj_cliente_comercial = '$cd_cnpj' ORDER BY cd_cliente_comercial DESC LIMIT 1";
                        $result = mysqli_query($conn, $select_sql);
                        $row = mysqli_fetch_assoc($result);
                        if ($row) {
                            $_SESSION['concd_cliente_comercial'] = $row['cd_cliente_comercial'];
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

                  if(isset($_POST['gerarContrato'])) {
                              
                    
                      $retCadContrato = $u->cadContrato(
                        'C1', 
                        $_POST['cd_proprietario_contrato'], 
                        $_POST['cd_empresa_contrato'],
                        $_POST['dt_inicio_contrato'],
                        $_POST['dt_fim_contrato'],
                        $_POST['melhor_dia_pagamento'],
                        $_POST['ds_contrato'],
                        $_POST['pc_mes_contrato'],
                        $_POST['pc_ano_contrato']
                      );
                      
                      if($retCadContrato['status'] == 'OK'){
                        echo "<script>window.alert('Contrato gerado com sucesso!');</script>"; 
                      }else{
                        echo "<script>window.alert('Erro ao lançar o contrato(obs)');</script>"; 
                        echo "<script>window.alert('Erro ao lançar o contrato(".$retCadContrato['status'].")');</script>"; 
                      }           
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

                  $modoEdicao = false;
                  $contratoEditar = null;

if (isset($_POST['listaabrir_edicao'])) {
    $modoEdicao = true;
    $contratoEditar = (int) $_POST['listaid_contrato'];
}


if (isset($_POST['listaedita_contrato'])) {

  $cd_contrato = (int) $_POST['listaid_contrato'];
  $retEditContrato = $u->editContrato((int) $_POST['listaid_contrato'], $_SESSION['cd_cliente_comercial'], $_POST['listads_contrato_'.$cd_contrato], $_POST['listastatus_contrato_'.$cd_contrato]);
    //$novoStatus    = floatval(str_replace(',', '.', ));
    

    // update do orçamento
    /*mysqli_query($conn, "
        UPDATE tb_orcamento_servico
        SET titulo_orcamento = '$novoTitulo',
            vcusto_orcamento = $novoValor
        WHERE cd_orcamento = $cd_orcamento
    ");*/
  if($retEditContrato['status'] == "OK"){
    echo "<script>alert('Contrato atualizado com sucesso');</script>";
    echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_fornecedor/cadastrar_cliente_comercial.php";</script>';
  }else{
    echo "<script>alert('Status: ".$retEditContrato['status']."');</script>";
  }
    
}

if (isset($_POST['listaEfetiva_movimento'])) {

  
  $update_movimento_financeiro = "UPDATE tb_movimento_financeiro SET
                        status_movimento = 'L'
                        WHERE cd_movimento = '".$_POST['listacd_movimento']."'";
  mysqli_query($conn, $update_movimento_financeiro);
            
            
  // Recupera o serviço inserido
            
  
  
  if(mysqli_query($conn, $update_movimento_financeiro)){
    echo "<script>alert('Parcela Efetivada');</script>";
    //echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_fornecedor/cadastrar_cliente_comercial.php";</script>';
  }else{
    echo "<script>alert('Erro');</script>";
  }
    
}

if (isset($_POST['gerar_parcelamento'])) {
    
    $retParcelamento = $u->gerarParcelamentoContrato($_POST['cd_filial']);
    if($retParcelamento['status'] == "OK"){
        echo "<script>alert('Contrato atualizado e mensalidades geradas com sucesso!');</script>";
        echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_fornecedor/cadastrar_cliente_comercial.php";</script>';
    }else{
        echo "<script>alert('Erro ao gerar mensalidades: ".$retParcelamento['status']."');</script>";
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
                    $result_contratos = $u->listContratos($result_empresa['cd_empresa'], $modoEdicao, $contratoEditar);
                    $result_financeiro  = $u->movimentoFinanceiroContrato($result_empresa['cd_empresa']);
                    $result_mensagem = $u->mensagem1($_SESSION['tipo_mensagem'], 'CONTRATO', $result_empresa['cd_empresa'], '');
                    

                    if($result_empresa['status'] == 'OK'){
                      echo $result_empresa['partial_empresa'];
                      if($result_contratos['status'] == 'OK'){
                        echo $result_contratos['partial_list_contrato'];
                        if($result_financeiro['status'] == 'OK'){
                          echo $result_financeiro['partial_financeiro'];
                          if($result_mensagem['status'] == 'OK'){
                            echo $result_mensagem['partial_mensagem'];
                          }else{
                            echo $result_mensagem['status'];
                          }
                        }
                      }else{
                        echo "<script>window.alert('Erro: ".$result_contratos['status']."');</script>";
                      }
                      
                    }else{
                      echo $result_empresa['status'];
                    }
                  }else{
                    $result_empresa = $u->conEmpresa('CCNPJ', 0, true);
                    if($result_empresa['status'] == 'OK'){
                      echo $result_empresa['partial_empresa'];
                    }else{
                      echo '<h1>Status: '.$result_empresa['status'].'</h1>';
                      echo '<h1>SQL: '.$result_empresa['sql_empresa'].'</h1>';
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