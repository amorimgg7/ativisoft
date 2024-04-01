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




$_SESSION['senha_pessoal'] = 0;
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Lock Screen</title>
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
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth lock-full-bg">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-transparent text-left p-5 text-center">
              <img src="<?php echo $_SESSION['foto_pessoal']; ?>" class="lock-profile-img" alt="img">
              <form method="POST" class="pt-5">
                <div class="form-group">
                  <label for="email_colab"><p style="color:#fff;">Nome: <?php echo $_SESSION['pnome_colab'].' '.$_SESSION['snome_colab'];?></p></label>
                  <input type="text" class="form-control text-center" name="email_colab" id="email_colab" value="<?php echo $_SESSION['email_colab'];?>" style="display: block; color:#FFFFFF;" readonly>
                  <input type="password" class="form-control text-center" name="senha_colab" id="senha_colab" placeholder="Senha" autocomplete="on" style="color:#FFFFFF;">
                </div>
                <div class="mt-5">
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" value="ACESSAR" style="color:#FFFFFF; " >
                </div>
                <div class="mt-3 text-center">
                  <a href="login.php" class="auth-link text-white">Sair</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <?php
                if (isset($_POST['senha_colab']))
                {
                  $email_colab = addslashes($_POST['email_colab']);
                  $senha_colab = addslashes($_POST['senha_colab']);
                  if (!empty($email_colab) && !empty($senha_colab)) 
                  {
                    $u->conectar();
                    if ($u-> $msgErro == "")
                    {
                      if($u->logar($_SESSION['cnpj_empresa'], $email_colab,$senha_colab))  
                      {
                        echo "<script>window.alert('Senha correta!');</script>";
                        ?>
                          <div class="msg-sucesso">Entrando</div>
                        <?php
                        //header("location: AreaPrivada.php");
                        //echo '<script>location.href="AreaPrivada.php";</script>';
                      }
                      else
                      {
                        echo "<script>window.alert('Senha errada!');</script>";
                        ?>
                          <div class="msg-erro">Senha Errada!</div>
                        <?php
                        //echo "<script>setTimeout('location.href = 'login.php';', 5);</script>";
                        //echo '<script>location.href="cadastros/cadPessoal.php";</script>';
                        //include ("../../pages/samples/login.php");

                        header("location: ../../pages/samples/login.php");
                        //exit;
                      }
                    }
                    else
                    {
                      ?>
                        <div class="msg-erro"><?php echo "Erro: ".$u->msgErro;?></div>
                      <?php
                      echo "<script>window.alert('Erro: '".$u->msgErro.");</script>";
                    }
                  }
                  else
                  {
                    ?>
                      <div class="msg-erro"><?php echo "preencha todos os campos!"?></div>

                    <?php
                    echo "<script>window.alert('Preencha todos os campos!');</script>";
                  }
                }
                else
                {
                  //echo "<script>window.alert('Preencha todos os campos!');</script>";
                }
              ?>
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
