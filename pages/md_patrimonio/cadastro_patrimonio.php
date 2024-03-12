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
    if(isset($_SESSION['patrimonio_colab'])){
      echo '<script>document.getElementById("abrirOS").style.display = "block";</script>';      
    }
?><!--Validar sessão aberta, se usuário está logado.-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cadastro</title>
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
                <script>
              		function abrirCadastro() {
                	  document.getElementById("cadastroPatrimonio").style.display = "block";
                  	document.getElementById("consulta").style.display = "none";
                    
                    document.getElementById("showPatrimonio").style.display = "none";
                    document.getElementById("pergunta1").style.display = "none";
                  }

                  function abrirConsulta() {
                  	document.getElementById("cadastroPatrimonio").style.display = "none";
                  	document.getElementById("consulta").style.display = "block";
                      
                    document.getElementById("showPatrimonio").style.display = "none";
                    document.getElementById("pergunta1").style.display = "none";
                  }

                  function fechacadServico() {                     
                    document.getElementById("showPatrimonio").style.display = "none";
                  }
                </script>

                <?php
                  if(isset($_POST['limparFormulario'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    ////session_start();
                    $_SESSION['patrimonio_colab'] = 0;
                    $_SESSION['os_servico'] = 0;
                    $_SESSION['servico'] = 0;
                    $_SESSION['vtotal_orcamento'] = 0;
                    $_SESSION['vpag_servico'] = 0;
                  
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("cadOs").style.display = "none";</script>';//
                    echo '<script>document.getElementById("cadastroPatrimonio").style.display = "none";</script>';
                  }
                ?>
                



                <div class="card-body" id="cadastroPatrimonio" style="display:none;">
                  <h3 class="kt-portlet__head-title">Dados do cliente</h3>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST">
                            <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                              <select name="tipo_patrimonio" id="tipo_patrimonio"  class="input-group-text" required>
                                <option selected="selected"value=''>Marque uma opção</option>
                                <option value='SMARTPHONE'>Smartphone</option>
                                <option value='DESKTOP'>Desktop</option>
                                <option value='NOTEBOOK'>Notebook</option>
                                <option value='MESA'>Mesa</option>
                                <option value='CADEIRA'>Caddeirs</option>
                                <option value='INSTRUMENTO'>Instrumento</option>
                              </select>

                              <label for="fabricante_patrimonio">Fabricante</label>
                              <input name="fabricante_patrimonio" type="text" id="fabricante_patrimonio" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>

                              <label for="fabricante_patrimonio">Marca</label>
                              <input name="fabricante_patrimonio" type="text" id="fabricante_patrimonio" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>

                              <label for="fabricante_patrimonio">Modelo</label>
                              <input name="fabricante_patrimonio" type="text" id="fabricante_patrimonio" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>

                              <label for="fabricante_patrimonio">Versão</label>
                              <input name="fabricante_patrimonio" type="text" id="fabricante_patrimonio" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>

                              <label for="fabricante_patrimonio">Descrição / Observações</label>
                              <input name="fabricante_patrimonio" type="text" id="fabricante_patrimonio" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>

                              <label for="numserie_patrimonio">Número de série</label>
                              <input name="numserie_patrimonio" type="tel" id="numserie_patrimonio" class="aspNetDisabled form-control form-control-sm" readonly/>
                            </div>
                            <button type="submit" name="cad_patrimonio" class="btn btn-lg btn-block btn-success" style="margin: 5px 0px;">Salvar</button>
                          </form>
                          <form method="post">
                            <button type="submit" class="btn btn-lg btn-block btn-danger" name="limparFormulario" style="margin: 5px 0px;">Refazer</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                        <?php //cadastra cliente e consulta para abrir ordem de serviço
                          if(isset($_POST['cad_patrimonio'])) {
                            //include("../../partials/load.html");
                            // Atualiza as informações do usuário no banco de dados
                            $query = "INSERT INTO tb_patrimonio(cd_filial_patrimonio, cd_comodo_patrimonio, cd_colab_patrimonio, numserie_patrimonio, tipo_patrimonio, fabricante_patrimonio, marca_patrimonio, modelo_patrimonio, versao_patrimonio, ds_patrimonio, obs_patrimonio, dt_compra_patrimonio, vl_compra_patrimonio, link_compra_patrimonio, snome_colab) VALUES(
                              '".$_POST['cd_filial_patrimonio']."',
                              '".$_POST['cd_comodo_patrimonio']."',
                              '".$_POST['cd_colab_patrimonio']."',
                              '".$_POST['numserie_patrimonio']."',
                              '".$_POST['tipo_patrimonio']."',
                              '".$_POST['fabricante_patrimonio']."',
                              '".$_POST['marca_patrimonio']."',
                              '".$_POST['modelo_patrimonio']."',
                              '".$_POST['versao_patrimonio']."',
                              '".$_POST['ds_patrimonio']."',
                              '".$_POST['obs_patrimonio']."',
                              '".$_POST['dt_compra_patrimonio']."',
                              '".$_POST['vl_compra_patrimonio']."',
                              '".$_POST['link_compra_patrimonio']."',
                              '".$_POST['snome_colab']."')
                            ";
                            mysqli_query($conn, $query);
                                
                            $query = "SELECT * FROM tb_patrimonio WHERE numserie_patrimonio = '".$_POST['numserie_patrimonio']."'";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);

                            // Exibe as informações do usuário no formulário
                            if($row) {
                              $_SESSION['cd_patrimonio'] = $row['cd_patrimonio'];
                              $_SESSION['cd_filial_patrimonio'] = $row['cd_filial_patrimonio'];
                              $_SESSION['cd_comodo_patrimonio'] = $row['cd_comodo_patrimonio'];
                              $_SESSION['cd_colab_patrimonio'] = $row['cd_colab_patrimonio'];
                              $_SESSION['numserie_patrimonio'] = $row['numserie_patrimonio'];
                              $_SESSION['tipo_patrimonio'] = $row['tipo_patrimonio'];
                              $_SESSION['fabricante_patrimonio'] = $row['fabricante_patrimonio'];
                              $_SESSION['marca_patrimonio'] = $row['marca_patrimonio'];
                              $_SESSION['modelo_patrimonio'] = $row['modelo_patrimonio'];
                              $_SESSION['versao_patrimonio'] = $row['versao_patrimonio'];
                              $_SESSION['ds_patrimonio'] = $row['ds_patrimonio'];
                              $_SESSION['obs_patrimonio'] = $row['obs_patrimonio'];
                              $_SESSION['dt_compra_patrimonio'] = $row['dt_compra_patrimonio'];
                              $_SESSION['vl_compra_patrimonio'] = $row['vl_compra_patrimonio'];
                              $_SESSION['link_compra_patrimonio'] = $row['link_compra_patrimonio'];               
                            }
                          }
                        ?>


                    


                <div class="card-body" id="consulta" >
                  <h4 class="card-title">Informe o número de série</h4>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST"> 
                            <div class="form-group" style="display: flex;">
                              <div class="input-group">
                              <div class="input-group-prepend">
                                  <select name="tipo_patrimonio" id="tipo_patrimonio"  class="input-group-text" required>
                                    <option selected="selected"value=''>Marque uma opção</option>
                                    <option value='SMARTPHONE'>Smartphone</option>
                                    <option value='DESKTOP'>Desktop</option>
                                    <option value='NOTEBOOK'>Notebook</option>
                                    <option value='MESA'>Mesa</option>
                                    <option value='CADEIRA'>Caddeirs</option>
                                    <option value='INSTRUMENTO'>Instrumento</option>
                                  </select>  
                                </div>
                                <input placeholder="Número de série" type="text" name="connumserie_patrimonio" id="connumserie_patrimonio" class="aspNetDisabled form-control form-control-sm" required>
                              </div>
                            </div>
                            <br>
                            <button type="submit" name="consulta" class="btn btn-block btn-success">Consulta</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <?php
                  if(isset($_POST['connumserie_patrimonio'])) { //CONSULTAR PATRIMONIO CADASTRADO
                    echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                    //session_start();
                    $_SESSION['connumserie_patrimonio'] = $_POST['connumserie_patrimonio'];
                    $select_patrimonio = "SELECT * FROM tb_patrimonio WHERE numserie_patrimonio = '".$_POST['connumserie_patrimonio']."'";
                    $result = mysqli_query($conn, $select_patrimonio);
                    $row = mysqli_fetch_assoc($result);
                    if($row) {
                      $_SESSION['cd_patrimonio'] = $row['cd_patrimonio'];
                      $_SESSION['cd_filial_patrimonio'] = $row['cd_filial_patrimonio'];
                      $_SESSION['cd_comodo_patrimonio'] = $row['cd_comodo_patrimonio'];
                      $_SESSION['cd_colab_patrimonio'] = $row['cd_colab_patrimonio'];

                      
                      $_SESSION['numserie_patrimonio'] = $row['numserie_patrimonio'];
                      $_SESSION['tipo_patrimonio'] = $row['tipo_patrimonio'];
                      $_SESSION['fabricante_patrimonio'] = $row['fabricante_patrimonio'];
                      $_SESSION['marca_patrimonio'] = $row['marca_patrimonio'];
                      $_SESSION['modelo_patrimonio'] = $row['modelo_patrimonio'];
                      $_SESSION['versao_patrimonio'] = $row['versao_patrimonio'];
                      $_SESSION['ds_patrimonio'] = $row['ds_patrimonio'];
                      $_SESSION['obs_patrimonio'] = $row['obs_patrimonio'];
                      $_SESSION['dt_compra_patrimonio'] = $row['dt_compra_patrimonio'];
                      $_SESSION['vl_compra_patrimonio'] = $row['vl_compra_patrimonio'];
                      $_SESSION['link_compra_patrimonio'] = $row['link_compra_patrimonio'];                
                    }else{
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                      echo '<script>document.getElementById("cadastroPatrimonio").style.display = "block";</script>';
                      echo '<script>document.getElementById("numserie_patrimonio").value = "'.$_POST['cd_pais'].$_POST['connumserie_patrimonio'].'"</script>';
                    }
                  }
                ?>
                
                <?php
                  if(isset($_SESSION['patrimonio_colab'])){

                    if($_SESSION['patrimonio_colab'] > 0 && (!isset($_SESSION['os_servico']) || $_SESSION['os_servico'] == 0)){
                      echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                      echo '<div class="card-body" id="cadOs"><!--FORMULÁRIO PARA CRIAR OS-->';
                      echo '<div class="kt-portlet__body">';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                              
                      echo '<form method="POST">';
                      echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                      echo '<input value="'.$_SESSION['patrimonio_colab'].'" name="showcd_cliente" type="text" id="showcd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                      echo '<label for="showpnome_colab">Nome</label>';
                      echo '<input value="'.$_SESSION['pnome_colab'].'" name="showpnome_colab" type="text" id="showpnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                      echo '<label for="showsnome_colab">sobrenome</label>';
                      echo '<input value="'.$_SESSION['snome_colab'].'" name="showsnome_colab" type="text" id="showsnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                      echo '<label for="showtel_colab">Telefone</label>';
                      echo '<input value="'.$_SESSION['numserie_patrimonio'].'" name="showtel_colab" type="tel"  id="showtel_colab" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                      echo '</div>';
                              
                      echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                      echo '<input type="tel" name="os_servico" id="os_servico" style="display: none;">';
                      echo '<label for="obs_servico">Descrição Geral</label>';
                      echo '<input type="text" name="obs_servico" maxlength="999" id="obs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="Caracteristica geral do serviço" required>';
                      echo '<!--<textarea name="obs_servico" maxlength="999" id="obs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="Oque o cliente pediu pra fazer?" ></textarea>-->';
                              
                      echo '<label for="prioridade_servico">Prioridade</label>';
                      echo '<select name="prioridade_servico" id="prioridade_servico"  class="aspNetDisabled form-control form-control-sm" required>';
                      echo '<option selected="selected" value=""></option>';
                      echo '<option value="B">Baixa</option>';
                      echo '<option value="M">Média</option>';
                      echo '<option value="A">Alta</option>';
                      echo '<option value="U">Urgente</option>';
                      echo '</select>';
                      echo '<!--<label for="showprazo_servico">Entrada</label>-->';
                      echo '<input name="data_hora_ponto" type="datetime-local" id="data_hora_ponto" placeholder="Data" class="aspNetDisabled form-control form-control-sm" style="display: none;" />';
                      echo '<label for="prazo_servico">Prazo</label>';
                      echo '<input name="prazo_servico" type="datetime-local" id="prazo_servico" placeholder="Data" class="aspNetDisabled form-control form-control-sm" value="16:"/>';
                      echo '</div>';
                      echo '<button type="submit" name="lancar" class="btn btn-block btn-lg btn-success" onclick="fechacadServico()">Lançar</button>';
                      echo '</form>';
                              
                      echo '</form>';
                      echo '<form method="post">';//echo '<button type="submit" class="btn btn-danger" name="limparFormulario" style="margin: 5px;">Nova Consulta</button>';
                      echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparFormulario" style="margin: 5px;">Refazer</button>';
                      echo '</form>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                    }
                  }
                          
                ?>
                          
                <?php
                  if(isset($_POST['lancar'])) { //CADASTRAR SERVICO E CHAMAR SERVICO CADASTRADO PARA SESSION
                    //include("../../partials/load.html");
                    // Atualiza as informações do usuário no banco de dados
                    $insert_servico = "INSERT INTO tb_servico(cd_cliente, obs_servico, prioridade_servico, entrada_servico, prazo_servico, status_servico) VALUES(
                      '".$_SESSION['patrimonio_colab']."',
                              
                      '".$_POST['obs_servico']."',
                      '".$_POST['prioridade_servico']."',
                      '".$_POST['data_hora_ponto']."',
                      '".$_POST['prazo_servico']."',
                      '0')
                    ";
                    mysqli_query($conn, $insert_servico);
                    //echo "<script>window.alert('Ordem de Serviço criada com sucesso!');</script>";
                    echo '<script>document.getElementById("cadOs").style.display = "none";</script>';
                    //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
                    $select_servico = "SELECT * FROM tb_servico WHERE cd_cliente = '".$_SESSION['patrimonio_colab']."' AND status_servico = 0 ORDER BY cd_servico DESC LIMIT 1";
                    $result_servico = mysqli_query($conn, $select_servico);
                    $row_servico = mysqli_fetch_assoc($result_servico);
                    // Exibe as informações do usuário no formulário
                    if($row_servico) {
                      $_SESSION['os_servico'] = $row_servico['cd_servico'];
                      //$_SESSION['os_servico'] = $row_servico['cd_servico'];
                      $_SESSION['servico'] = $row_servico['cd_servico'];
                      $_SESSION['titulo_servico'] = $row_servico['titulo_servico'];
                      $_SESSION['obs_servico'] = $row_servico['obs_servico'];
                      $_SESSION['prioridade_servico'] = $row_servico['prioridade_servico'];
                      $_SESSION['entrada_servico'] = $_POST['data_hora_ponto'];
                      $_SESSION['prazo_servico'] = $row_servico['prazo_servico'];
                      $_SESSION['orcamento_servico'] = $row_servico['orcamento_servico'];
                      $_SESSION['vpag_servico'] = $row_servico['vpag_servico'];
        
                      $insert_atividade = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
                        '".$row_servico['cd_servico']."',
                        'A',
                        '".$row_servico['obs_servico']."',
                        '".$_SESSION['cd_colab']."',
                        '".$_POST['data_hora_ponto']."',
                        '".$_POST['data_hora_ponto']."')
                      ";
                      mysqli_query($conn, $insert_atividade);
                      //echo "<script>window.alert('Atividade Lançada!');</script>";
                      }
                      //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
                    }
                    ?>
                    <?php
                    if(isset($_POST['con_edit_os'])) {
                      $query = "SELECT * FROM tb_servico WHERE cd_servico = '".$_POST['btncd_servico']."'";
                      $result = mysqli_query($conn, $query);
                      $row = mysqli_fetch_assoc($result);

                      // Exibe as informações do usuário no formulário
                      if($row) {
                        $_SESSION['os_servico'] = $row['cd_servico'];
                        $_SESSION['patrimonio_colab'] = $row['cd_cliente'];
                                
                                
                        $_SESSION['titulo_servico'] = $row['titulo_servico'];
                        $_SESSION['obs_servico'] = $row['obs_servico'];
                        $_SESSION['prioridade_servico'] = $row['prioridade_servico'];
                        $_SESSION['entrada_servico'] = $row['entrada_servico'];
                        $_SESSION['prazo_servico'] = $row['prazo_servico'];
                        $_SESSION['orcamento_servico'] = $row['orcamento_servico'];
                        $_SESSION['vpag_servico'] = $row['vpag_servico'];
                      }
                              
                      $select_patrimonio = "SELECT * FROM tb_cliente WHERE cd_cliente = '".$_SESSION['patrimonio_colab']."'";
                      $result_cliente = mysqli_query($conn, $select_patrimonio);
                      $row_cliente = mysqli_fetch_assoc($result_cliente);
                      if($row_cliente) {
                        $_SESSION['pnome_colab'] = $row_cliente['pnome_colab'];
                        $_SESSION['snome_colab'] = $row_cliente['snome_colab'];
                        $_SESSION['numserie_patrimonio'] = $row_cliente['numserie_patrimonio'];                
                      }
                    }


                    if(isset($_POST['edit_os'])) {
                      $edit_os = "UPDATE tb_servico SET
                        obs_servico = '".$_POST['editobs_servico']."',
                        prioridade_servico = '".$_POST['editprioridade_servico']."',
                        prazo_servico = '".$_POST['editprazo_servico']."'
                        WHERE cd_servico = '".$_POST['editos_servico']."'";
                        mysqli_query($conn, $edit_os);
                        echo "<script>window.alert('Servico editado!');</script>";

                        $query = "SELECT * FROM tb_servico WHERE cd_servico = '".$_POST['editos_servico']."'";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);
                        // Exibe as informações do usuário no formulário
                        if($row) {
                          $_SESSION['os_servico'] = $row['cd_servico'];
                          $_SESSION['patrimonio_colab'] = $row['cd_cliente'];
                                
                                
                          $_SESSION['titulo_servico'] = $row['titulo_servico'];
                          $_SESSION['obs_servico'] = $row['obs_servico'];
                          $_SESSION['prioridade_servico'] = $row['prioridade_servico'];
                          $_SESSION['entrada_servico'] = $row['entrada_servico'];
                          $_SESSION['prazo_servico'] = $row['prazo_servico'];
                          $_SESSION['orcamento_servico'] = $row['orcamento_servico'];
                          $_SESSION['vpag_servico'] = $row['vpag_servico'];
                        }
                      }

                      if(isset($_POST['lancarOrcamento'])) {
                              
                        if($_POST['titulo_orcamento']==false){
                          $_SESSION['titulo_orcamento'] = $_POST['titulo_orcamento'];
                          $_SESSION['vcusto_orcamento'] = $_POST['vcusto_orcamento'];
                          echo "<script>window.alert('Descreva o Orcamento!');</script>"; 
                        }elseif($_POST['vcusto_orcamento']==false){
                          $_SESSION['titulo_orcamento'] = $_POST['titulo_orcamento'];
                          $_SESSION['vcusto_orcamento'] = $_POST['vcusto_orcamento'];
                          echo "<script>window.alert('Insira o Valor do Orcamento!');</script>";  
                        }else{
                          $_SESSION['titulo_orcamento'] = false;
                          $_SESSION['vcusto_orcamento'] = false;
                          $insertOrcamento = "INSERT INTO tb_orcamento_servico(cd_cliente, cd_servico, titulo_orcamento, vcusto_orcamento, status_orcamento) VALUES(
                            '".$_SESSION['patrimonio_colab']."',
                            '".$_SESSION['os_servico']."',
                            '".$_POST['titulo_orcamento']."',
                            '".$_POST['vcusto_orcamento']."',
                            '0')
                          ";
                          mysqli_query($conn, $insertOrcamento);
                          $_SESSION['vtotal_orcamento'] = $_SESSION['vtotal_orcamento'] + $_POST['vcusto_orcamento'];
                              
                          $updateOrcamentoServico = "UPDATE tb_servico SET
                            orcamento_servico = ".$_SESSION['vtotal_orcamento']."
                            WHERE cd_servico = ".$_SESSION['os_servico']."";
                            mysqli_query($conn, $updateOrcamentoServico);
                          }            
                        }
                        ?>
                        <?php
                          if(isset($_SESSION['os_servico'])){
                            if($_SESSION['os_servico'] > 0){
                              echo '<script>document.getElementById("pergunta1").style.display = "none";</script>';
                              echo '<script>document.getElementById("cadOs").style.display = "none";</script>';
                              echo '<form method="POST">';
                              echo '<div class="card-body" id="abrirOS2"><!--FORMULÁRIO PARA CRIAR OS-->';
                              echo '<div class="kt-portlet__body">';
                              echo '<div class="row">';
                              echo '<div class="col-12 col-md-12">';
                              echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                              
                              echo '<script>document.getElementById("consulta").style.display = "none";</script>';
                              echo '<script>document.getElementById("abrirOS").style.display = "block";</script>';
                              //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                              echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="display:none;">';
                              echo '<input value="'.$_SESSION['patrimonio_colab'].'" name="showcd_cliente" type="text" id="showcd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                              echo '<label for="showpnome_colab">Nome</label>';
                              echo '<input value="'.$_SESSION['pnome_colab'].'" name="editpnome_colab" type="text" id="showpnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                              echo '<label for="showsnome_colab">sobrenome</label>';
                              echo '<input value="'.$_SESSION['snome_colab'].'" name="showsnome_colab" type="text" id="showsnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm" readonly/>';
                              echo '<label for="showtel_colab">Telefone</label>';
                              echo '<input value="'.$_SESSION['numserie_patrimonio'].'" name="showtel_colab" type="tel"  id="showtel_colab" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" readonly/>';
                              echo '</div>';
                              
                              echo '<h3 class="kt-portlet__head-title">Dados do serviço</h3>';
                              echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">';
                              echo '<label for="editos_servico">OS</label>';
                              echo '<input value="'.$_SESSION['os_servico'].'" type="tel" name="editos_servico" id="editos_servico" class="aspNetDisabled form-control form-control-sm" readonly>';
                              echo '<label for="editobs_servico">Descrição Geral</label>';
                              echo '<input value="'.$_SESSION['obs_servico'].'" type="text" name="editobs_servico" maxlength="999" id="editobs_servico"  class="aspNetDisabled form-control form-control-sm" placeholder="Caracteristica geral do serviço">';
                              
                              
                              echo '<label for="editprioridade_servico">Prioridade</label>';
                              echo '<select name="editprioridade_servico" id="editprioridade_servico"  class="aspNetDisabled form-control form-control-sm">';
                              
                              if($_SESSION['prioridade_servico'] == "U"){
                                echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >Urgente</option>';
                              }
                              if($_SESSION['prioridade_servico'] == "A"){
                                echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >Alta</option>';
                              }
                              if($_SESSION['prioridade_servico'] == "M"){
                                echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >Média</option>';
                              }
                              if($_SESSION['prioridade_servico'] == "B"){
                                echo '<option selected="selected" value="'.$_SESSION['prioridade_servico'].'" >Baixa</option>';
                              }
                              echo '<option value="U" >Urgente</option>';
                              echo '<option value="A" >Alta</option>';
                              echo '<option value="M" >Média</option>';
                              echo '<option value="B" >Baixa</option>';
                              echo '</select>';
                              echo '<label>Entrada</label>';
                              echo '<input value="'.$_SESSION['entrada_servico'].'" type="datetime-local" class="aspNetDisabled form-control form-control-sm" style="display: block; " readonly/>';
                              echo '<label for="editprazo_servico">Prazo</label>';
                              echo '<input value="'.$_SESSION['prazo_servico'].'" name="editprazo_servico" type="datetime-local" id="editprazo_servico" class="aspNetDisabled form-control form-control-sm"/>';
                              echo '<td><button type="submit" name="edit_os" id="edit_os" class="btn btn-block btn-outline-success"><i class="icon-cog"></i>Salvar</button></td>';
                              
                              echo '</div>';
                              
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                              ////echo '</div>';
                              
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
                              
                              echo '<h3 class="kt-portlet__head-title">Adicionar Serviço</h3>';
                              echo '<script>document.getElementById("listaOrcamento").style.display = "block";</script>';
                              echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6;">';
                              echo '<div class="horizontal-form">';
                              echo '<div class="form-group">';
                              echo '<label for="titulo_orcamento"></label>';
                              echo '<input type="text" name="titulo_orcamento" id="titulo_orcamento" class="aspNetDisabled form-control form-control-sm" placeholder="Título do serviço">';
                              echo '<label for="vcusto_orcamento"></label>';
                              echo '<input type="tel" id="vcusto_orcamento" name="vcusto_orcamento" class="aspNetDisabled form-control form-control-sm" placeholder="Quanto custa este serviço?">';
                              echo '<label for="lancarOrcamento"></label>';
                              echo '<button type="submit" name="lancarOrcamento" id="lancarOrcamento" class="btn btn-success">Enviar</button>';
                              echo '</div>';
                              echo '</div>';
                              echo '</div>';
                              
                              //echo '<button type="submit" name="lancarOrcamento" class="btn btn-success">LançarOrcamento</button>';
                              //echo '<button type="submit" name="imprimir_os" class="btn btn-success">Imprimir OS</button>';
                              //echo '<button type="submit" name="via_cliente" class="btn btn-success">Via do Cliente (Impressão)</button>';
                              //echo '<button type="button" class="btn btn-success" onclick="enviarMensagemWhatsApp()">Via do Cliente (Whatsapp)</button>';
                              
                              echo '</form>';
                              //echo '</div>';
                            }
                          }
                          ?>
                    <?php
                  if(isset($_POST['limparFormulario'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    ////session_start();
                    $_SESSION['patrimonio_colab'] = 0;
                    $_SESSION['os_servico'] = 0;
                    $_SESSION['vtotal_orcamento'] = 0;
                    $_SESSION['vpag_servico'] = 0;
                    
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                    
                    
                }
                ?>


                <?php



                  if(isset($_POST['lancar1'])) { //CADASTRAR SERVICO E CHAMAR SERVICO CADASTRADO CADASTRADOS
                    //include("../../partials/load.html");
                    // Atualiza as informações do usuário no banco de dados
                    $insert_servico = "INSERT INTO tb_servico(cd_cliente, titulo_servico, obs_servico, prioridade_servico, entrada_servico, prazo_servico, orcamento_servico, vpag_servico, status_servico) VALUES(
                      '".$_POST['patrimonio_colab']."',
                      '".$_POST['titulo_servico']."',
                      '".$_POST['obs_servico']."',
                      '".$_POST['prioridade_servico']."',
                      '".$_POST['data_hora_ponto']."',
                      '".$_POST['prazo_servico']."',
                      '".$_POST['orcamento_servico']."',
                      '".$_POST['vpag_servico']."',
                      '0')
                    ";
                    mysqli_query($conn, $insert_servico);
                    echo "<script>window.alert('Ordem de Serviço criada com sucesso!');</script>";
                    //echo "<script>window.alert('Usuário atualizado com sucesso!');</script>";
                    $select_servico = "SELECT * FROM tb_servico WHERE cd_cliente = '".$_POST['patrimonio_colab']."' AND status_servico = 0 ORDER BY cd_servico DESC LIMIT 1";
                    $result = mysqli_query($conn, $select_servico);
                    $row = mysqli_fetch_assoc($result);
                    // Exibe as informações do usuário no formulário
                    if($row) {
                      echo "<script>window.alert('OS: ".$row['cd_servico']." Prioridade: ".$row['prioridade_servico'].", cadastrado com sucesso!');</script>";
                      
                      $_SESSION['os_servico'] = $row['cd_servico'];
                      
                      $_SESSION['titulo_servico'] = $row['titulo_servico'];
                      $_SESSION['obs_cliente'] = $row['obs_cliente'];
                      $_SESSION['prioridade_cliente'] = $row['prioridade_cliente'];
                      $_SESSION['prazo_servico'] = $row['prazo_servico'];
                      $_SESSION['orcamento_servico'] = $row['orcamento_servico'];
                      $_SESSION['vpag_servico'] = $row['vpag_servico'];

                      $query3 = "INSERT INTO tb_atividade(cd_servico, titulo_atividade, obs_atividade, cd_colab, inicio_atividade, fim_atividade) VALUES(
                        '".$row['cd_servico']."',
                        'A',
                        '".$row['obs_servico']."',
                        '".$_SESSION['cd_colab']."',
                        '".$_POST['data_hora_ponto']."',
                        '".$_POST['data_hora_ponto']."')
                      ";
                      mysqli_query($conn, $query3);
                      echo "<script>window.alert('Atividade Lançada!');</script>";           

                      $_SESSION['numserie_patrimonio'] = $row['numserie_patrimonio'];
                      header("Location: ".$_SERVER['REQUEST_URI']); // Redireciona para a mesma página
                       
                    }
                    
                  }
                  
                  
                  if(isset($_POST['pagar_servico'])){
                    $insert_pagar_servico = "INSERT INTO tb_movimento_financeiro(tipo_movimento, cd_caixa_movimento, cd_cliente_movimento, cd_colab_movimento, cd_os_movimento, fpag_movimento, valor_movimento, data_movimento, obs_movimento) VALUES(
                        1,
                        '".$_SESSION['cd_caixa']."',
                        '".$_SESSION['patrimonio_colab']."',
                        '".$_SESSION['cd_colab']."',
                        '".$_SESSION['os_servico']."',
                        '".$_POST['fpag_movimento']."',
                        '".$_POST['vpag_movimento']."',
                        '".date('Y-m-d H:i', strtotime('+1 hour'))."',
                        'PAGAMENTO DA OS: ".$_SESSION['os_servico']."'
                         )
                     ";
                    mysqli_query($conn, $insert_pagar_servico);
                    //echo "<script>window.alert('Movimento Financeiro Lançado!');</script>";
                    
        
                    $fechar_caixa = "UPDATE tb_servico SET
                        vpag_servico = '".($_POST['vpag_movimento'] + $_SESSION['vpag_servico'])."'
                        WHERE cd_servico = ".$_SESSION['os_servico']."";
                        mysqli_query($conn, $fechar_caixa);
                        //echo "<script>window.alert('Pagamento do Serviço Lançado!');</script>";
                        $_SESSION['vpag_servico'] = $_POST['vpag_movimento'] + $_SESSION['vpag_servico'];
                        $_SESSION['falta_pagar_servico'] = $_SESSION['vtotal_orcamento'] - $_SESSION['vpag_servico'];
                        echo  '<script>document.getElementById("btn_falta_pagar_orcamento").value = "'.$_SESSION['falta_pagar_servico'].'";</script>';
        
                        if($_SESSION['falta_pagar_servico'] == 0){
                            echo '<script>document.getElementById("tela_pagamento").style.display = "none";</script>';//tela_pagamento
                        }
                        //$_SESSION['cd_servico'] = 0;
                        //$_SESSION['cd_servico'] = 0;
                        //$_SESSION['cd_cliente'] = 0;
                        //echo '<script>location.href="../../index.php";</script>';
                  }
                  if(isset($_POST['lancarPagamento'])) {
                    $updateVpagServico = "UPDATE tb_servico SET
                    vpag_servico = ".$_POST['btnvpag_orcamento']."
                    WHERE cd_servico = ".$_SESSION['os_servico']."";
                    mysqli_query($conn, $updateVpagServico);
                    $_SESSION['vpag_servico'] = $_POST['btnvpag_orcamento'];
                    
                    echo  '<script>document.getElementById("btnvpag_orcamento").value = "'.$_POST['btnvpag_orcamento'].'";</script>';
                  }

                  

                

                  if(isset($_SESSION['os_servico'])){
                    if($_SESSION['os_servico'] > 0){
                      $select_orcamento = "SELECT * FROM tb_orcamento_servico WHERE cd_servico = '".$_SESSION['os_servico']."' ORDER BY cd_orcamento ASC";
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
                      //echo '<h3 class="kt-portlet__head-title">Serviços adicionados</h3>';
                      $_SESSION['vtotal_orcamento'] = 0;
                      $count = 0;
                      $vtotal = 0;
                      while($row_orcamento = $result_orcamento->fetch_assoc()) {
                        echo '<div name="listaOrcamento" id="listaOrcamento" class="typeahead">';
                        echo '<form method="POST">';
                        echo '<div class="horizontal-form">';
                        echo '<div class="form-group">';
                        $count = $count + 1;
                        
                        echo '<input value="'.$row_orcamento['cd_orcamento'].'" name="listaid_orcamento" id="listaid_orcamento" class="aspNetDisabled form-control form-control-sm" style="display:none;">';
                        echo '<label for="listatitulo_orcamento">'.$count.'</label>';
                        echo '<input value="'.$row_orcamento['titulo_orcamento'].'" name="listatitulo_orcamento" id="listatitulo_orcamento" type="text" class="aspNetDisabled form-control form-control-sm" readonly>';
                        echo '<label for="listavalor_orcamento">R$: </label>';
                        echo '<input value="'.$row_orcamento['vcusto_orcamento'].'" name="listavalor_orcamento" id="listavalor_orcamento" type="tel" class="aspNetDisabled form-control form-control-sm" placeholder="" readonly>';
                        echo '<label for="listaremover_orcamento"></label>';
                        //echo '<input type="submit" value="X" onclick="location.reload()" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                        echo '<input type="submit" value="X" name="listaremover_orcamento" id="listaremover_orcamento" class="btn btn-danger">';
                        
                        $vtotal = $vtotal + $row_orcamento['vcusto_orcamento'];
                        $_SESSION['vtotal_orcamento'] = $vtotal;
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        $i = 0;
                      }
                      
                      if(isset($_POST['listaremover_orcamento'])) {//DELETE FROM `tb_orcamento_servico` WHERE `tb_orcamento_servico`.`cd_orcamento` = 198
                        if(($_SESSION['vtotal_orcamento'] - $_POST['listavalor_orcamento'])>=$_SESSION['vpag_servico']){
                          //echo "<script>window.alert('OK, pode remover');</script>";
                          $vtotal = $vtotal - $_POST['listavalor_orcamento'];
                          $removeOrcamento = "DELETE FROM `tb_orcamento_servico` WHERE `tb_orcamento_servico`.`cd_orcamento` = ".$_POST['listaid_orcamento']."";
                          mysqli_query($conn, $removeOrcamento);
                          
                          $updateVtotalServico = "UPDATE tb_servico SET
                            orcamento_servico = ".$vtotal."
                            WHERE cd_servico = ".$_SESSION['os_servico']."";
                            mysqli_query($conn, $updateVtotalServico);
                            echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_assistencia/cadastro_servico.php";</script>';             
                        }else{
                          echo "<script>window.alert('Valor pago não pode ser maior que o total do serviço!');</script>";  
                        }
                      }
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6; display:none;">';
                      echo '<div class="horizontal-form">';
                      echo '<div class="form-group">';
                      
                      //$_SESSION['falta_pagar_servico'] = $_SESSION['vtotal_orcamento'] - $_SESSION['vpag_servico'];
                        echo '<label for="showobs_servico">Total:</label>';
                        echo '<input value="'.$_SESSION['vtotal_orcamento'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                        echo '<label for="showobs_servico">Pago:</label>';
                        echo '<input value="'.$_SESSION['vpag_servico'].'" type="tel" name="btnvpag_orcamento" id="btnvpag_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                        echo '<label for="showobs_servico">Falta:</label>';
                        echo '<input value="'.$_SESSION['falta_pagar_servico'].'" type="tel" name="btn_falta_pagar_orcamento" id="btn_falta_pagar_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                        
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
  
                      
                      
                      
  
                      if($_SESSION['vtotal_orcamento'] == 0){
                      }else{
                        echo '<form method="POST">';
                        echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="totalizador" name="totalizador" style="display: none;">';
                        echo '<label for="btncd_servico">OS</label>';
                        echo '<input value="'.$_SESSION['os_servico'].'" type="tel" name="btncd_servico" id="btncd_servico" class="aspNetDisabled form-control form-control-sm">';
                        echo '</div>';
                        echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" style="background-color: #C6C6C6;">';
                        echo '<div class="horizontal-form">';
                        echo '<div class="form-group">';
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
                      }
                      
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
                      echo '</form>';
  
                      
  
  
                      
  
  
  
                      
                        $_SESSION['tela_movimento_financeiro'] = "VENDA_SERVICO";
                        echo '<div class="col-12 grid-margin stretch-card btn-success">';//
                        echo '<div class="card">';
                        
                        include("../md_caixa/movimento_financeiro.php");
                        
                        echo '</div>';
                        echo '</div>';
                      
  
                      ?>
  
  
                      <?php
                      echo '<form action="impresso.php" method="POST" target="_blank">';
                      
                      echo '<div class="card-body" id="formBtn"><!--FORMULÁRIO DOS BOTOES-->';
                      echo '<div class="kt-portlet__body">';
                      echo '<div class="row">';
                      echo '<div class="col-12 col-md-12">';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                      
                      
  
  
  
  
                      //echo '<h3 class="kt-portlet__head-title">Dados do Cliente</h3> ';
                      echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" style="display:none;">';
                      echo '<input value="'.$_SESSION['patrimonio_colab'].'" name="btncd_cliente" type="text" id="showcd_cliente" class="aspNetDisabled form-control form-control-sm" style="display: none;"/>';
                      echo '<label for="btnpnome_colab">Nome</label>';
                      echo '<input value="'.$_SESSION['pnome_colab'].'" name="btnpnome_colab" type="text" id="btnpnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btnsnome_colab">sobrenome</label>';
                      echo '<input value="'.$_SESSION['snome_colab'].'" name="btnsnome_colab" type="text" id="btnsnome_colab" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                      echo '<label for="btntel_colab">Telefone</label>';
                      echo '<input value="'.$_SESSION['numserie_patrimonio'].'" name="btntel_colab" type="tel"  id="btntel_colab" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm"/>';
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
                      echo '<label for="showobs_servico">Total</label>';
                      echo '<input value="'.$_SESSION['vtotal_orcamento'].'" type="tel" name="btnvtotal_orcamento" id="btnvtotal_orcamento" class="aspNetDisabled form-control form-control-sm" readonly>';
                      echo '<label for="showobs_servico">Pago</label>';
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
                      //echo '<button type="submit" class="btn btn-danger" name="limparFormulario" style="margin: 5px;">Novo Serviço</button>';
                              
                      
                      echo '</div>';
                      echo '</form>';
                      echo '<form method="post">';
                      echo '<button type="submit" class="btn btn-block btn-lg btn-danger" name="limparFormulario" style="margin-top: 20px; margin-bottom: 20px;">Novo Serviço</button>';
                      echo '</form>';
  
                      
                    }
                  }
                ?>
                
                <script>
                  var data = new Date();
                  var dia = data.getDate() + 5;
                  var mes = data.getMonth() + 1;
                  var ano = data.getFullYear();
                  var hora = '16';
                  var minuto = '00';

                  // Verifica se ultrapassou o último dia do mês
                  if (dia > new Date(ano, mes, 0).getDate()) {
                      dia = dia - new Date(ano, mes, 0).getDate();
                      mes++;
                  }

                  // Atualiza o ano e o mês se necessário
                  if (mes > 12) {
                      mes = 1;
                      ano++;
                  }

                  document.getElementById("prazo_servico").value = `${ano}-${mes.toString().padStart(2, '0')}-${dia.toString().padStart(2, '0')}T${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}`;
                </script>

              </div>

                

              </div>
            </div>
          </div>
        
          <?php

?>

<script>
function enviarMensagemWhatsApp() {
  // Obter os valores dos campos do formulário
  var nomeCliente = document.getElementById("btnpnome_colab").value;
  var telefoneCliente = document.getElementById("btntel_colab").value;
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
                            var nome = document.getElementById("showpnome_colab").value;
                            var sobrenome = document.getElementById("showsnome_colab").value;
                            var telefone = document.getElementById("showtel_colab").value;

                            var cdServico = document.getElementById("showcd_servico").value;
                            var tituloServico = document.getElementById("showtitulo_servico").value;
                            var obsServico = document.getElementById("showobs_servico").value;
                            var prioridadeServico = document.getElementById("showprioridade_servico").value;
                            var prazoServico = document.getElementById("showprazo_servico").value;
                            var orcamentoServico = document.getElementById("showorcamento_servico").value;
                            var vpagServico = document.getElementById("showvpag_servico").value;

                            // Defina as posições da tabela no documento
                            var startX = 10;
                            var startY = 10;
                            var rowHeight = 10;
                            var columnWidth = 40;

                            // Defina a estrutura da tabela
                            var rows = [
                              ["Nome", "Sobrenome", "Telefone", "showcd_servico", "showtitulo_servico", "showobs_servico", "showprioridade_servico","showprazo_servico", "showorcamento_servico", "showvpag_servico"],
                              [nome, sobrenome, telefone, showcd_servico, showtitulo_servico, showobs_servico, showprioridade_servico, showprazo_servico, showorcamento_servico, showvpag_servico]
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