<!DOCTYPE html>
<html lang="pt-br">
<?php
  require_once '../classes/conn_revenda.php';

  session_start();
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cadastre-se</title>

  
     
  <!-- base:css -->
  <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../vendors/feather/feather.css">
  <link rel="stylesheet" href="../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/tecbg.png" />
  <script src="../js/functions.js"></script>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">

            <div class="auth-form-light text-left py-5 px-4 px-sm-5" name="primeiro_contato" id="primeiro_contato">
              <h4>Primeiro Contato</h4>
              <form class="pt-3" method="POST">
                <div class="form-outline mb-4">
                  <div class="input-group-prepend">
                    <select name="cd_pais" id="cd_pais"  class="input-group-text" required>
                      <option selected="selected"value='55'>+55 Brasil</option>
                    </select>
                    <select name="ddd_estado" id="ddd_estado" class="input-group-text" required>
                      <option selected="selected"value=''>DDD</option> 
                      <option value='11'>11</option>
                      <option value='12'>12</option>
                      <option value='13'>13</option>
                      <option value='14'>14</option>
                      <option value='15'>15</option>
                      <option value='16'>16</option>
                      <option value='17'>17</option>
                      <option value='18'>18</option>
                      <option value='19'>19</option>
                      <option value='21'>21</option>
                      <option value='22'>22</option>
                      <option value='24'>24</option>
                      <option value='27'>27</option>
                      <option value='28'>28</option>
                      <option value='31'>31</option>
                      <option value='32'>32</option>
                      <option value='33'>33</option>
                      <option value='34'>34</option>
                      <option value='35'>35</option>
                      <option value='37'>37</option>
                      <option value='38'>38</option>
                      <option value='41'>41</option>
                      <option value='42'>42</option>
                      <option value='43'>43</option>
                      <option value='44'>44</option>
                      <option value='45'>45</option>
                      <option value='46'>46</option>
                      <option value='47'>47</option>
                      <option value='48'>48</option>
                      <option value='49'>49</option>
                      <option value='51'>51</option>
                      <option value='53'>53</option>
                      <option value='54'>54</option>
                      <option value='55'>55</option>
                      <option value='61'>61</option>
                      <option value='62'>62</option>
                      <option value='63'>63</option>
                      <option value='64'>64</option>
                      <option value='65'>65</option>
                      <option value='66'>66</option>
                      <option value='67'>67</option>
                      <option value='68'>68</option>
                      <option value='69'>69</option>
                      <option value='71'>71</option>
                      <option value='73'>73</option>
                      <option value='74'>74</option>
                      <option value='75'>75</option>
                      <option value='77'>77</option>
                      <option value='79'>79</option>
                      <option value='81'>81</option>
                      <option value='82'>82</option>
                      <option value='83'>83</option>
                      <option value='84'>84</option>
                      <option value='85'>85</option>
                      <option value='86'>86</option>
                      <option value='87'>87</option>
                      <option value='88'>88</option>
                      <option value='89'>89</option>
                      <option value='91'>91</option>
                      <option value='92'>92</option>
                      <option value='93'>93</option>
                      <option value='94'>94</option>
                      <option value='95'>95</option>
                      <option value='96'>96</option>
                      <option value='97'>97</option>
                      <option value='98'>98</option>
                      <option value='99'>99</option>
                    </select>
                    <input type="tel" name="contel_cliente" id="contel_cliente" oninput="tel2(this)" class="form-control" required oninput="validateInput(this)">
                  </div>
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" id="passo_1" name="passo_1" value="Prosseguir" >
                </div>
              </form>
              
            </div>

            <div class="auth-form-light text-left py-5 px-4 px-sm-5" name="dados_pessoais" id="dados_pessoais" style="display:none;">
              <h4>Informações pessoais</h4>
              <form class="pt-3" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="pnome_cliente" maxlength="50" name="pnome_cliente" placeholder="Nome">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="snome_cliente" maxlength="50" name="snome_cliente" placeholder="Sobrenome">
                </div>
                <div class="form-outline mb-4">
                  <input type="email" class="form-control" id="email_cliente" name="email_cliente" placeholder="Digite seu E-Mail">
                </div>
                <div class="form-outline mb-4">
                  <div class="input-group-prepend">
                    <input type="tel" name="cadtel_cliente" id="cadtel_cliente" class="form-control" readonly>
                  </div>
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="passo_2" id="passo_2" type="submit" value="Prosseguir" >
                </div>
              </form>
            </div>

            <div class="auth-form-light text-left py-5 px-4 px-sm-5" name="dados_empresa" id="dados_empresa" style="display:none;">
              <h4>Dados da sua Empresa</h4>
              <form class="pt-3" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="cnpj_empresa" oninput="cnpj(this)" maxlength="50" name="cnpj_empresa" placeholder="CNPJ">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="rsocial_empresa" maxlength="50" name="rsocial_empresa" placeholder="Razão Social">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="nfantasia_empresa" maxlength="50" name="nfantasia_empresa" placeholder="Nome Fantasia">
                </div>

                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="tel_empresa" maxlength="50" name="tel_empresa">
                </div>

                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="email_empresa" maxlength="50" name="email_empresa">
                </div>

                <div class="mt-3">
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="passo_3" id="passo_3" type="submit" value="Comece agora" >
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
  

  <!-- container-scroller -->
  <!-- base:js -->
  <script src="../vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <!-- endinject -->



  <?php

    if(isset($_POST['passo_1'])){
      if (isset($_POST['cd_pais']) || isset($_POST['ddd_estado']) || strlen($_POST['contel_cliente']) === 9)
      {
        $query = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_POST['cd_pais'].$_POST['ddd_estado'].$_POST['contel_cliente']."'";
        $result = mysqli_query($conn_revenda, $query);
        $row = mysqli_fetch_assoc($result);
        // Exibe as informações do usuário no formulário
        if($row) {
          echo '<script>document.getElementById("tel_empresa").value = "'.$row['tel_cliente'].'";</script>';
          echo '<script>document.getElementById("email_empresa").value = "'.$row['email_cliente'].'";</script>';
          echo '<script>document.getElementById("dados_empresa").style.display = "block";</script>';
          echo '<script>document.getElementById("primeiro_contato").style.display = "none";</script>';
          echo '<script>document.getElementById("dados_pessoais").style.display = "none";</script>';
        }else{
          echo "<h1>Não encontrado</h1>";
          echo '<script>document.getElementById("primeiro_contato").style.display = "none";</script>';
          echo '<script>document.getElementById("cadtel_cliente").value = "'.$_POST['cd_pais'].$_POST['ddd_estado'].$_POST['contel_cliente'].'";</script>';
          echo '<script>document.getElementById("dados_pessoais").style.display = "block";</script>';
        }
      }
    }
  
    if(isset($_POST['passo_2'])){
      if (isset($_POST['pnome_cliente']) || isset($_POST['snome_cliente']) || isset($_POST['email_cliente']))
      {
        $query = "SELECT * FROM tb_cliente WHERE tel_cliente = '".$_POST['cadtel_cliente']."'";
        $result = mysqli_query($conn_revenda, $query);
        $row = mysqli_fetch_assoc($result);
        // Exibe as informações do usuário no formulário
        if($row) {
            echo '<script>document.getElementById("tel_empresa").value = "'.$row['tel_cliente'].'";</script>';
            echo '<script>document.getElementById("email_empresa").value = "'.$row['email_cliente'].'";</script>';
            echo '<script>document.getElementById("dados_pessoais").style.display = "none";</script>';
            echo '<script>document.getElementById("primeiro_contato").style.display = "none";</script>';
            echo '<script>document.getElementById("dados_empresa").style.display = "block";</script>';
        }else{
          echo '<script>document.getElementById("tel_empresa").value = "'.$_POST['cadtel_cliente'].'";</script>';
          echo '<script>document.getElementById("email_empresa").value = "'.$_POST['email_cliente'].'";</script>';
          $cadCliente = "INSERT INTO tb_cliente(pnome_cliente, snome_cliente, obs_cliente, tel_cliente, email_cliente) VALUES(
            '".$_POST['pnome_cliente']."',
            '".$_POST['pnome_cliente']."',
            'Cadastrado pelo teste gratuito',
            '".$_POST['cadtel_cliente']."',
            '".$_POST['email_cliente']."')";
          if(mysqli_query($conn_revenda, $cadCliente)){
            echo '<script>document.getElementById("dados_pessoais").style.display = "none";</script>';
            echo '<script>document.getElementById("primeiro_contato").style.display = "none";</script>';
            echo '<script>document.getElementById("dados_empresa").style.display = "block";</script>';
          }
        }
      }
    }

    if(isset($_POST['passo_3'])){
      if (isset($_POST['cnpj_empresa']) || isset($_POST['rsocial_empresa']) || isset($_POST['nfantasia_empresa']))
      {//date('Y-m-d', strtotime('-1 day')
      
        $query = "SELECT * FROM tb_cliente_comercial WHERE cnpj_cliente_comercial = '".$_POST['cnpj_empresa']."'";
        $result = mysqli_query($conn_revenda, $query);
        $row = mysqli_fetch_assoc($result);
        // Exibe as informações do usuário no formulário
        if($row) {
            echo '<script>document.getElementById("dados_pessoais").style.display = "none";</script>';
            echo '<script>document.getElementById("primeiro_contato").style.display = "block";</script>';
            echo '<script>document.getElementById("dados_empresa").style.display = "none";</script>';
            echo "<script>window.alert('CNPJ ja cadastrado. Tente outro ou aguarde o contato!');</script>";
        }else{
          $cadClienteComercial = "INSERT INTO tb_cliente_comercial(rsocial_cliente_comercial, nfantasia_cliente_comercial, cnpj_cliente_comercial, obs_cliente_comercial, tel_cliente_comercial, email_cliente_comercial, dtcadastro_cliente_comercial, dtvalidlicenca_cliente_comercial, fatura_prevista_cliente_fiscal) VALUES (
            '".$_POST['rsocial_empresa']."',
            '".$_POST['nfantasia_empresa']."',
            '".$_POST['cnpj_empresa']."',
            'Cliente ganhou 30 dias gratis',
            '".$_POST['tel_empresa']."',
            '".$_POST['email_empresa']."',
            NOW(),
            DATE_ADD(NOW(), INTERVAL 1 MONTH),
            '120.00'
        )";
        
          if(mysqli_query($conn_revenda, $cadClienteComercial)){
            echo '<script>document.getElementById("dados_pessoais").style.display = "none";</script>';
            echo '<script>document.getElementById("primeiro_contato").style.display = "none";</script>';
            echo '<script>document.getElementById("dados_empresa").style.display = "none";</script>';
            echo "<script>window.alert('Parabèns pela sua iniciativa, entraremos em contato a qualquer momento!');</script>";
            echo '<script>location.href="../../pages/dashboard/index.php";</script>';
          }else{
            echo "<script>window.alert('Erro!');</script>";
          }
        }
      }else{
        echo "<script>window.alert('Dados Incompletos!');</script>";
      }
    }
    
  ?>
</body>
</html>
