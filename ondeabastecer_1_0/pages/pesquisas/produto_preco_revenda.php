<?php
session_start();

function getParameterByName($name, $url = null) {
    if ($url === null) {
        $url = $_SERVER['REQUEST_URI'];
    }

    $name = preg_quote($name);
    if (preg_match("/[?&]$name=([^&]+)/", $url, $matches)) {
        return urldecode($matches[1]);
    } else {
        return null;
    }
}

$resposta = getParameterByName('resposta');
$revenda = getParameterByName('revenda');
$produto = getParameterByName('produto');
$preco = getParameterByName('preco');

if ($resposta && $revenda && $produto && $preco) {
    $_SESSION['resposta'] = $resposta;
    $_SESSION['cnpj_empresa'] = $revenda;
    $_SESSION['produto'] = $produto;
    $_SESSION['preco'] = $preco;

    // Redirecionar ou tratar os dados como necessário
    // header('Location: proxima_pagina.php');
    // exit;
} else {
    // Tratar ausência de parâmetros
    // echo "Parâmetros faltando na URL.";
}

echo '<h3>'.$_SESSION['resposta'].'</h3>';
echo '<h3>'.$_SESSION['cnpj_empresa'].'</h3>';
echo '<h3>'.$_SESSION['produto'].'</h3>';
echo '<h3>'.$_SESSION['preco'].'</h3>';

    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    $u = new Usuario;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pesquisa Rápida</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <script src="../../js/functions.js"></script>

</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              
              <h4>Responda este formulário</h4>
              <h6 class="font-weight-light">Ajude os outros usuários a ter uma informação atualizada.</h6>
              <form method="POST" class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="id_google" id="id_google" placeholder="google" style="display:block;">
                  <input type="text" class="form-control form-control-lg" name="cad_nome" id="resposta" placeholder="Resposta Recebida" require>
                </div>
                
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="cnpj_revenda" id="cnpj_revenda" <?php echo 'value="'.$_SESSION['cnpj_empresa'].'"';?> placeholder="CNPJ" require>
                </div>

                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="produto_revenda" id="produto_revenda" <?php echo 'value="'.$_SESSION['produto'].'"';?> placeholder="Produto" require>
                </div>

                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="preco_revenda" id="preco_revenda" placeholder="Preço /l" require>
                </div>

                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="preco_revenda" id="preco_revenda" placeholder="Quantidade comprada" require>
                </div>

                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="preco_revenda" id="preco_revenda" placeholder="Valor total pago" require>
                </div>


                <div class="mt-3">
                  <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="cad_pessoal" id="cad-pessoal" value="Cadastrar">
                </div>
                
              


<?php
              if (isset($_POST['cad_email']))
              {
                include_once("../../classes/functions.php");
                $u = new Usuario;
                $cad_nome = addslashes($_POST['cad_nome']);
                $cad_tel = addslashes($_POST['cd_pais'].$_POST['cad_tel']);
                $cad_email = addslashes($_POST['cad_email']);
                $id_google = addslashes($_POST['id_google']);
                            
                if (!empty($cad_email))
                //if (!empty($pnome_pessoal) && !empty($cpf_pessoal) && !empty($senha_pessoal)) 
                {
                  $u->conectar(); 
                  if($u->cadPessoa(
                    $cad_nome,
                    $cad_email,
                    $cad_tel, 
                    $id_google)) 
                    //if($u->cadPessoal1($pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal)) 
                    {
                        echo '<script>location.href="'.$_SESSION['dominio'].'index2.php";</script>';
                    }
                    else
                    {
                      ?>
                        <script>window.alert("Tente o login ou recuperação de senha, voce ja utiliza nossa plataforma!");</script>
                        
                      <?php

                      echo '<script>location.href="'.$_SESSION['dominio'].'/index2.php";</script>';
                    }
                  }
                  else
                  {
                    ?>
                      <div class="msg-erro">Confirmação de senha não correspondem!</div>
                    <?php
                  }
                }
              ?>
</form>

            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
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
</body>

</html>

