<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>

  
     
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
  <link rel="shortcut icon" href="../../images/tecbg.png" />
  <script src="../../js/functions.js"></script>
</head>


<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
            <!--
                <div class="brand-logo">
                <img src="../../images/logo-dark.svg" alt="logo">
              </div>
            -->
              <?php
                header('Content-Type: text/html; charset=UTF-8');

                require_once '../../classes/conn_revenda.php';
                /*
                  SELECT * FROM tb_frases 
                  WHERE (data_inicio_frase <= CURDATE() AND data_fim_frase >= CURDATE())  
                  AND (dia_inicio <= DAYOFMONTH(NOW()) AND dia_fim >= DAYOFMONTH(NOW())) 
                */
                $select_frase = "SELECT * FROM tb_frases WHERE (data_inicio_frase <= CURDATE() AND data_fim_frase >= CURDATE()) AND (dia_inicio <= DAYOFMONTH(NOW()) AND dia_fim >= DAYOFMONTH(NOW())) order by prioridade_frase DESC";  
                $result_frase = mysqli_query($conn_revenda, $select_frase);
                $row_frase = mysqli_fetch_assoc($result_frase);
                if($row_frase) {
                  //echo '<h4>"'. utf8_encode($row_frase['texto_frase']) .'"</h4>';

                  //echo '<h4>"'. htmlspecialchars($row_frase['texto_frase'], ENT_QUOTES, 'UTF-8') .'"</h4>';

                  echo '<h4>"'.htmlspecialchars($row_frase['texto_frase']).'"</h4>';

                  //echo '<h4>"'.$row_frase['texto_frase'].'"</h4>';
                  echo '<h6 class="font-weight-light">'.htmlspecialchars($row_frase['autor_frase'], ENT_QUOTES, 'UTF-8') .' ('.htmlspecialchars($row_frase['vida_autor'], ENT_QUOTES, 'UTF-8') .')</h6>';               
                }
              ?>
              <form class="pt-3" method="POST">
                
                <div class="form-group">
                  <input type="tel" class="form-control form-control-lg" id="cnpj_empresa" maxlength="14" name="cnpj_empresa" placeholder="Digite seu CNPJ" required>
                </div>
                <div class="form-outline mb-4">
                  <input type="email" class="form-control" id="email_colab" name="email_colab" placeholder="Digite seu E-Mail">
                </div>
                <div class="form-outline mb-4">
                  <input type="password" class="form-control" id="senha_colab" name="senha_colab" placeholder="Senha">
                </div>

                <div class="mt-3">
                  
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" onclick="submitForm()" value="ACESSAR" >

                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" id="rememberMe" name="rememberMe" class="form-check-input">
                      Lembrar
                    </label>
                  </div>
                  <!--<a href="#" class="auth-link text-black">Forgot password?</a>-->
                </div>
                <!--
                <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="mdi mdi-facebook mr-2"></i> Connect using facebook
                  </button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Cadastre-se <a href="register.php" class="text-primary">Aqui</a>
                </div>-->
              </form>


              <?php
                if (isset($_POST['cnpj_empresa']))
                {
                  require_once '../../classes/functions.php';
                  $u = new Usuario;
                  
                  $cnpj_empresa = addslashes($_POST['cnpj_empresa']);
                  $_SESSION['cnpj_empresa'] = $cnpj_empresa;
                  $email_colab = addslashes($_POST['email_colab']);
                  $senha_colab = addslashes($_POST['senha_colab']);
                  if (!empty($email_colab) && !empty($senha_colab)) 
                  {
                    
                    ?>
                    <?php
                    //include("../../partials/load.html");
                    //echo "<script>window.alert('carregando');</script>";
                    $u->conectar();
                    if ($msgErro == "")
                    {
                      include("../../partials/load.html");
                      //echo "<script>window.alert('Sem erro');</script>";
                      if($u->logar($cnpj_empresa, $email_colab, $senha_colab))  
                      {

                        
                        ?>
                        <script>window.alert("Entrando");</script>
                          <div class="msg-sucesso">Entrando</div>
                        <?php
                        //header("location: AreaPrivada.php");
                        //echo '<script>location.href="AreaPrivada.php";</script>';
                      }
                      else
                      {
                        ?>
                          <div class="msg-erro">CPF ou senha incorretos!</div>
                        <?php
                        //echo "<script>alert('Login errado!'); setTimeout(function() { window.location.reload(); }, 3000);</script>";
                        //echo "<script>alert('Login errado!'); setTimeout(function() { window.history.back(); }, 3000);</script>";
                        echo "<script>setTimeout(function() { window.history.back(); }, 3000);</script>";
                        //echo "<script>window.alert('Login errado!');</script>";
                        //echo "<script>setTimeout('location.href = 'cadastros/cadPessoal.php';', 5);</script>";
                        //echo '<script>location.href="cadastros/cadPessoal.php";</script>';
                        //include ("../../pages/samples/login.php");
                        //header('Location: ' . $_SERVER['PHP_SELF']);
                        //exit;
                        
                      }
                    }
                    else
                    {
                      ?>
                        <div class="msg-erro"><?php echo "Erro: ".$msgErro;?></div>
                      <?php
                    }
                  }
                  else
                  {
                    ?>
                      <div class="msg-erro"><?php echo "preencha todos os campos!"?></div>
                    <?php
                  }
                }
              ?>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <script>
function submitForm() {
  var cnpj = document.getElementById("cnpj_empresa").value;
  var email = document.getElementById("email_colab").value;
  var password = document.getElementById("senha_colab").value;
  var rememberMe = document.getElementById("rememberMe").checked;
  
  if (rememberMe) {
    localStorage.setItem("cnpj_empresa", cnpj);
    localStorage.setItem("email_colab", email);
    localStorage.setItem("senha_colab", password);
  } else {
    localStorage.removeItem("cnpj_empresa");
    localStorage.removeItem("email_colab");
    localStorage.removeItem("senha_colab");
  }
  
  // código para verificar o nome de usuário e a senha aqui
  
  // redirecionar o usuário para a página de destino após o login bem-sucedido
}

// preencher os campos do formulário com as informações salvas, se houver
window.onload = function() {
  var savedCnpj = localStorage.getItem("cnpj_empresa");
  var savedEmail = localStorage.getItem("email_colab");
  var savedPassword = localStorage.getItem("senha_colab");
  
  // Verificar se os campos salvos existem antes de atribuir os valores a eles
  if (savedCnpj && savedEmail && savedPassword) {
    document.getElementById("cnpj_empresa").value = savedCnpj;
    document.getElementById("email_colab").value = savedEmail;
    document.getElementById("senha_colab").value = savedPassword;
    document.getElementById("rememberMe").checked = true;
  }
}
</script>

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
