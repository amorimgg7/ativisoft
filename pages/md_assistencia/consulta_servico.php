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
  <?php
  		$caminho_pasta_empresa = "../web/imagens/".$_SESSION['cnpj_empresa']."//logos/";
		$foto_empresa = "LogoEmpresa.jpg"; // Nome do arquivo que será salvo
		$caminho_foto_empresa = $caminho_pasta_empresa . $foto_empresa;

		if (file_exists($caminho_foto_empresa)) {
			$tipo_foto_empresa = mime_content_type($caminho_foto_empresa);
  			echo "<link rel='shortcut icon' href='data:$tipo_foto_empresa;base64," . base64_encode(file_get_contents($caminho_foto_empresa)) . "' />";
		}else{
			echo "<link rel='shortcut icon' href='https://lh3.googleusercontent.com/pw/AP1GczOReqQClzL-PZkykfOwgmMyVzQgx27DTp783MI7iwKuKSv-6P6V7KOEbCC74sGdK3DEV3O88CsBLeIvOaQwGT3x4bqCTPRtyV9zcODbYVDRxAF8zf8Uev7geh4ONPdl3arNhnSDPvbQfMdpFRPM263V9A=w250-h250-s-no-gm?authuser=0' />";
		}
	?>
  <!-- endinject -->
  <script src="../../js/functions.js"></script>
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
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
              <h1><?php echo $_SESSION['bloqueado'];?></h1>
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
                    session_start();
                    $_SESSION['cd_cliente'] = 0;
                    $_SESSION['cd_servico'] = 0;
                    $_SESSION['vtotal_orcamento'] = 0;
                    $_SESSION['vpag_servico'] = 0;
                    
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                    
                    
                }
                ?>
                
                <?php
                  $select_servico = "SELECT * FROM tb_servico WHERE cd_servico = '".$_POST['conos_servico']."'";
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
                  }

                  $select_cliente = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$_SESSION['cd_cliente']."'";
                  $result_cliente = mysqli_query($conn, $select_cliente);
                  $row_cliente = mysqli_fetch_assoc($result_cliente);
                  if($row_cliente) {
                    $_SESSION['cd_cliente'] = $row_cliente['cd_cliente'];
                    $_SESSION['pnome_cliente'] = $row_cliente['pnome_cliente'];
                    $_SESSION['snome_cliente'] = $row_cliente['snome_cliente'];
                    $_SESSION['tel_cliente'] = $row_cliente['tel_cliente'];                
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
                  if($_SESSION['cd_servico'] > 0){


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
                    echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" '.$_SESSION['c_card'].' style="display:block;">';
                    echo '<form method="POST" action="../cad_geral/consulta_cliente.php">';
                    echo '<input value="'.$_SESSION['cd_cliente'].'" name="btncd_cliente" type="text" id="showcd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                    echo '<label for="btnpnome_cliente">Nome</label>';
                    echo '<input value="'.$_SESSION['pnome_cliente'].'" name="btnpnome_cliente" type="text" id="btnpnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btnsnome_cliente">sobrenome</label>';
                    echo '<input value="'.$_SESSION['snome_cliente'].'" name="btnsnome_cliente" type="text" id="btnsnome_cliente" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btntel_cliente">Telefone</label>';
                    echo '<input value="'.$_SESSION['tel_cliente'].'" name="btntel_cliente" type="tel"  id="btntel_cliente" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
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
                    
                    echo '<label for="btncd_servico">OS</label>';
                    echo '<input value="'.$_SESSION['cd_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" class="aspNetDisabled form-control form-control-sm" readonly>';
                    
                    echo '<label for="btnobs_servico">Descrição Geral</label>';
                    echo '<input value="'.$_SESSION['obs_con_servico'].'" type="text" name="btnobs_servico" maxlength="999" id="btnobs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="Caracteristica geral do serviço" readonly>';
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
                    echo '<label for="btnentrada_servico">Entrada</label>';
                    echo '<input value="'.$_SESSION['entrada_servico'].'" name="btnentrada_servico" type="datetime-local" id="btnentrada_servico" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    echo '<label for="btnprazo_servico">Prazo</label>';
                    echo '<input value="'.$_SESSION['prazo_servico'].'" name="btnprazo_servico" type="datetime-local" id="btnprazo_servico" class="aspNetDisabled form-control form-control-sm" readonly/>';
                    
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
                    $_SESSION['vtotal_orcamento'] = 0;

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
                          echo '<input value="'.$row_orcamento['vtotal_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
                          //echo '<input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                          echo '</div>';
                          echo '</div>';

                          //echo '<input type="submit" value="X" onclick="location.reload()" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                          
                          echo '</div>';
                          echo '</div>';
                          $vtotal = $vtotal + $row_orcamento['vtotal_orcamento'];
                          $_SESSION['vtotal_orcamento'] = $vtotal;
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
                          echo '<input value="'.$row_orcamento['vtotal_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
                          //echo '<input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                          
                          echo '</div>';
                          echo '</div>';
                          //echo '<label for="listaremover_orcamento"></label>';
                          //echo '<input type="submit" value="X" onclick="location.reload()" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                          
                          
                          echo '</div>';
                          echo '</div>';
                          $vtotal = $vtotal + $row_orcamento['vtotal_orcamento'];
                          $_SESSION['vtotal_orcamento'] = $vtotal;

                        }
                        
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                    } 
                    //$_SESSION['falta_pagar_orcamento'] = $_SESSION['vtotal_orcamento'] - $_SESSION['vpag_orcamento'];
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

if($_POST['marcartitulo_atividade'] == 'A') {// CRIAR NOVA ATIVIDADE A FAZER PARA O SERVICO
  //include("../../partials/load.html");
  // Atualiza as informações do usuário no banco de dados
  $query = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade) VALUES(
    '".$_POST['atividadecd_servico']."',
    '".$_POST['marcartitulo_atividade']."',
    '".$_POST['obs_atividade']."',
    '".$_POST['atividadecd_colab']."',
    '".$_POST['data_hora_ponto']."'
    )
  ";
  mysqli_query($conn, $query);
  if(isset($_POST['novadataentrega_atividade'])){
    $query = "UPDATE tb_servico SET
      prazo_servico = '".$_POST['novadataentrega_atividade']."',
      prioridade_servico = 'U',
      status_servico = '0'
      WHERE cd_servico = '".$_POST['atividadecd_servico']."'
    ";
    mysqli_query($conn, $query);
    //echo "<script>window.alert('Prazo para entrega alterado!');</script>";
  }
}

if($_POST['marcartitulo_atividade'] == 'B') {// SQL DAR INICIO A ATIVIDADE
  //include("../../partials/load.html");
  // Atualiza as informações do usuário no banco de dados
  $query = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade) VALUES(
    '".$_POST['atividadecd_servico']."',
    '".$_POST['marcartitulo_atividade']."',
    '".$_POST['obs_atividade']."',
    '".$_POST['atividadecd_colab']."',
    '".$_POST['data_hora_ponto']."'
    )
  ";
  mysqli_query($conn, $query);
  $query = "UPDATE tb_servico SET
      status_servico = '1'
      WHERE cd_servico = '".$_POST['atividadecd_servico']."'
    ";
    mysqli_query($conn, $query);
  if(isset($_POST['novadataentrega_atividade'])){
    $query = "UPDATE tb_servico SET
      prazo_servico = '".$_POST['novadataentrega_atividade']."',
      prioridade_servico = 'U',
      status_servico = '1'
      WHERE cd_servico = '".$_POST['atividadecd_servico']."'
    ";
    mysqli_query($conn, $query);
    //echo "<script>window.alert('Prazo para entrega alterado!');</script>";
  }
  
  echo "<script>window.alert('ATIVIDADE INICIADA COM SUCESSO!');</script>";
}

if($_POST['marcartitulo_atividade'] == 'C') {// SQL FINALIZAR A ATIVIDDE / ANDAMENTO
  $select_atividade_finalizar = "SELECT * FROM tb_atividade where titulo_atividade = 'B' AND cd_servico = '".$_POST['atividadecd_servico']."'";
  $result_atividade_finalizar = mysqli_query($conn, $select_atividade_finalizar);
  $row_atividade_finalizar = mysqli_fetch_assoc($result_atividade_finalizar);
  if($row_atividade_finalizar){
    $query = "UPDATE tb_atividade SET
    titulo_atividade = '".$_POST['marcartitulo_atividade']."',
    obs_atividade = '".$_POST['obs_atividade']."',
    fim_atividade = '".$_POST['data_hora_ponto']."'
    WHERE titulo_atividade = 'B' AND cd_servico = '".$_POST['atividadecd_servico']."'
  ";
  mysqli_query($conn, $query);
  //echo "<script>window.alert('FINALIZAR APÓS ANDAMENTO!');</script>";
  }else{
    $query = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
      '".$_POST['atividadecd_servico']."',
      '".$_POST['marcartitulo_atividade']."',
      '".$_POST['obs_atividade']."',
      '".$_POST['atividadecd_colab']."',
      '".$_POST['data_hora_ponto']."',
      '".$_POST['data_hora_ponto']."'
      )
    ";
    mysqli_query($conn, $query);
    //echo "<script>window.alert('FINALIZAR DIRETO!');</script>";
  }
  $query = "UPDATE tb_servico SET
    status_servico = '2'
    WHERE cd_servico = '".$_POST['atividadecd_servico']."'
  ";
  mysqli_query($conn, $query);
  //echo "<script>window.alert('ATIVIDADE FINALIZADA!');</script>";
}

if ($_POST['marcartitulo_atividade'] == 'D' && !isset($_POST['confirmacao'])) {
  // Obter os itens dinamicamente do banco de dados
  $itens = [];

  $select_orcamento = "
    SELECT 
        ROW_NUMBER() OVER (ORDER BY tos.cd_orcamento ASC) AS linha,
        tr.qtd_reservado,
        tos.vtotal_orcamento,
        tps.titulo_prod_serv
    FROM tb_orcamento_servico tos
    INNER JOIN tb_prod_serv tps ON tos.cd_produto = tps.cd_prod_serv
    LEFT JOIN tb_reserva tr ON tos.cd_orcamento = tr.cd_orcamento
    WHERE tos.tipo_orcamento = 'CADASTRADO'
      AND tr.qtd_efetivado IS NULL
      AND tos.cd_servico = '" . $_SESSION['cd_servico'] . "'
    ORDER BY tos.cd_orcamento ASC
";

  $result_orcamento = mysqli_query($conn, $select_orcamento);

  while ($row_orcamento = $result_orcamento->fetch_assoc()) {
    $itens[] =  $row_orcamento['linha'] . " - ".$row_orcamento['titulo_prod_serv'] . " | QTD:".$row_orcamento['qtd_reservado'] . " | R$:".$row_orcamento['vtotal_orcamento'];
  }

  // Construir a mensagem com os itens separados por quebra de linha
  $mensagem = "Deseja confirmar a saída dos itens:\n" . implode("\n", $itens);

  // Gerar o JavaScript dinamicamente com json_encode para evitar problemas com caracteres especiais
  echo "
  <script>
    const mensagem = " . json_encode($mensagem) . ";
    if (confirm(mensagem)) {
        // Cria um formulário com todos os dados do POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = ''; // Mesma página

        // Adiciona os campos existentes no POST ao formulário
        const postData = " . json_encode($_POST) . ";
        for (const key in postData) {
            if (postData.hasOwnProperty(key)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = postData[key];
                form.appendChild(input);
            }
        }

        // Adiciona o campo de confirmação
        const confirmInput = document.createElement('input');
        confirmInput.type = 'hidden';
        confirmInput.name = 'confirmacao';
        confirmInput.value = 'sim';
        form.appendChild(confirmInput);

        document.body.appendChild(form);
        form.submit();
    } else {
        alert('Operação cancelada pelo usuário.');
    }
  </script>
  ";


}

if (isset($_POST['confirmacao']) && $_POST['confirmacao'] === 'sim') {
    // Conexão com o banco de dados
    

    // Inserir no banco de dados
    $queryInsert = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
        '" . $_POST['atividadecd_servico'] . "',
        '" . $_POST['marcartitulo_atividade'] . "',
        '" . $_POST['obs_atividade'] . "',
        '" . $_POST['atividadecd_colab'] . "',
        '" . $_POST['data_hora_ponto'] . "',
        '" . $_POST['data_hora_ponto'] . "'
    )";

    if (mysqli_query($conn, $queryInsert)) {
        // Atualizar no banco de dados
        $updateServico = "UPDATE tb_servico SET
            status_servico = '3'
            WHERE cd_servico = '" . $_POST['atividadecd_servico'] . "'
        ";
        if (mysqli_query($conn, $updateServico)) {

          $updateEstoque = "
            UPDATE tb_prod_serv tps
            INNER JOIN (
                SELECT cd_prod_serv, SUM(qtd_reservado) AS total_reservado
                FROM tb_reserva
                WHERE cd_servico = '" . $_POST['atividadecd_servico'] . "'
                  AND qtd_reservado IS NOT NULL
                  AND qtd_reservado > 0
                  AND qtd_efetivado IS NULL
                GROUP BY cd_prod_serv
            ) tr ON tps.cd_prod_serv = tr.cd_prod_serv
            SET tps.estoque_prod_serv = tps.estoque_prod_serv - tr.total_reservado
            WHERE (tps.estoque_prod_serv - tr.total_reservado) >= 0
          ";
            if (mysqli_query($conn, $updateEstoque)) {
              $updateReserva = "UPDATE tb_reserva SET
              qtd_efetivado = qtd_reservado,
              dt_efetivado = '".date('Y-m-d H:i')."'
              WHERE cd_servico = '" . $_POST['atividadecd_servico'] . "'
            ";
            if (mysqli_query($conn, $updateReserva)) {
              echo "<script>alert('Operação realizada com sucesso!');</script>";
            }else{
              echo "<script>alert('Erro ao atualizar a reserva: " . mysqli_error($conn) . "');</script>";

            }
            
          }else{
            echo "<script>alert('Erro ao atualizar o estoque: " . mysqli_error($conn) . "');</script>";
          }
        } else {
            echo "<script>alert('Erro ao atualizar o serviço: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Erro ao inserir a atividade: " . mysqli_error($conn) . "');</script>";
    }
}






if($_POST['marcartitulo_atividade'] == 'E') {// SQL ARQUIVAR SERVIÇO
  $query = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
    '".$_POST['atividadecd_servico']."',
    '".$_POST['marcartitulo_atividade']."',
    '".$_POST['obs_atividade']."',
    '".$_POST['atividadecd_colab']."',
    '".$_POST['data_hora_ponto']."',
    '".$_POST['data_hora_ponto']."'
    )
  ";
  mysqli_query($conn, $query);
  $query = "UPDATE tb_servico SET
    status_servico = '4'
    WHERE cd_servico = '".$_POST['atividadecd_servico']."'
  ";
  mysqli_query($conn, $query);
  echo "<script>window.alert('ARQUIVADO!');</script>";
}


                  //$sql_atividade = "SELECT * FROM tb_atividade WHERE cd_servico = '".$_SESSION['cd_servico']."' ORDER BY cd_atividade ASC";
                  //$sql_atividade = "SELECT * FROM (
                  //  SELECT * FROM tb_atividade 
                  //  WHERE cd_servico = '".$_SESSION['cd_servico']."' 
                  //  ORDER BY cd_atividade ASC
                  //) as temp_table 
                  //WHERE temp_table.rownum < (SELECT COUNT(*) FROM tb_atividade WHERE cd_servico = '".$_SESSION['cd_servico']."')";


                  //Um exemplo alternativo usando MySQL é usar variáveis de usuário para emular a função ROW_NUMBER():
                  //Isso atribuirá um número de linha a cada linha na tabela tb_atividade e a consulta principal então selecionará todas as linhas exceto a última.
                  $sql_atividade = "SELECT * FROM (
                    SELECT @rownum:=@rownum+1 'rownum', t.* 
                    FROM tb_atividade t, (SELECT @rownum:=0) r 
                    WHERE cd_servico = '".$_SESSION['cd_servico']."' 
                    ORDER BY cd_atividade ASC
                  ) as temp_table 
                  WHERE temp_table.rownum < (SELECT COUNT(*) FROM tb_atividade WHERE cd_servico = '".$_SESSION['cd_servico']."')";
                  $result_atividade = mysqli_query($conn, $sql_atividade);
                  //echo '<h3>HISTÓRICO PASSADO</h3>';
                  while($row_atividade = $result_atividade->fetch_assoc()) { //mostrar historico
                    echo '<div class="col-lg-12 grid-margin stretch-card" '.$_SESSION['c_card'].'>';
                    echo '<div class="card" '.$_SESSION['c_card'].'>';
                    echo '<div class="card-body">';
                    if($row_atividade['titulo_atividade'] == "A"){
                      echo '<h4 class="card-title">'.$row_atividade['cd_atividade'].' Entrada</h4>';
                    }
                    if($row_atividade['titulo_atividade'] == "B"){
                      echo '<h4 class="card-title">'.$row_atividade['cd_atividade'].' Em Andamento / Fazendo</h4>';
                    }
                    if($row_atividade['titulo_atividade'] == "C"){
                      echo '<h4 class="card-title">'.$row_atividade['cd_atividade'].' Finalizado / Liberado para Entrega</h4>';
                    }
                    if($row_atividade['titulo_atividade'] == "D"){
                      echo '<h4 class="card-title">'.$row_atividade['cd_atividade'].' Entregue / Devolvido ao Cliente</h4>';
                    }
                    if($row_atividade['titulo_atividade'] == "E"){
                      echo '<h4 class="card-title">'.$row_atividade['cd_atividade'].' ARQUIVADO</h4>';
                    }
                    echo '<div class="table-responsive">';
                    echo '<table class="table" '.$_SESSION['c_card'].'>';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Início</th>';
                    echo '<th>Observações</th>';
                    echo '<th>Fim</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    echo '<td>'.date('d/m/Y', strtotime($row_atividade['inicio_atividade'])).'</td>';
                    echo '<td>'.$row_atividade['obs_atividade'].'</td>';
                    echo '<td>'.date('d/m/Y', strtotime($row_atividade['fim_atividade'])).'</td>';
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';  
                  }
                    //$sql_lastatividade = "SELECT * FROM tb_atividade WHERE cd_servico = '".$_POST['conos_servico']."'";
                    $sql_lastatividade = "SELECT * FROM tb_atividade WHERE cd_servico = '".$_SESSION['cd_servico']."' ORDER BY cd_atividade DESC LIMIT 1";

                    $result_lastatividade = mysqli_query($conn, $sql_lastatividade);
                    $row_lastatividade = mysqli_fetch_assoc($result_lastatividade);
                    //echo '<h3>ULTIMA ATIVIDADE EXECUTADA</h3>';
                    // Exibe as informações do usuário no formulário
                    if($row_lastatividade) {//MOSTRAR FORMULÁRIO DE ANDAMENTO DA ATIVIDADE ATUAL / ULTIMA ATIVIDADE REGISTRADA
                      echo '<div class="col-lg-12 grid-margin stretch-card" style="background-color: #23A5F6;">';
                      echo '<div class="card" '.$_SESSION['c_card'].'>';
                      echo '<div class="card-body">';
                      if($row_lastatividade['titulo_atividade'] == "A"){
                        echo '<h4 class="card-title">'.$row_lastatividade['cd_atividade'].' Entrada</h4>';
                      }
                      if($row_lastatividade['titulo_atividade'] == "B"){
                        echo '<h4 class="card-title">'.$row_lastatividade['cd_atividade'].' Em Andamento / Fazendo</h4>';
                      }
                      if($row_lastatividade['titulo_atividade'] == "C"){
                        echo '<h4 class="card-title">'.$row_lastatividade['cd_atividade'].' Finalizado / Liberado para Entrega</h4>';
                      }
                      if($row_lastatividade['titulo_atividade'] == "D"){
                        echo '<h4 class="card-title">'.$row_lastatividade['cd_atividade'].' Entregue / Devolvido ao Cliente</h4>';
                      }
                      if($row_lastatividade['titulo_atividade'] == "E"){
                        echo '<h4 class="card-title">'.$row_lastatividade['cd_atividade'].' ARQUIVADO</h4>';
                      }
                      echo '<div class="table-responsive" '.$_SESSION['c_card'].'>';
                      echo '<table class="table" '.$_SESSION['c_card'].'>';
                      echo '<thead>';
                      echo '<tr>';
                      echo '<th>Início</th>';
                      echo '<th>Observações</th>';
                      echo '<th>Fim</th>';
                      echo '</tr>';
                      echo '</thead>';
                      echo '<tbody>';
                      echo '<td>'.date('d/m/Y', strtotime($row_lastatividade['inicio_atividade'])).'</td>';
                      echo '<td>'.$row_lastatividade['obs_atividade'].'</td>';
                      echo '<td>'.date('d/m/Y', strtotime($row_lastatividade['fim_atividade'])).'</td>';
                      echo '</tbody>';
                      echo '</table>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';

                      echo '<div class="card-body" id="novaAtividade" '.$_SESSION['c_card'].'>';
                      echo '<div class="kt-portlet__body" '.$_SESSION['c_card'].'>';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      echo '<h3>LANÇAR ATIVIDADE</h3>';
                      echo '<form method="POST">';
                      //echo '<h3 class="kt-portlet__head-title">Nova Atividade</h3> ';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                      echo '<input value="'.$row_lastatividade['cd_servico'].'" style="display: none;" name="atividadecd_servico" type="text" id="atividadecd_servico" class="aspNetDisabled form-control form-control-sm" readonly/>       ';
                      echo '<input value="'.$row_lastatividade['cd_colab'].'" style="display: none;" name="atividadecd_colab" type="text" id="atividadecd_colab" class="aspNetDisabled form-control form-control-sm" readonly/>';
                      
                      if($row_lastatividade['titulo_atividade'] == "A"){//INICIAR ATENDIMENTO
                        echo '<label for="marcartitulo_atividade">Entrada</label>';
                        echo '<select name="marcartitulo_atividade" id="marcartitulo_atividade"  class="aspNetDisabled form-control form-control-sm" required>';
                        echo '<option selected="selected"value="B">EM ANDAMENTO</option>';
                        echo '<option value="C">FINALIZAR</option>';
                        echo '<option value="E">ARQUIVAR</option>';
                        //echo '<option value="C">FINALIZAR</option>';
                        echo '</select>';
                        echo '<label for="showobs_servico">Observações</label>';
                        echo '<input type="text" name="obs_atividade" maxlength="999" id="obs_atividade" class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?">';
                        echo '<label for="data_hora_ponto">Data e Hora</label>';
                        echo '<input name="data_hora_ponto" type="datetime-local" value="'.date('Y-m-d\TH:i', time()).'" id="data_hora_ponto" class="form-control form-control-sm" readonly>';
                        echo '<input type="submit" class="btn btn-success" name="novaAtividade" id="novaAtividade" value="Adicionar Atividade">';
                      }

                      if($row_lastatividade['titulo_atividade'] == "B"){//FINALIZAR ATENDIMENTO
                        echo '<label for="marcartitulo_atividade">Serviço em Andamento</label>';
                        echo '<select name="marcartitulo_atividade" id="marcartitulo_atividade"  class="aspNetDisabled form-control form-control-sm" required>';
                        echo '<option selected="selected"value="C">FINALIZAR</option>';
                        echo '</select>';
                        echo '<label for="obs_atividade">Observações</label>';
                        echo '<input type="text" name="obs_atividade" maxlength="999" id="obs_atividade" class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?">';
                        echo '<label for="data_hora_ponto">Data e Hora</label>';
                        echo '<input name="data_hora_ponto" type="datetime-local" value="'.date('Y-m-d\TH:i', time()).'" id="data_hora_ponto" class="form-control form-control-sm" readonly>';
                        echo '<input type="submit" class="btn btn-success" name="finalizarAtividade" id="finalizarAtividade" value="Finalizar Atividade">';
                      
                      }

                      if($row_lastatividade['titulo_atividade'] == "C"){//ENTREGAR / DEVOLVER OU REABRIR
                        echo '<label for="marcartitulo_atividade">Serviço Realizado</label>';
                        echo '<select name="marcartitulo_atividade" id="marcartitulo_atividade"  class="aspNetDisabled form-control form-control-sm" required>';
                        echo '<option selected="selected"value="D">ENTREGAR / DEVOLVER</option>';
                        echo '<option value="B">REFAZER AGORA</option>';
                        echo '<option value="A">REFAZER DEPOIS</option>';
                        echo '<option value="E">ARQUIVAR</option>';
                        echo '</select>';
                        echo '<label for="obs_atividade">Observações</label>';
                        echo '<input name="obs_atividade" type="text" maxlength="999" id="obs_atividade"  class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?" />';
                        echo '<label for="novadataentrega_atividade">Prazo Para Revisão</label>';
                        echo '<input name="novadataentrega_atividade" type="datetime-local" value="'.date('Y-m-d\T16:00', strtotime('+30 days')).'" id="novadataentrega_atividade" class="form-control form-control-sm">';
                        echo '<label for="data_hora_ponto">Data e Hora</label>';
                        echo '<input name="data_hora_ponto" type="datetime-local" value="'.date('Y-m-d\TH:i', time()).'" id="data_hora_ponto" class="form-control form-control-sm" readonly>';
                        echo '<input type="submit" class="btn btn-success" name="novaAtividade" id="novaAtividade" value="Adicionar Atividade">';
                      }

                      if($row_lastatividade['titulo_atividade'] == "D"){//ENTREGUE / DEVOLVIDO
                        echo '<label for="marcartitulo_atividade">Entregue / Devolvido</label>';
                        echo '<select name="marcartitulo_atividade" id="marcartitulo_atividade"  class="aspNetDisabled form-control form-control-sm" required>';
                        echo '<option selected="selected"value="B">REFAZER AGORA</option>';
                        echo '<option value="A">REFAZER DEPOIS</option>';
                        echo '<option value="E">ARQUIVAR</option>';
                        echo '</select>';
                        echo '<label for="obs_atividade">Observações</label>';
                        //echo '<input name="novaobs_atividade" type="text" maxlength="999" id="novaobs_atividade"  class="aspNetDisabled form-control form-control-sm" placeholder="O que precisa fazer para resolver este problema?" />';
                        echo '<input type="text" name="obs_atividade" maxlength="999" id="obs_atividade" class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?">';
                        echo '<label for="novadataentrega_atividade">Prazo Para Revisão</label>';
                        echo '<input name="novadataentrega_atividade" type="datetime-local" value="'.date('Y-m-d\T16:00', strtotime('+30 days')).'" id="novadataentrega_atividade" class="form-control form-control-sm">';
                        echo '<label for="data_hora_ponto">Data e Hora</label>';
                        echo '<input name="data_hora_ponto" type="datetime-local" value="'.date('Y-m-d\TH:i', time()).'" id="data_hora_ponto" class="form-control form-control-sm" readonly>';
                        echo '<input type="submit" class="btn btn-success" name="novaAtividade" id="novaAtividade" value="Adicionar Atividade">';
                      }
                      
                      if($row_lastatividade['titulo_atividade'] == "E"){//ARQUIVADO
                        echo '<label for="marcartitulo_atividade">Atividade Arquivada</label>';
                        echo '<select name="marcartitulo_atividade" id="marcartitulo_atividade"  class="aspNetDisabled form-control form-control-sm" required>';
                        echo '<option selected="selected"value="B">REFAZER AGORA</option>';
                        echo '<option value="A">REFAZER DEPOIS</option>';
                        echo '</select>';
                        echo '<label for="obs_atividade">Observações</label>';
                        //echo '<input name="novaobs_atividade" type="text" maxlength="999" id="novaobs_atividade"  class="aspNetDisabled form-control form-control-sm" placeholder="O que precisa fazer para resolver este problema?" />';
                        echo '<input type="text" name="obs_atividade" maxlength="999" id="obs_atividade" class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?">';
                        echo '<label for="novadataentrega_atividade">Prazo Para Revisão</label>';
                        echo '<input name="novadataentrega_atividade" type="datetime-local" value="'.date('Y-m-d\T16:00', strtotime('+30 days')).'" id="novadataentrega_atividade" class="form-control form-control-sm">';
                        echo '<label for="data_hora_ponto">Data e Hora</label>';
                        echo '<input name="data_hora_ponto" type="datetime-local" value="'.date('Y-m-d\TH:i', time()).'" id="data_hora_ponto" class="form-control form-control-sm" readonly>';
                        echo '<input type="submit" class="btn btn-success" name="novaAtividade" id="novaAtividade" value="Adicionar Atividade">';
                      }
                      
                      
                                       
                    
                      //echo '<label for="obs_atividade">Observações</label>';
                      //echo '<input name="obs_atividade" type="text"  id="obs_atividade" class="aspNetDisabled form-control form-control-sm"/>';
                      //echo '';
                      //echo '<label for="showtel_cliente">Fim</label>';
                      //echo '<input name="showtel_cliente" type="date"  id="showtel_cliente" class="aspNetDisabled form-control form-control-sm"/>';
                      echo '</div>';
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                    }
                    

                    
                    
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