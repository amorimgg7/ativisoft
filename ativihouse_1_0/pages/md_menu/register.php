<?php
    
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
  <title>Cadastre-se</title>
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
              <div class="brand-logo">
                <img src="../../images/logo-dark.svg" alt="logo">
              </div>
              <h4>É novo por aqui?</h4>
              <h6 class="font-weight-light">Preencha o cadastro e desfrute do nosso sistema.</h6>
              <form method="POST" class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="cad_nome" id="cad_nome" placeholder="Nome" require>
                </div>
                <div class="form-group">
                  <input type="tel" class="form-control form-control-lg" oninput="cpf(this)" name="cad_cpf" id="cad_cpf" placeholder="CPF" require>
                </div>
                <div class="form-group">
                  <label for="cad_dtnascimento">Data de nascimento</label>
                  <input type="date" class="form-control form-control-lg" name="cad_dtnascimento" id="cad_dtnascimento" require>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="cad_email" id="cad_email" placeholder="Email" require>
                </div>
                <div class="form-group">
                
                <?php
                  $sql_funcao = "SELECT * FROM tb_funcao"; 
                  $resulta = $conn->query($sql_funcao);
                  if ($resulta->num_rows > 0){
                    echo '<label class="col-xl-3 col-lg-3 col-form-label">Função</label>';
                    echo '<div class="col-lg-9 col-xl-6">';
                    echo '<select name="cad_funcao" id="cad_funcao" class="form-control">';
                    echo '<option value="">Selecione Função</option>';
                    while ( $row = $resulta->fetch_assoc()){
                      echo '<option value="'.$row['cd_funcao'].'">'.$row['titulo_funcao'].'</option>';
                    }
                    echo '</select>';
                    echo '</div>';
          }
                ?>
                </div>
                
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="cad_senha" id="cad_senha" placeholder="Senha" require>
                  <input type="password" class="form-control form-control-lg" name="cad_confsenha" id="cad_confsenha" placeholder="Confirmar Senha" require>
                </div>

<!--
                <div class="mb-4">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      I agree to all Terms & Conditions
                    </label>
                  </div>
                </div>
-->
                <div class="mt-3">
                  <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="cad_pessoal" id="cad-pessoal" value="Cadastrar">
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="login.php" class="text-primary">Login</a>
                </div>
              


<?php
              if (isset($_POST['cad_cpf']))
                          {
                            
                            $cad_nome = addslashes($_POST['cad_nome']);
                            $cad_cpf = addslashes($_POST['cad_cpf']);
                            $cad_dtnascimento = addslashes($_POST['cad_dtnascimento']);
                            $cad_email = addslashes($_POST['cad_email']);
                            $cad_funcao = addslashes($_POST['cad_funcao']);
                            $cad_senha = addslashes($_POST['cad_senha']);
                            $conf_senha = addslashes($_POST['cad_confsenha']);
                            

                            
                            
                            //$senha_pessoal = "1";
                            //$confSenha_pessoal = "1";
                            //$confSenha_pessoal = addslashes($_POST['confSenha_pessoal']);
                            //verificar se tem algum campo vazio
                            
                            if (!empty($cad_cpf))
                            //if (!empty($pnome_pessoal) && !empty($cpf_pessoal) && !empty($senha_pessoal)) 
                            {
                              $u->conectar(); 
                              if ($u-> $msgErro == "")
                              {
                                if($cad_senha == $conf_senha)
                                {
                                  //$pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal

                                  //dtentrada_pessoal, funcao_pessoal, meta_pessoal,
                                  //endereco_pessoal, foto_pessoal

                                  if($u->cadPessoal($foto_pessoal, $cad_nome, $snome_pessoal, $cad_cpf, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $cad_dtnascimento, $sexo_pessoal, $ecivil_pessoal, $obs_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $cad_email, $cad_funcao, $cad_senha)) 
                                  //if($u->cadPessoal1($pnome_pessoal, $snome_pessoal, $cpf_pessoal, $rg_pessoal, $cnh_pessoal, $carttrabalho_pessoal, $pis_pessoal, $dtnasc_pessoal, $sexo_pessoal, $tel1_pessoal, $obs_tel1_pessoal, $tel2_pessoal, $obs_tel2_pessoal, $email_pessoal, $senha_pessoal)) 
                                  {
                                    ?>
                                    <script>window.alert("Cadastro realizado com sucesso!");</script>
                                    <div id="msg-sucesso">Cadastrado com sucesso</div> 
                                    <?php
                                    echo '<script>location.href="'.$_SESSION['dominio'].'";</script>';
                                  }
                                  else
                                  {
                                   ?>
                                    <script>window.alert("Tente o login ou recuperação de senha, voce ja utiliza nossa plataforma!");</script>
                                    
                                    <?php
                                  }
                                }
                                else
                                {
                                  ?>
                                  <div class="msg-erro">Confirmação de senha não correspondem!</div>
                                  <?php
                                }
                              }
                              else
                              {
                                ?>
                                <div class="msg-erro">
                                  <?php echo "Erro: ".$u->msgErro;?>
                                </div>
                                <?php
                              }
                            }
                            else
                            {
                              ?>
                              <script>window.alert("CPF em branco!");</script>
                              <div class="msg-erro">CPF em branco!!</div>
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
