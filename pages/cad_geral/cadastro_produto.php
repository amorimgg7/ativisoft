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
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cadastro de Produtos</title>
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
            <!--
            <div class="col-12 grid-margin">
              <div class="card" <?php echo $_SESSION['c_card'];?>>
                
                <div class="card-body" id="consulta" style="display: block;">
                  <h3 class="card-title">Consultar pelo telefone</h3>
                  <p class="card-description">Consulte o cliente que deseja atualizar os dados cadastrais pelo número de telefone cadastrado.</p>
                  <div class="kt-portlet__body">
                    <div class="row">
                      <div class="col-12 col-md-12">
                        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                          <form method="POST">
                          
                            <input placeholder="Telefone" type="tel" name="btntel_cliente" id="btntel_cliente" type="tel" class="aspNetDisabled form-control form-control-sm" required>
                            <br>
                            <button type="submit" class="btn btn-success"name="con_cliente" >Consulta</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
  -->


            
              <?php
                if(isset($_POST['btn_con_prod_serv'])) {
                  
                  $query = "SELECT * FROM tb_prod_serv WHERE cd_prod_serv = '".$_POST['con_cd_prod_serv']."'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);

                  // Exibe as informações do usuário no formulário
                  if($row) {
                    $_SESSION['cd_prod_serv'] = $row['cd_prod_serv'];
                    $_SESSION['cd_classe_fiscal'] = $row['cd_classe_fiscal'];
                    $_SESSION['cd_grupo_prod_serv'] = $row['cd_grupo'];
                    $_SESSION['cdbarras_prod_serv'] = $row['cdbarras_prod_serv'];
                    $_SESSION['titulo_prod_serv'] = $row['titulo_prod_serv'];
                    $_SESSION['obs_prod_serv'] = $row['obs_prod_serv'];
                    $_SESSION['tipo_prod_serv'] = $row['tipo_prod_serv'];
                    $_SESSION['preco_prod_serv'] = $row['preco_prod_serv'];
                    $_SESSION['custo_prod_serv'] = $row['custo_prod_serv'];
                    $_SESSION['status_prod_serv'] = $row['status_prod_serv'];

                    $_SESSION['statusCadastros'] = 3;
                  }      
                }
                
              ?>
              <?php
                if (isset($_POST['editProdServ'])) {
                  $updatecliente = "UPDATE tb_prod_serv SET
                      cd_classe_fiscal = '" . $_POST['editcd_classe_fiscal'] . "',
                      cd_grupo = '" . $_POST['editcd_grupo'] . "',
                      cdbarras_prod_serv = '" . $_POST['editcdbarras_prod_serv'] . "',
                      titulo_prod_serv = '" . $_POST['edittitulo_prod_serv'] . "',
                      obs_prod_serv = '" . $_POST['editobs_prod_serv'] . "',
                      tipo_prod_serv = '" . $_POST['edittipo_prod_serv'] . "',
                      preco_prod_serv = '" . $_POST['editpreco_prod_serv'] . "',
                      custo_prod_serv = '" . $_POST['editcusto_prod_serv'] . "',
                      status_prod_serv = '" . $_POST['editstatus_prod_serv'] . "'
                      WHERE cd_prod_serv = " . $_POST['editcd_prod_serv'];
              
                  mysqli_query($conn, $updatecliente);

                  $query = "SELECT * FROM tb_prod_serv WHERE cd_prod_serv = '".$_POST['con_cd_prod_serv']."'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);

                  // Exibe as informações do usuário no formulário
                  if($row) {
                    $_SESSION['cd_prod_serv'] = $row['cd_prod_serv'];
                    $_SESSION['cd_classe_fiscal'] = $row['cd_classe_fiscal'];
                    $_SESSION['cd_grupo_prod_serv'] = $row['cd_grupo'];
                    $_SESSION['cdbarras_prod_serv'] = $row['cdbarras_prod_serv'];
                    $_SESSION['titulo_prod_serv'] = $row['titulo_prod_serv'];
                    $_SESSION['obs_prod_serv'] = $row['obs_prod_serv'];
                    $_SESSION['tipo_prod_serv'] = $row['tipo_prod_serv'];
                    $_SESSION['preco_prod_serv'] = $row['preco_prod_serv'];
                    $_SESSION['custo_prod_serv'] = $row['custo_prod_serv'];
                    $_SESSION['status_prod_serv'] = $row['status_prod_serv'];

                    $_SESSION['statusCadastros'] = 2;
                  }   
                  
              }
              

                if(isset($_POST['menuPrincipal'])) { 
                  $_SESSION['statusCadastros'] = FALSE;
                }

                if(isset($_POST['cadProdServ'])) { 
                  $_SESSION['cd_prod_serv']       = "";
                  $_SESSION['cd_classe_fiscal']   = "";
                  $_SESSION['cd_grupo_prod_serv'] = "";
                  $_SESSION['cdbarras_prod_serv'] = "";
                  $_SESSION['titulo_prod_serv']   = "";
                  $_SESSION['obs_prod_serv']      = "";
                  $_SESSION['tipo_prod_serv']     = "";
                  $_SESSION['preco_prod_serv']    = "";
                  $_SESSION['custo_prod_serv']    = "";
                  $_SESSION['status_prod_serv']   = "";

                  $_SESSION['statusCadastros']    = 2;
                }
                if(isset($_POST['cadGrupo'])) { 
                  $_SESSION['cd_grupo'] = "";
                  $_SESSION['cd_classe_fiscal_gupo'] = "";
                  $_SESSION['titulo_gupo'] = "";
                  $_SESSION['obs_gupo'] = "";
                  $_SESSION['tipo_gupo'] = "";
                  $_SESSION['status_gupo'] = "";

                  $_SESSION['statusCadastros'] = 1;
                }
                if(isset($_POST['cadGrupo_funcao'])) {
                  $query = "INSERT INTO tb_grupo(titulo_grupo, obs_grupo) VALUES(
                    '".$_POST['edittitulo_grupo']."',
                    '".$_POST['editdescricao_grupo']."')
                  ";
                  mysqli_query($conn, $query);
                  echo "<script>window.alert('Gruppo Cadastrado!');</script>";
                  $_SESSION['statusCadastros'] = FALSE;
                }
                if(isset($_POST['cadProdServ_funcao'])) {
                  $query = "INSERT INTO tb_prod_serv(cd_grupo, cdbarras_prod_serv, titulo_prod_serv, obs_prod_serv, preco_prod_serv, custo_prod_serv, status_prod_serv) VALUES(
                    '".$_POST['grupo_prod_serv']."',
                    '".$_POST['cdbarras_prod_serv']."',
                    '".$_POST['titulo_prod_serv']."',
                    '".$_POST['obs_prod_serv']."',
                    '".$_POST['preco_prod_serv']."',
                    '".$_POST['custo_prod_serv']."',
                    1)
                  ";
                  mysqli_query($conn, $query);
                  echo "<script>window.alert('Produto Cadastrado com sucesso!');</script>";
                  $_SESSION['statusCadastros'] = FALSE;
                }
                if(isset($_POST['gravaProdServ_funcao'])) {
                  $query = "UPDATE tb_prod_serv SET
                    cd_grupo = '".$_POST['editgrupo_prod_serv']."',
                    cdbarras_prod_serv = '".$_POST['editcdbarras_prod_serv']."',
                    titulo_prod_serv = '".$_POST['edittitulo_prod_serv']."',
                    obs_prod_serv = '".$_POST['editobs_prod_serv']."',
                    preco_prod_serv = '".$_POST['editpreco_prod_serv']."',
                    custo_prod_serv = '".$_POST['editcusto_prod_serv']."',
                    status_prod_serv = '".$_POST['editstatus_prod_serv']."'  
                    WHERE cd_prod_serv = '".$_POST['editcd_prod_serv']."'
                  ";
                  mysqli_query($conn, $query);
                  echo "<script>window.alert('Produto Atualizado com sucesso!');</script>";
                  $_SESSION['statusCadastros'] = FALSE;
                }
              ?>
              
              <?php
              if($_SESSION['statusCadastros'] == 1){//cadastro de grupo de produtos
                echo '<div class="col-12 grid-margin stretch-card btn-dark">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="col-12 col-md-12">';
                echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                echo '<h3 class="card-title">-_'.$_SESSION['statusCadastros'].'_-</h3>';
                echo '<form method="POST">';

                echo '<div class="form-group row justify-content-center">';
                echo '<div class="col text-center">';
                echo '<p class="mb-2 card-title">Grupo Atívo '.$_SESSION['status_prod_serv'].'</p>';
                echo '<span class="toggle-slider round"></span>';
                echo '</label>';
                echo '</div>';
                echo '</div>';
                echo '<label class="card-title"for="editcd_grupo"></label>';
                echo '<div class="input-group">';
                echo '<div class="input-group-prepend">';
                echo '<span class="input-group-text" style="width:150px;">Código</span>';
                echo '</div>';
                echo '<input value="'.$_SESSION['cd_grupo'].'" name="editcd_grupo" type="tel" id="editcd_grupo" class="form-control form-control-sm" style="display: block;" readonly/>';
                echo '</div>';

                echo '<label class="card-title"for="edittitulo_grupo"></label>';
                echo '<div class="input-group">';
                echo '<div class="input-group-prepend">';
                echo '<span class="input-group-text" style="width:150px;">Título: </span>';
                echo '</div>';
                echo '<input id="edittitulo_grupo" name="edittitulo_grupo" type="text" class="input-group-text form-control form-control-lg "/>';
                echo '</div>';

                echo '<label class="card-title"for="editdescricao_grupo"></label>';
                echo '<div class="input-group">';
                echo '<div class="input-group-prepend">';
                echo '<span class="input-group-text" style="width:150px;">Descrição: </span>';
                echo '</div>';
                echo '<input id="editdescricao_grupo" name="editdescricao_grupo" type="text" class="input-group-text form-control form-control-lg "/>';
                echo '</div>';

                
                

                    
                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="cadGrupo_funcao" id="cadGrupo_funcao" style="margin-top: 20px; margin-bottom: 20px;">Cadastrar</button>';
                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="menuPrincipal" id="menuPrincipal" style="margin-top: 20px; margin-bottom: 20px;">Voltar</button>';
                                
                echo '</form>';
              
                echo '</div>';
              }else if($_SESSION['statusCadastros'] == 2){//cadastro de produtos
                echo '<div class="col-12 grid-margin stretch-card btn-dark">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="col-12 col-md-12">';
                echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                echo '<h3 class="card-title">-_'.$_SESSION['statusCadastros'].'_-</h3>';
                echo '<form method="POST">';
                echo '<div class="form-group row justify-content-center">';
                echo '<div class="col text-center">';
                 
                
                echo '</label>';
                echo '</div>';
                echo '</div>';
                //echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" style="display:block;">';
                echo '<label class="card-title" for="cd_prod_serv">CD</label>';
                echo '<input value="'.$_SESSION['cd_prod_serv'].'" name="cd_prod_serv" type="tel" id="cd_prod_serv" class="aspNetDisabled form-control form-control-sm" style="display: block;" readonly/>';
                echo '<label class="card-title"for="editcdbarras_prod_serv">Código de Barras</label>';
                echo '<input value="'.$_SESSION['cdbarras_prod_serv'].'" name="cdbarras_prod_serv" type="tel"  id="cdbarras_prod_serv" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" oninput="validateInput(this)" required/>';
                echo '<label class="card-title"for="cdbarras_prod_serv">Grupo</label>';
                echo '<div class="input-group">';
                echo '<div class="input-group-prepend">';
                echo '<span class="input-group-text">Grupo: </span>';
                echo '</div>'; 
                echo '<select id="grupo_prod_serv" name="grupo_prod_serv" type="tel" class="input-group-text form-control form-control-lg " required>';
                $select_show_grupo = "SELECT * FROM tb_grupo WHERE cd_grupo = '".$_SESSION['cd_grupo_prod_serv']."'";
                $resulta_show_grupo = $conn->query($select_show_grupo);
                if ($resulta_show_grupo->num_rows > 0){
                  while ($row_show_grupo = $resulta_show_grupo->fetch_assoc()){
                    echo '<option selected value="'.$row_show_grupo['cd_grupo'].'">'.$row_show_grupo['titulo_grupo'].'</option>';
                  }
                }
                $select_edit_grupo = "SELECT * FROM tb_grupo WHERE cd_grupo != '".$_SESSION['cd_grupo_prod_serv']."' ORDER BY cd_grupo ASC";
                $resulta_edit_grupo = $conn->query($select_edit_grupo);
                if ($resulta_edit_grupo->num_rows > 0){
                  while ($row_edit_grupo = $resulta_edit_grupo->fetch_assoc()){
                    echo '<option value="'.$row_edit_grupo['cd_grupo'].'">'.$row_edit_grupo['titulo_grupo'].'</option>';
                  }
                }
                echo '</select>';
                echo '</div>';
                echo '<label class="card-title"for="titulo_prod_serv">Nome / Descrição</label>';
                echo '<input value="'.$_SESSION['titulo_prod_serv'].'" name="titulo_prod_serv" type="text" id="titulo_prod_serv" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>';
                echo '<label class="card-title"for="obs_prod_serv">Observações</label>';
                echo '<input value="'.$_SESSION['obs_prod_serv'].'" name="obs_prod_serv" type="text" id="obs_prod_serv" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>';
                echo '<label class="card-title"for="preco_prod_serv">Valor de Venda</label>';
                echo '<div class="input-group">';
                echo '<div class="input-group-prepend">';
                echo '<span class="input-group-text btn-outline-info">R$:</span>';
                echo '</div>'; 
                echo '<input value="'.$_SESSION['preco_prod_serv'].'" name="preco_prod_serv" type="tel"  id="preco_prod_serv" maxlenth="10" class="aspNetDisabled form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';
                echo '<label class="card-title"for="custo_prod_serv">Valor de compra</label>';
                echo '<div class="input-group">';
                echo '<div class="input-group-prepend">';
                echo '<span class="input-group-text btn-outline-info">R$:</span>';
                echo '</div>'; 
                echo '<input value="'.$_SESSION['custo_prod_serv'].'" name="custo_prod_serv" type="tel"  id="custo_prod_serv" maxlenth="10" class="aspNetDisabled form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';

                    
                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="cadProdServ_funcao" id="cadProdServ_funcao" style="margin-top: 20px; margin-bottom: 20px;">Gravar</button>';
                                
                echo '</form>';
                echo '<form method="POST">';
                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="menuPrincipal" id="menuPrincipal" style="margin-top: 20px; margin-bottom: 20px;">Sair</button>';
                echo '</form>';
              
                echo '</div>';
              
              }else if($_SESSION['statusCadastros'] == 3){//editar produto
                echo '<div class="col-12 grid-margin stretch-card btn-dark">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="col-12 col-md-12">';
                echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                echo '<h3 class="card-title">-_'.$_SESSION['statusCadastros'].'_-</h3>';
                echo '<form method="POST">';
                echo '<div class="form-group row justify-content-center">';
                echo '<div class="col text-center">';
                 
                
                echo '</label>';
                echo '</div>';
                echo '</div>';
                //echo '<div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead" id="botoes" name="botoes" style="display:block;">';
                echo '<label class="card-title" for="editstatus_prod_serv">Status</label>';
                echo '<input value="'.$_SESSION['status_prod_serv'].'" name="editstatus_prod_serv" type="tel" id="editstatus_prod_serv" class="aspNetDisabled form-control form-control-sm" style="display: block;" required/>';
                
                echo '<label class="card-title" for="editcd_prod_serv">CD</label>';
                echo '<input value="'.$_SESSION['cd_prod_serv'].'" name="editcd_prod_serv" type="tel" id="editcd_prod_serv" class="aspNetDisabled form-control form-control-sm" style="display: block;" readonly/>';
                echo '<label class="card-title"for="editcdbarras_prod_serv">Código de Barras</label>';
                echo '<input value="'.$_SESSION['cdbarras_prod_serv'].'" name="editcdbarras_prod_serv" type="tel"  id="editcdbarras_prod_serv" oninput="tel(this)" class="aspNetDisabled form-control form-control-sm" oninput="validateInput(this)" required/>';
                echo '<label class="card-title"for="editcdbarras_prod_serv">Grupo</label>';
                echo '<div class="input-group">';
                echo '<div class="input-group-prepend">';
                echo '<span class="input-group-text">Grupo: </span>';
                echo '</div>'; 
                echo '<select id="editgrupo_prod_serv" name="editgrupo_prod_serv" type="tel" class="input-group-text form-control form-control-lg " required>';
                $select_show_grupo = "SELECT * FROM tb_grupo WHERE cd_grupo = '".$_SESSION['cd_grupo_prod_serv']."'";
                $resulta_show_grupo = $conn->query($select_show_grupo);
                if ($resulta_show_grupo->num_rows > 0){
                  while ($row_show_grupo = $resulta_show_grupo->fetch_assoc()){
                    echo '<option selected value="'.$row_show_grupo['cd_grupo'].'">'.$row_show_grupo['titulo_grupo'].'</option>';
                  }
                }
                $select_edit_grupo = "SELECT * FROM tb_grupo WHERE cd_grupo != '".$_SESSION['cd_grupo_prod_serv']."' ORDER BY cd_grupo ASC";
                $resulta_edit_grupo = $conn->query($select_edit_grupo);
                if ($resulta_edit_grupo->num_rows > 0){
                  while ($row_edit_grupo = $resulta_edit_grupo->fetch_assoc()){
                    echo '<option value="'.$row_edit_grupo['cd_grupo'].'">'.$row_edit_grupo['titulo_grupo'].'</option>';
                  }
                }
                echo '</select>';
                echo '</div>';
                echo '<label class="card-title"for="edittitulo_prod_serv">Nome / Descrição</label>';
                echo '<input value="'.$_SESSION['titulo_prod_serv'].'" name="edittitulo_prod_serv" type="text" id="edittitulo_prod_serv" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>';
                echo '<label class="card-title"for="editobs_prod_serv">Observações</label>';
                echo '<input value="'.$_SESSION['obs_prod_serv'].'" name="editobs_prod_serv" type="text" id="editobs_prod_serv" maxlength="40"   class="aspNetDisabled form-control form-control-sm" required/>';
                echo '<label class="card-title"for="editpreco_prod_serv">Valor de Venda</label>';
                echo '<div class="input-group">';
                echo '<div class="input-group-prepend">';
                echo '<span class="input-group-text btn-outline-info">R$:</span>';
                echo '</div>'; 
                echo '<input value="'.$_SESSION['preco_prod_serv'].'" name="editpreco_prod_serv" type="tel"  id="editpreco_prod_serv" maxlenth="10" class="aspNetDisabled form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';
                echo '<label class="card-title"for="editcusto_prod_serv">Valor de compra</label>';
                echo '<div class="input-group">';
                echo '<div class="input-group-prepend">';
                echo '<span class="input-group-text btn-outline-info">R$:</span>';
                echo '</div>'; 
                echo '<input value="'.$_SESSION['custo_prod_serv'].'" name="editcusto_prod_serv" type="tel"  id="editcusto_prod_serv" maxlenth="10" class="aspNetDisabled form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';

                    
                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="gravaProdServ_funcao" id="gravaProdServ_funcao" style="margin-top: 20px; margin-bottom: 20px;">Gravar</button>';
                                
                echo '</form>';
                echo '<form method="POST">';
                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="menuPrincipal" id="menuPrincipal" style="margin-top: 20px; margin-bottom: 20px;">Sair</button>';
                echo '</form>';
              
                echo '</div>';
              
              }else if($_SESSION['statusCadastros'] == 3){//editar produto
                echo '<div class="col-12 grid-margin stretch-card btn-dark">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="col-12 col-md-12">';
                echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                echo '<h3 class="card-title">-_'.$_SESSION['statusCadastros'].'_-</h3>';
                
              
                echo '</div>';
              }else{
                $select_grupo = "SELECT * FROM tb_grupo ORDER BY cd_grupo ASC";
                $resulta_grupo = $conn->query($select_grupo);
                if ($resulta_grupo->num_rows > 0){
                  while ( $row_grupo = $resulta_grupo->fetch_assoc()){
                    echo '<div class="col-lg-12 grid-margin stretch-card"  data-toggle="collapse" href="#grupo_'.$row_grupo['cd_grupo'].'" aria-expanded="false" aria-controls="grupo_'.$row_grupo['cd_grupo'].'">';
                    echo '<div class="card" '.$_SESSION['c_card'].'>';
                    echo '<div class="card-body">';
                  
                    echo '<h4 class="card-title" style="text-align: center;">'.$row_grupo['titulo_grupo'].'</h4>';
                    echo '<h6 class="card-title" style="text-align: center;">'.$row_grupo['obs_grupo'].'</h6>';
                    echo '<div class="collapse table-responsive" id="grupo_'.$row_grupo['cd_grupo'].'">';
                  
                    echo '<form method="POST">';
                    echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="cadProdServ" id="cadProdServ" style="margin-top: 20px; margin-bottom: 20px;">Novo Produto</button>';
                    echo '</form>';
                    $select_produtos = "SELECT * FROM tb_prod_serv WHERE cd_grupo = '".$row_grupo['cd_grupo']."' ORDER BY cd_prod_serv ASC";
                    $resulta_produtos = $conn->query($select_produtos);
                    if ($resulta_produtos->num_rows > 0){

                      echo '<table class="table" '.$_SESSION['c_card'].'>';
                      echo '<thead>';
                      echo '<tr>';
                      echo '<th>CD</th>';
                      echo '<th>Nome</th>';
                      echo '<th>Preço</th>';
                      echo '</tr>';
                      echo '</thead>';
                      echo '<tbody>';

                      while ($row_produtos = $resulta_produtos->fetch_assoc()){
                    
                        echo '<tr>';
                        echo '<form method="POST">';
                        if($row_produtos['status_prod_serv'] == 0){
                          echo '<td style="display: none;"><input type="tel" id="con_cd_prod_serv" name="con_cd_prod_serv" value="'.$row_produtos['cd_prod_serv'].'"></td>';
                          echo '<td><button type="submit" class="btn btn-outline-danger" name="btn_con_prod_serv" id="btn_con_prod_serv">'.$row_produtos['cd_prod_serv'].'</button></td>';
                        }else{
                          echo '<td style="display: none;"><input type="tel" id="con_cd_prod_serv" name="con_cd_prod_serv" value="'.$row_produtos['cd_prod_serv'].'"></td>';
                          echo '<td><button type="submit" class="btn btn-outline-success" name="btn_con_prod_serv" id="btn_con_prod_serv">'.$row_produtos['cd_prod_serv'].'</button></td>';
                        }
                        
                        echo '</form>';
                        echo '<td>'.$row_produtos['titulo_prod_serv'].'</td>';
                        echo '<td>R$: '.$row_produtos['preco_prod_serv'].'</td>';
                        echo '</tr>';
                      }

                      echo '</tbody>';
                      echo '</table>';
                    }

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';


                  }
                }
                echo '<form method="POST">';
                  echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="cadGrupo" id="cadGrupo" style="margin-top: 20px; margin-bottom: 20px;">Novo Grupo</button>';
                  echo '</form>';
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