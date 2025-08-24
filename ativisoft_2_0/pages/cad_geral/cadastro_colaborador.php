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



    $result = $u->retPermissão('md_venda_produto', $_SESSION['md_venda']);
    

?><!--Validar sessão aberta, se usuário está logado.-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cadastro de Colaborador</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <script src="../../js/functions.js"></script>
  <link rel="shortcut icon" href="<?php //echo $_SESSION['logo_empresa']; ?>" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>

  <script>
                            function showSection(tab) {
                              if(tab == "tabBasicos"){
                                document.getElementById('tabBasicos').style.display = 'block';
                                document.getElementById('tabComissao').style.display = 'none';
                                document.getElementById('tabAcesso').style.display = 'none';
                              }

                              if(tab == "tabComissao"){
                                document.getElementById('tabBasicos').style.display = 'none';
                                document.getElementById('tabComissao').style.display = 'block';
                                document.getElementById('tabAcesso').style.display = 'none';
                              }

                              if(tab == "tabAcesso"){
                                document.getElementById('tabBasicos').style.display = 'none';
                                document.getElementById('tabComissao').style.display = 'none';
                                document.getElementById('tabAcesso').style.display = 'block';
                              }
                              
                            }
                          </script>

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
        <?php echo '<spam>'.$result.'</spam>'; ?>     
        <div class="content-wrapper" <?php echo $_SESSION['c_body'];?>>
          <div class="row">  
              <?php
                if(isset($_POST['btn_con_colab'])) {
                  $query = "SELECT * FROM tb_pessoa WHERE cd_pessoa = '".$_POST['con_cd_colab']."'";
                  $result = mysqli_query($conn, $query);
                  $row = mysqli_fetch_assoc($result);

                  // Exibe as informações do usuário no formulário
                  if($row) {

                    $_SESSION['cad_cd_colab']           = $row['cd_pessoa'];
                    $_SESSION['cad_pnome_colab']        = $row['pnome_pessoa'];
                    $_SESSION['cad_snome_colab']        = $row['snome_pessoa'];
                    $_SESSION['cad_subtipo_colab']      = $row['subtipo_pessoa'];
                    $_SESSION['cad_cpf_colab']          = $row['cpf_pessoa'];
                    $_SESSION['cad_tel1_colab']         = $row['tel1_pessoa'];
                    $_SESSION['cad_email_colab']        = $row['email_pessoa'];
                    $_SESSION['cad_senha_colab']        = $row['senha_pessoa'];
                    $_SESSION['cad_vl_comissao_colab']  = $row['vl_comissao_padrao'];
                    $_SESSION['cad_pc_comissao_colab']  = $row['pc_comissao_padrao'];
                    $_SESSION['cad_cd_empresa']         = $row['cd_empresa'];
                    $_SESSION['cad_cd_filial']          = $row['cd_filial'];
                    $_SESSION['cad_status_colab']       = $row['status_pessoa'];
                    


                    //$_SESSION['cd_prod_serv'] = $row['cd_prod_serv'];
                    //$_SESSION['cd_classe_fiscal'] = $row['cd_classe_fiscal'];
                    //$_SESSION['cd_grupo_prod_serv'] = $row['cd_grupo'];
                    //$_SESSION['cdbarras_prod_serv'] = $row['cdbarras_prod_serv'];
                    //$_SESSION['titulo_prod_serv'] = $row['titulo_prod_serv'];
                    //$_SESSION['obs_prod_serv'] = $row['obs_prod_serv'];
                    //$_SESSION['estoque_prod_serv'] = $row['estoque_prod_serv'];
                    //$_SESSION['tipo_prod_serv'] = $row['tipo_prod_serv'];
                    //$_SESSION['preco_prod_serv'] = $row['preco_prod_serv'];
                    //$_SESSION['custo_prod_serv'] = $row['custo_prod_serv'];
                    //$_SESSION['status_colab'] = $row['status_colab'];
                    echo '<script>';
                    echo 'document.addEventListener("DOMContentLoaded", function() {';
                    echo '    var editcheckstatus_colab = document.getElementById("editcheckstatus_colab");';
                    echo '    if (' . $_SESSION['cad_status_colab'] . ' == 1) {';
                    echo '        editcheckstatus_colab.checked = true;';
                    echo '    } else {';
                    echo '        editcheckstatus_colab.checked = false;';
                    echo '    }';
                    echo '});';
                    echo '</script>';
                    $_SESSION['statusCadastrosColab'] = 3;
                  }      
                }
                
              ?>
              <?php
              /*
                if (isset($_POST['editProdServ'])) {

                  if($_POST['editstatus_colab'] == false){
                    $status_colab = 0;
                  }else{
                    $status_colab = 1;
                  }

                  $updatecliente = "UPDATE tb_prod_serv SET
                      cd_classe_fiscal = '" . $_POST['editcd_classe_fiscal'] . "',
                      cd_grupo = '" . $_POST['editcd_grupo'] . "',
                      cdbarras_prod_serv = '" . $_POST['editcdbarras_prod_serv'] . "',
                      titulo_prod_serv = '" . $_POST['edittitulo_prod_serv'] . "',
                      obs_prod_serv = '" . $_POST['editobs_prod_serv'] . "',
                      tipo_prod_serv = '" . $_POST['edittipo_prod_serv'] . "',
                      preco_prod_serv = '" . $_POST['editpreco_prod_serv'] . "',
                      custo_prod_serv = '" . $_POST['editcusto_prod_serv'] . "',
                      status_colab = '" . $status_colab = 0 . "'
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
                    $_SESSION['status_colab'] = $row['status_colab'];

                    $_SESSION['statusCadastrosColab'] = 2;
                  }   
                  
                }
              */

                if(isset($_POST['menuPrincipal'])) { 
                  $_SESSION['statusCadastrosColab'] = FALSE;
                }

                if(isset($_POST['cadColab'])) { 
                  $_SESSION['cad_cd_colab']           = "";
                  $_SESSION['cad_pnome_colab']        = "";
                  $_SESSION['cad_snome_colab']        = "";
                  $_SESSION['cad_subtipo_colab']      = "";
                  $_SESSION['cad_cpf_colab']          = "";
                  $_SESSION['cad_tel1_colab']         = "";
                  $_SESSION['cad_email_colab']        = "";
                  $_SESSION['cad_senha_colab']        = "";
                  $_SESSION['cad_vl_comissao_colab']  = "";
                  $_SESSION['cad_pc_comissao_colab']  = "";
                  $_SESSION['cad_cd_empresa']         = "";
                  $_SESSION['cad_cd_filial']          = "";
                  $_SESSION['statusCadastrosColab']        = 2;
                }

                if(isset($_POST['cadastraColab_funcao'])) {
                  $query = "INSERT INTO tb_pessoa(pnome_pessoa, snome_pessoa, tipo_pessoa, subtipo_pessoa, cpf_pessoa, tel1_pessoa, email_pessoa, vl_comissao_padrao, pc_comissao_padrao, cd_empresa, cd_filial, senha_pessoa, status_pessoa) VALUES(
                    '".$_POST['cad_pnome_colab']."',
                    '".$_POST['cad_snome_colab']."',
                    'colab',
                    '".$_POST['cad_subtipo_colab']."',
                    '".$_POST['cad_cpf_colab']."',
                    '".$_POST['cad_tel1_colab']."',
                    '".$_POST['cad_email_colab']."',
                    '".$_POST['cad_vl_comissao_colab']."',
                    '".$_POST['cad_pc_comissao_colab']."',
                    '".$_SESSION['cd_empresa']."',
                    '".$_SESSION['cd_filial']."',
                    '1',
                    1)
                  ";
                  //echo
                  mysqli_query($conn, $query);
                  echo "<script>window.alert('Colaborador Cadastrado com sucesso!');</script>";
                  $_SESSION['statusCadastrosColab'] = FALSE;
                }
                if(isset($_POST['gravaColab_funcao'])) {
                  $query = "UPDATE tb_pessoa SET
                    pnome_pessoa    = '".$_POST['edit_pnome_colab']."',
                    snome_pessoa    = '".$_POST['edit_snome_colab']."',
                    subtipo_pessoa    = '".$_POST['edit_subtipo_colab']."',
                    cpf_pessoa    = '".$_POST['edit_cpf_colab']."',
                    tel1_pessoa   = '".$_POST['edit_tel1_colab']."',
                    email_pessoa    = '".$_POST['edit_email_colab']."',
                    vl_comissao_padrao    = '".$_POST['edit_vl_comissao_colab']."',
                    pc_comissao_padrao    = '".$_POST['edit_pc_comissao_colab']."',
                    status_pessoa    = '".$_POST['edit_status_colab']."'
                    WHERE cd_pessoa = '".$_POST['edit_cd_colab']."'
                  ";
                  mysqli_query($conn, $query);
                  //echo "<script>window.alert('Colaborador Atualizado com sucesso!');</script>";
                  $_SESSION['statusCadastrosColab'] = FALSE;
                }

                
              ?>
              
              <?php
              if($_SESSION['statusCadastrosColab'] == 1){//cadastro de grupo de produtos
                echo '<div class="col-12 grid-margin stretch-card btn-dark">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="col-12 col-md-12">';
                echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                echo '<h3 class="card-title">-_'.$_SESSION['statusCadastrosColab'].'_-</h3>';
                echo '<form method="POST">';

                echo '<div class="form-group row justify-content-center">';
                echo '<div class="col text-center">';
                echo '<p class="mb-2 card-title">Grupo Atívo '.$_SESSION['status_colab'].'</p>';
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
                echo '<input id="edittitulo_grupo" name="edittitulo_grupo" type="text" class="form-control form-control-lg " placeholder="Digite aqui"/>';
                echo '</div>';

                echo '<label class="card-title"for="editdescricao_grupo"></label>';
                echo '<div class="input-group">';
                echo '<div class="input-group-prepend">';
                echo '<span class="input-group-text" style="width:150px;">Descrição: </span>';
                echo '</div>';
                echo '<input id="editdescricao_grupo" name="editdescricao_grupo" type="text" class="form-control form-control-lg "placeholder="Digite aqui"/>';
                echo '</div>';

                
                

                    
                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="cadGrupo_funcao" id="cadGrupo_funcao" style="margin-top: 20px; margin-bottom: 20px;">Cadastrar</button>';
                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="menuPrincipal" id="menuPrincipal" style="margin-top: 20px; margin-bottom: 20px;">Voltar</button>';
                                
                echo '</form>';
              
                echo '</div>';
              }else if($_SESSION['statusCadastrosColab'] == 2){//cadastro de Colaborador
                
                echo '<div class="col-12 grid-margin stretch-card btn-dark">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';
                echo '<div class="col-12 col-md-12">';
                echo '<div class="nc-form-tac">';
                //echo '<h3 class="card-title">-_'.$_SESSION['cad_status_colab'].'_-</h3>';
                echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="POST" enctype="multipart/form-data">';
                echo '<div class="form-group row justify-content-center">';
                echo '<div class="col text-center">';
                 
                echo '</div>';
                echo '</div>';
                
                //echo '<div class="col text-center">';
                //echo '    <p class="mb-2 card-title" id="status">Colaborador Inativo</p>';
                //echo '    <label class="toggle-switch toggle-switch-success">';
                //echo '        <input name="editcheckstatus_colab" id="editcheckstatus_colab" ';
                //if($_SESSION['cad_status_colab'] == 1){echo 'checked="checked"';};
                //echo ' type="checkbox" onclick="handleCheckboxClick(this);">';
                //echo '        <span class="toggle-slider round"></span>';
                //echo '    </label>';
                //echo '</div>';

                
                //echo '<script>';
                //echo 'function handleCheckboxClick(checkbox) {';
                //echo '    var statusElement = document.getElementById("status");';
                //echo '    if (checkbox.checked) {';
                //echo '        statusElement.textContent = "Colaborador Ativo";';
                //echo '        document.getElementById("editstatus_colab").value = "1";';
                //echo '    } else {';
                //echo '        statusElement.textContent = "Colaborador Inativo";';
                //echo '        document.getElementById("editstatus_colab").value = "0";';
                //echo '    }';
                //echo '}';
                //echo '</script>';
                
                echo '<input value="1" name="cad_status_colab" type="tel" id="cad_status_colab" class="form-control form-control-sm" style="display: none;" required/>';
                

                

                echo '<div class="input-group">';

                //echo '<div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">';
                //echo '<span class="card-title">Código</span>';
                //echo '<div class="input-group-prepend">';
                //echo '<input value="'.$_SESSION['cad_cd_colab'].'" name="edit_cd_colab" type="tel" id="edit_cd_colab" class="aspNetDisabled form-control form-control-sm" style="display: block;" readonly/>';
                //echo '</div>';
                //echo '</div>';
                
                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">Função</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_subtipo_colab'].'" name="cad_subtipo_colab" type="tel"  id="cad_subtipo_colab" class="form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';

                echo '<div class="col-sm-12 col-md-6 col-lg-7 col-xl-7">';
                echo '<span class="card-title">Nome</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_pnome_colab'].'" name="cad_pnome_colab" type="text" id="cad_pnome_colab" maxlength="40"   class="form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';

                echo '<div class="col-sm-12 col-md-6 col-lg-7 col-xl-7">';
                echo '<span class="card-title">Sobrenome</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_snome_colab'].'" name="cad_snome_colab" type="text" id="cad_snome_colab" maxlength="40"   class="form-control form-control-sm"/>';
                echo '</div>';
                echo '</div>';


                echo '<div class="row justify-content-center col-sm-12 col-md-12 col-lg-12 col-xl-12">';
                echo '<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                echo '<div class="input-group-prepend">';
                echo '<button type="button" id="menuBasicos" name="menuBasicos" onclick="showSection(\'tabBasicos\')" class="btn btn-outline-secondary btn-lg btn-block">Basicos</button>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                echo '<div class="input-group-prepend">';
                echo '<button type="button" id="menuComissao" name="menuComissao" onclick="showSection(\'tabComissao\')" class="btn btn-outline-secondary btn-lg btn-block">Comissão</button>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                echo '<div class="input-group-prepend">';
                echo '<button type="button" id="menuAcesso" name="menuAcesso" onclick="showSection(\'tabAcesso\')" class="btn btn-outline-secondary btn-lg btn-block">Acesso</button>';
                echo '</div>';
                echo '</div>';
								echo '</div>';
                echo '<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="tabBasicos" name="tabBasicos">';
                echo '<div class="row justify-content-center col-sm-12 col-md-12 col-lg-12 col-xl-12">';
                
                //echo '<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">';
                //echo '<span class="card-title">Grupo</span>';
                //echo '<div class="input-group-prepend">';
                //echo '<select id="editgrupo_prod_serv" name="editgrupo_prod_serv" type="tel" class="input-group-text form-control form-control-lg" required>';
                //$select_show_grupo = "SELECT * FROM tb_grupo WHERE cd_grupo = '".$_SESSION['cd_grupo_prod_serv']."'";
                //$resulta_show_grupo = $conn->query($select_show_grupo);
                //if ($resulta_show_grupo->num_rows > 0){
                //  while ($row_show_grupo = $resulta_show_grupo->fetch_assoc()){
                //    echo '<option selected value="'.$row_show_grupo['cd_grupo'].'">'.$row_show_grupo['titulo_grupo'].'</option>';
                //  }
                //}
                //$select_edit_grupo = "SELECT * FROM tb_grupo WHERE cd_grupo != '".$_SESSION['cd_grupo_prod_serv']."' and cd_filial = '".$_SESSION['cd_filial']."' ORDER BY titulo_grupo ASC";
                //$resulta_edit_grupo = $conn->query($select_edit_grupo);
                //if ($resulta_edit_grupo->num_rows > 0){
                //  while ($row_edit_grupo = $resulta_edit_grupo->fetch_assoc()){
                //    echo '<option value="'.$row_edit_grupo['cd_grupo'].'">'.$row_edit_grupo['titulo_grupo'].'</option>';
                //  }
                //}
                //echo '</select>';
                //echo '</div>';
                //echo '</div>';
                
                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">CPF</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_cpf_colab'].'" name="cad_cpf_colab" type="tel" id="cad_cpf_colab" class="form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';
                
                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">Telefone</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_tel1_colab'].'" name="cad_tel1_colab" type="text" id="cad_tel1_colab" maxlength="10"   class="form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';

                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">Email</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_email_colab'].'" name="cad_email_colab" type="tel" id="cad_email_colab" class="form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';

                echo '</div>';
                echo '</div>';




                echo '<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="tabComissao" name="tabComissao" style="display:none;">';
                echo '<div class="row justify-content-center col-sm-12 col-md-12 col-lg-12 col-xl-12">';
                
                //echo '<h1 class="display-1 text-secondary">Em breve</h1>';
                
                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">Valor comissão</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_vl_comissao_colab'].'" name="cad_vl_comissao_colab" type="text" id="cad_vl_comissao_colab" maxlength="10"   class="form-control form-control-sm" />';
                echo '</div>';
                echo '</div>';

                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">% Comissão</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_pc_comissao_colab'].'" name="cad_pc_comissao_colab" type="tel" id="cad_pc_comissao_colab" class="form-control form-control-sm" />';
                echo '</div>';
                echo '</div>';

                echo '</div>';
                echo '</div>';

                echo '
                <script>
document.addEventListener("DOMContentLoaded", function() {
    const vlComissao = document.getElementById("cad_vl_comissao_colab");
    const pcComissao = document.getElementById("cad_pc_comissao_colab");

    vlComissao.addEventListener("input", function() {
        if (this.value.trim() !== "" && parseFloat(this.value) > 0) {
            pcComissao.value = 0;
        }
    });

    pcComissao.addEventListener("input", function() {
        if (this.value.trim() !== "" && parseFloat(this.value) > 0) {
            vlComissao.value = 0;
        }
    });
});
</script>

                ';



                echo '<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="tabAcesso" name="tabAcesso" style="display:none;">';
                echo '<div class="row justify-content-center col-sm-12 col-md-12 col-lg-12 col-xl-12">';

                echo '<h1 class="display-1 text-secondary">Em breve</h1>';

                echo '</div>';
                echo '</div>';


                echo '</div>';

                echo '</div>';
                echo '</div>';

                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="cadastraColab_funcao" id="cadastraColab_funcao" style="margin-top: 20px; margin-bottom: 20px;">Gravar</button>';
                                
                echo '</form>';
                echo '<form method="POST">';
                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="menuPrincipal" id="menuPrincipal" style="margin-top: 20px; margin-bottom: 20px;">Sair</button>';
                echo '</form>';
              
                echo '</div>';
                echo '</div>';
                echo '</div>';
              
              }else if($_SESSION['statusCadastrosColab'] == 3){//editar Colaborador
                echo '<div class="col-12 grid-margin stretch-card btn-dark">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';
                echo '<div class="col-12 col-md-12">';
                echo '<div class="nc-form-tac">';
                echo '<h3 class="card-title">-_'.$_SESSION['cad_status_colab'].'_-</h3>';
                echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="POST" enctype="multipart/form-data">';
                echo '<div class="form-group row justify-content-center">';
                echo '<div class="col text-center">';
                 
                echo '</div>';
                echo '</div>';
                
                echo '<div class="col text-center">';
                echo '    <p class="mb-2 card-title" id="status">Colaborador Inativo</p>';
                echo '    <label class="toggle-switch toggle-switch-success">';
                echo '        <input name="editcheckstatus_colab" id="editcheckstatus_colab" ';
                if($_SESSION['cad_status_colab'] == 1){echo 'checked="checked"';};
                echo ' type="checkbox" onclick="handleCheckboxClick(this);">';
                echo '        <span class="toggle-slider round"></span>';
                echo '    </label>';
                echo '</div>';

                
                echo '<script>';
                echo 'function handleCheckboxClick(checkbox) {';
                echo '    var statusElement = document.getElementById("status");';
                echo '    if (checkbox.checked) {';
                echo '        statusElement.textContent = "Colaborador Ativo";';
                echo '        document.getElementById("edit_status_colab").value = "1";';
                echo '    } else {';
                echo '        statusElement.textContent = "Colaborador Inativo";';
                echo '        document.getElementById("edit_status_colab").value = "0";';
                echo '    }';
                echo '}';
                echo '</script>';
                
                echo '<input value="'.$_SESSION['cad_status_colab'].'" name="edit_status_colab" type="tel" id="edit_status_colab" class="aspNetDisabled form-control form-control-sm" style="display: block;" required/>';
                

                

                echo '<div class="input-group">';

                echo '<div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">';
                echo '<span class="card-title">Código</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_cd_colab'].'" name="edit_cd_colab" type="tel" id="edit_cd_colab" class="aspNetDisabled form-control form-control-sm" style="display: block;" readonly/>';
                echo '</div>';
                echo '</div>';
                
                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">Função</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_subtipo_colab'].'" name="edit_subtipo_colab" type="tel"  id="edit_subtipo_colab" class="form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';

                echo '<div class="col-sm-12 col-md-6 col-lg-7 col-xl-7">';
                echo '<span class="card-title">Nome</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_pnome_colab'].'" name="edit_pnome_colab" type="text" id="edit_pnome_colab" maxlength="40"   class="form-control form-control-sm" required/>';
                echo '<input value="'.$_SESSION['cad_snome_colab'].'" name="edit_snome_colab" type="text" id="edit_snome_colab" maxlength="40"   class="form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';


                echo '<div class="row justify-content-center col-sm-12 col-md-12 col-lg-12 col-xl-12">';
                echo '<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                echo '<div class="input-group-prepend">';
                echo '<button type="button" id="menuBasicos" name="menuBasicos" onclick="showSection(\'tabBasicos\')" class="btn btn-outline-secondary btn-lg btn-block">Basicos</button>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                echo '<div class="input-group-prepend">';
                echo '<button type="button" id="menuComissao" name="menuComissao" onclick="showSection(\'tabComissao\')" class="btn btn-outline-secondary btn-lg btn-block">Comissão</button>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">';
                echo '<div class="input-group-prepend">';
                echo '<button type="button" id="menuAcesso" name="menuAcesso" onclick="showSection(\'tabAcesso\')" class="btn btn-outline-secondary btn-lg btn-block">Acesso</button>';
                echo '</div>';
                echo '</div>';
								echo '</div>';
                echo '<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="tabBasicos" name="tabBasicos">';
                echo '<div class="row justify-content-center col-sm-12 col-md-12 col-lg-12 col-xl-12">';
                
                //echo '<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">';
                //echo '<span class="card-title">Grupo</span>';
                //echo '<div class="input-group-prepend">';
                //echo '<select id="editgrupo_prod_serv" name="editgrupo_prod_serv" type="tel" class="input-group-text form-control form-control-lg" required>';
                //$select_show_grupo = "SELECT * FROM tb_grupo WHERE cd_grupo = '".$_SESSION['cd_grupo_prod_serv']."'";
                //$resulta_show_grupo = $conn->query($select_show_grupo);
                //if ($resulta_show_grupo->num_rows > 0){
                //  while ($row_show_grupo = $resulta_show_grupo->fetch_assoc()){
                //    echo '<option selected value="'.$row_show_grupo['cd_grupo'].'">'.$row_show_grupo['titulo_grupo'].'</option>';
                //  }
                //}
                //$select_edit_grupo = "SELECT * FROM tb_grupo WHERE cd_grupo != '".$_SESSION['cd_grupo_prod_serv']."' and cd_filial = '".$_SESSION['cd_filial']."' ORDER BY titulo_grupo ASC";
                //$resulta_edit_grupo = $conn->query($select_edit_grupo);
                //if ($resulta_edit_grupo->num_rows > 0){
                //  while ($row_edit_grupo = $resulta_edit_grupo->fetch_assoc()){
                //    echo '<option value="'.$row_edit_grupo['cd_grupo'].'">'.$row_edit_grupo['titulo_grupo'].'</option>';
                //  }
                //}
                //echo '</select>';
                //echo '</div>';
                //echo '</div>';
                
                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">CPF</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_cpf_colab'].'" name="edit_cpf_colab" type="tel" id="edit_cpf_colab" class="form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';
                
                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">Telefone</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_tel1_colab'].'" name="edit_tel1_colab" type="text" id="edit_tel1_colab" maxlength="10"   class="form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';

                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">Email</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_email_colab'].'" name="edit_email_colab" type="tel" id="edit_email_colab" class="form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';

                echo '</div>';
                echo '</div>';




                echo '<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="tabComissao" name="tabComissao" style="display:none;">';
                echo '<div class="row justify-content-center col-sm-12 col-md-12 col-lg-12 col-xl-12">';
                
                //echo '<h1 class="display-1 text-secondary">Em breve</h1>';
                
                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">Valor comissão</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_vl_comissao_colab'].'" name="edit_vl_comissao_colab" type="text" id="edit_vl_comissao_colab" maxlength="10"   class="form-control form-control-sm" />';
                echo '</div>';
                echo '</div>';

                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">% Comissão</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['cad_pc_comissao_colab'].'" name="edit_pc_comissao_colab" type="tel" id="edit_pc_comissao_colab" class="form-control form-control-sm" />';
                echo '</div>';
                echo '</div>';

                echo '</div>';
                echo '</div>';

                echo '
                <script>
document.addEventListener("DOMContentLoaded", function() {
    const vlComissao = document.getElementById("edit_vl_comissao_colab");
    const pcComissao = document.getElementById("edit_pc_comissao_colab");

    vlComissao.addEventListener("input", function() {
        if (this.value.trim() !== "" && parseFloat(this.value) > 0) {
            pcComissao.value = 0;
        }
    });

    pcComissao.addEventListener("input", function() {
        if (this.value.trim() !== "" && parseFloat(this.value) > 0) {
            vlComissao.value = 0;
        }
    });
});
</script>

                ';



                echo '<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" id="tabAcesso" name="tabAcesso" style="display:none;">';
                echo '<div class="row justify-content-center col-sm-12 col-md-12 col-lg-12 col-xl-12">';

                echo '<h1 class="display-1 text-secondary">Em breve</h1>';

                echo '</div>';
                echo '</div>';


                echo '</div>';

                echo '</div>';
                echo '</div>';

                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="gravaColab_funcao" id="gravaColab_funcao" style="margin-top: 20px; margin-bottom: 20px;">Gravar</button>';
                                
                echo '</form>';
                echo '<form method="POST">';
                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="menuPrincipal" id="menuPrincipal" style="margin-top: 20px; margin-bottom: 20px;">Sair</button>';
                echo '</form>';
              
                echo '</div>';
                echo '</div>';
                echo '</div>';
              
              }else if($_SESSION['statusCadastrosColab'] == 4){//editar grupo
                echo '<div class="col-12 grid-margin stretch-card btn-dark">';//
                echo '<div class="card" '.$_SESSION['c_card'].'>';
                echo '<div class="card-body">';

                echo '<div class="col-12 col-md-12">';
                echo '<div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">';
                echo '<h3 class="card-title">-_'.$_SESSION['statusCadastrosColab'].'_-</h3>';
                echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="POST" enctype="multipart/form-data">';
                echo '<div class="form-group row justify-content-center">';
                echo '<div class="col text-center">';
                 
                echo '</div>';
                echo '</div>';
                
                echo '<div class="input-group">';

                echo '<div class="col-sm-6 col-md-2 col-lg-2 col-xl-2">';
                echo '<span class="card-title">Código</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['editcd_grupo'].'" name="editcd_grupo" type="tel" id="editcd_grupo" class="aspNetDisabled form-control form-control-sm" style="display: block;" readonly/>';
                echo '</div>';
                echo '</div>';
                
                echo '<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">';
                echo '<span class="card-title">Código de Barras</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['edittitulo_grupo'].'" name="edittitulo_grupo" type="text"  id="edittitulo_grupo" maxlength="40" class="aspNetDisabled form-control form-control-sm" required/>';
                echo '</div>';
                echo '</div>';

                echo '<div class="col-sm-12 col-md-6 col-lg-7 col-xl-7">';
                echo '<span class="card-title">Nome / Descrição</span>';
                echo '<div class="input-group-prepend">';
                echo '<input value="'.$_SESSION['editobs_grupo'].'" name="editobs_grupo" type="text" id="editobs_grupo" maxlength="40"   class="aspNetDisabled form-control form-control-sm"/>';
                echo '</div>';
                echo '</div>';
                
                
                //echo '</div>';
                //echo '</div>';

                //echo '</div>';

                //echo '</div>';
                //echo '</div>';

                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="gravaGrupo_funcao" id="gravaGrupo_funcao" style="margin-top: 20px; margin-bottom: 20px;">Gravar</button>';
                                
                echo '</form>';
                echo '<form method="POST">';
                echo '<button type="submit" class="btn btn-block btn-lg btn-outline-warning" name="menuPrincipal" id="menuPrincipal" style="margin-top: 20px; margin-bottom: 20px;">Sair</button>';
                echo '</form>';
              
                echo '</div>';
              
              }else{
                $select_colab = "SELECT * FROM tb_pessoa where cd_filial = ".$_SESSION['cd_filial']." ORDER BY pnome_pessoa ASC";
                $resulta_colab = $conn->query($select_colab);
                if ($resulta_colab->num_rows > 0){

                  echo '<div class="col-lg-12 grid-margin stretch-card" >';
                  echo '<div class="card" '.$_SESSION['c_card'].'>';
                  echo '<div class="card-body">';
                    
                  //echo '<form method="POST">';
                  //echo '<input type="tel" id="con_cd_colab" name="con_cd_colab" value="'.$row_colab['cd_pessoa'].'" style="display:none;">';
                  //echo '<button type="submit" class="btn  btn-outline-warning" name="editColab" id="editColab" >Editar <i class="icon-open"></i></button>';
                  //echo '</form>';
                  echo '<h4 class="card-title" style="text-align: center;">Colaboradores cadastrados</h4>';
                  //echo '<h6 class="card-title" style="text-align: center;">'.$row_colab['pnome_pessoa'].' '.$row_colab['snome_pessoa'].'</h6>';
                    
                  echo '<div class="table-responsive">';
                  
                  echo '<form method="POST">';
                  //echo '<input type="hidden" name="cadColab" id="cadColab" value="'.$row_colab['cd_pessoa'].'" >';
                  echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="cadColab" id="cadColab" style="margin-top: 20px; margin-bottom: 20px;">Novo Colaborador</button>';
                  echo '</form>';


                  echo '<table class="table" '.$_SESSION['c_card'].'>';
                  echo '<thead>';
                  echo '<tr>';
                  echo '<th>CD</th>';
                  echo '<th>Nome Completo</th>';
                  echo '<th>Função</th>';
                  echo '</tr>';
                  echo '</thead>';
                  echo '<tbody>';
                  while ( $row_colab = $resulta_colab->fetch_assoc()){
                    echo '<tr>';
                    echo '<form method="POST">';
                    if($row_colab['status_pessoa'] == 0){
                      echo '<td style="display: none;"><input type="tel" id="con_cd_colab" name="con_cd_colab" value="'.$row_colab['cd_pessoa'].'"></td>';
                      echo '<td><button type="submit" class="btn btn-outline-danger" name="btn_con_colab" id="btn_con_colab">'.$row_colab['cd_pessoa'].'</button></td>';
                    }else{
                      echo '<td style="display: none;"><input type="tel" id="con_cd_colab" name="con_cd_colab" value="'.$row_colab['cd_pessoa'].'"></td>';
                      echo '<td><button type="submit" class="btn btn-outline-success" name="btn_con_colab" id="btn_con_colab">'.$row_colab['cd_pessoa'].'</button></td>';
                    }
                        
                    echo '</form>';
                    echo '<td>'.$row_colab['pnome_pessoa'].' '.$row_colab['snome_pessoa'].'</td>';
                    echo '<td>'.$row_colab['subtipo_pessoa'].'</td>';
                    //echo '<td>R$: '.$row_produtos['preco_prod_serv'].'</td>';
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
              //echo '<form method="POST">';
              //echo '<button type="submit" class="btn btn-block btn-lg btn-outline-success" name="cadGrupo" id="cadGrupo" style="margin-top: 20px; margin-bottom: 20px;">Cadastrar Colaborador</button>';
              //echo '</form>';
            










  ?>

                
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