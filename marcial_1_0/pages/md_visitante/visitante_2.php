<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();
require_once '../../classes/conn.php';
require_once '../../classes/functions.php';

  
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Área do Visitante</title>

  
     
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

            <div class="auth-form-light text-center py-5 px-4 px-sm-5" name="faixa_etaria" id="faixa_etaria" style="display:none;">
              <h4>Seja Bem Vindo</h4>
              <h4>Qual a Sua Faixa Etária</h4>
              <form class="pt-3" method="POST">
                <div class="mt-3">
                  <input class="btn btn-block btn-outline-warning btn-lg" type="submit" id="menos_de_12" name="menos_de_12" value="-12" >
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-outline-success btn-lg" type="submit" id="entre_13_e_18" name="entre_13_e_18" value="De 13 a 18" >
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-outline-danger btn-lg" type="submit" id="entre_19_e_40" name="entre_19_e_40" value="De 19 a 40" >
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-outline-info btn-lg" type="submit" id="acima_de_41" name="acima_de_41" value="+41" >
                </div>
              </form> 
            </div>

            <div class="auth-form-light text-center py-5 px-4 px-sm-5" name="identidade_sexual" id="identidade_sexual" style="display:none;">
              <h4>Seja Bem Vindo</h4>
              <h4>Qual a Sua Faixa Etária</h4>
              <form class="pt-3" method="POST">
                <div class="mt-3">
                  <input class="btn btn-outline-info btn-lg" type="submit" id="Homem" name="Homem" value="Homem" >
                  <input class="btn btn-outline-danger btn-lg" type="submit" id="Mulher" name="Mulher" value="Mulher" >
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-outline-secondary btn-lg" type="submit" id="Outros" name="Outros" value="Outros" >
                </div>
              </form> 
            </div>

            <div class="auth-form-light text-center py-5 px-4 px-sm-5" name="contato_pessoa" id="contato_pessoa" style="display:none;">
              <h4>Seja Bem Vindo</h4>
              <h4>Como podemos entrar em contato com voçê?</h4>
              <form class="pt-3" method="POST">
                <div class="mt-3">
                  <input class="btn btn-outline-info btn-lg" type="submit" id="contato_telefone" name="contato_telefone" value="Telefone" >
                  <input class="btn btn-outline-warning btn-lg" type="submit" id="contato_email" name="contato_email" value="Email" >
                </div>
              </form> 
            </div>
            
            <div class="auth-form-light text-center py-5 px-4 px-sm-5" name="telefone_pessoa" id="telefone_pessoa" style="display:none;">
              <h4>Vamos Começar</h4>
              <h4>O Seu Pedido de Oração</h4>
              <form class="pt-3" method="POST">
                <div class="form-outline mb-4">
                  <div class="input-group-prepend">
                    <select name="cd_pais" id="cd_pais"  class="input-group-text" required>
                      <option selected="selected"value='55'>+55 Brasil</option>
                    </select>
                    <input type="tel" name="contel_pessoa" id="contel_pessoa" oninput="tel(this)" class="form-control" required oninput="validateInput(this)" placeholder="(00) 9 0000-0000">
                  </div>
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" id="consulta_telefone" name="consulta_telefone" value="Prosseguir" >
                </div>
              </form> 
            </div>

            <div class="auth-form-light text-center py-5 px-4 px-sm-5" name="email_pessoa" id="email_pessoa" style="display:none;">
              <h4>O Seu Pedido de Oração</h4>
              <form class="pt-3" method="POST">
                <div class="form-outline mb-4">
                  <div class="input-group-prepend">
                    <input type="email" name="conemail_pessoa" id="conemail_pessoa" class="form-control" required placeholder="exemplo@email.com.br">
                  </div>
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" id="consulta_email" name="consulta_email" value="Prosseguir" >
                </div>
              </form> 
            </div>
            
            <div class="auth-form-light text-center py-5 px-4 px-sm-5" name="dados_pessoa" id="dados_pessoa" style="display:none;">
              <h4>Informações pessoais</h4>
              <form class="pt-3" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="pnome_pessoa" maxlength="50" name="pnome_pessoa" placeholder="Nome" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="snome_pessoa" maxlength="50" name="snome_pessoa" placeholder="Sobrenome" required>
                </div>
                <div class="form-outline mb-4">
                  <div class="input-group-prepend">
                    <input type="tel" name="cadtel_pessoa" id="cadtel_pessoa" class="form-control" readonly >
                  </div>
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="passo_2" id="passo_2" type="submit" value="Prosseguir" >
                </div>
              </form>
            </div>
            
            <div class="auth-form-light text-center py-5 px-4 px-sm-5" name="pedido_auxilio" id="pedido_auxilio" style="display:none;">
              <h4>Como a Igreja Pode Te Ajudar?</h4>
              <form class="pt-3" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="full_name_pessoa" name="full_name_pessoa" style="display:none;" readonly>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="full_tel_pessoa" maxlength="50" name="full_tel_pessoa" style="display:none;" readonly>
                </div>


               
                <div class="form-group">
                  <label for="tipo_auxilio1" class="btn btn-secondary">
                    <input type="radio" name="tipo_auxilio" id="tipo_auxilio1" value="auxilio_visita"> Visita
                  </label>

                  
                  <label for="tipo_auxilio2" class="btn btn-secondary">
                    <input type="radio" name="tipo_auxilio" id="tipo_auxilio2" value="auxilio_alimento"> Alimento
                  </label>
                    
                  
                  <label for="tipo_auxilio3" class="btn btn-secondary">
                    <input type="radio" name="tipo_auxilio" id="tipo_auxilio3" value="auxilio_estudo_biblico"> Estudo Bíblico 
                  </label>
                </div>
  

                <div class="form-group">
                  <textarea style="height:300px; width:100%; word-wrap:break-word; white-space:pre-wrap; overflow-wrap:break-word; text-align:left;" class="form-control form-control-lg" id="obs_pedido_auxilio" maxlength="500" name="obs_pedido_auxilio" placeholder="Nos conte melhor a sua situação(opcional)."></textarea>

                  <!--<input type="textearea" style="height:500px;" class="form-control form-control-lg" id="obs_pedido_oração" maxlength="500" name="obs_pedido_oração" placeholder="Descreva aqui o seu pedido de oração.">
                  -->
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="ultimo_passo" id="ultimo_passo" type="submit" value="Enviar" >
                </div>
              </form>
            </div>
            
            <form method="post">
              <input type="submit" class="btn btn-block btn-outline-danger btn-lg font-weight-medium auth-form-btn" name="voltar" id="voltar" style="display:none;" value="Voltar"></input>
            </form>
            <?php echo '<a href="'.$_SESSION['dominio'].'pages/dashboard/index.php" class="btn btn-block btn-secondary btn-lg font-weight-medium auth-form-btn">Ir ao Dashboard</a>'; ?>

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

    if(isset($_POST['voltar'])) {
      //$u->loggout();
      loggout();
    }
    if(!isset($_SESSION['faixaEtaria'])){
      echo '<script>document.getElementById("faixa_etaria").style.display = "block";</script>';
    }
    if(isset($_POST['menos_de_12'])){
      $_SESSION['faixaEtaria'] = 'menos_de_12';
      echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';

      echo '<script>document.getElementById("identidade_sexual").style.display = "block";</script>';
      
      echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("pedido_auxilio").style.display = "none";</script>';
      echo '<script>document.getElementById("voltar").style.display = "block";</script>';
    }
    if(isset($_POST['entre_13_e_18'])){
      $_SESSION['faixaEtaria'] = 'entre_13_e_18';
      echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';

      echo '<script>document.getElementById("identidade_sexual").style.display = "block";</script>';
      
      echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("pedido_auxilio").style.display = "none";</script>';
      echo '<script>document.getElementById("voltar").style.display = "block";</script>';
    }
    if(isset($_POST['entre_19_e_40'])){
      $_SESSION['faixaEtaria'] = 'entre_19_e_40';
      echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';

      echo '<script>document.getElementById("identidade_sexual").style.display = "block";</script>';
      
      echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("pedido_auxilio").style.display = "none";</script>';
      echo '<script>document.getElementById("voltar").style.display = "block";</script>';
    }
    if(isset($_POST['acima_de_41'])){
      $_SESSION['faixaEtaria'] = 'acima_de_41';
      echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';

      echo '<script>document.getElementById("identidade_sexual").style.display = "block";</script>';
      
      echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("pedido_auxilio").style.display = "none";</script>';
      echo '<script>document.getElementById("voltar").style.display = "block";</script>';
    }

    if(isset($_POST['Homem'])){
      $_SESSION['identidade_sexual'] = 'Homem';
      echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
      echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
      
      echo '<script>document.getElementById("contato_pessoa").style.display = "block";</script>';

      echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("pedido_auxilio").style.display = "none";</script>';
      echo '<script>document.getElementById("voltar").style.display = "block";</script>';
    }
    if(isset($_POST['Mulher'])){
      $_SESSION['faixaEtaria'] = 'Mulher';
      echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
      echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
      
      echo '<script>document.getElementById("contato_pessoa").style.display = "block";</script>';

      echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("pedido_auxilio").style.display = "none";</script>';
      echo '<script>document.getElementById("voltar").style.display = "block";</script>';
    }
    if(isset($_POST['Outros'])){
      $_SESSION['faixaEtaria'] = 'Outros';
      echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
      echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
      
      echo '<script>document.getElementById("contato_pessoa").style.display = "block";</script>';

      echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("pedido_auxilio").style.display = "none";</script>';
      echo '<script>document.getElementById("voltar").style.display = "block";</script>';
    }

    if(isset($_POST['contato_telefone'])){
      $_SESSION['contato_pessoa'] = 'Telefone';
      echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
      echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
      echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';

      echo '<script>document.getElementById("telefone_pessoa").style.display = "block";</script>';

      echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("pedido_auxilio").style.display = "none";</script>';
      echo '<script>document.getElementById("voltar").style.display = "block";</script>';
    }
    if(isset($_POST['contato_email'])){
      $_SESSION['contato_pessoa'] = 'Email';
      echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
      echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
      echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';

      echo '<script>document.getElementById("email_pessoa").style.display = "block";</script>';
      
      echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
      echo '<script>document.getElementById("pedido_auxilio").style.display = "none";</script>';
      echo '<script>document.getElementById("voltar").style.display = "block";</script>';
    }

    if (isset($_POST['cd_pais']) && isset($_POST['contel_pessoa']))
    {
      if(strlen($_POST['contel_pessoa']) >= 10){
        $query = "SELECT * FROM tb_pessoa WHERE tel_pessoa = '".$_POST['cd_pais'].$_POST['contel_pessoa']."'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        // Exibe as informações do usuário no formulário
        if($row) {
          $_SESSION['cd_pessoa'] = $row['cd_pessoa'];
          $_SESSION['tel_pessoa'] = $row['tel_pessoa'];
          echo '<script>document.getElementById("full_name_pessoa").value = "'.$row['pnome_pessoa'].' '.$row['snome_pessoa'].'";</script>';
          echo '<script>document.getElementById("full_tel_pessoa").value = "'.$row['tel_pessoa'].'";</script>';
          
          
          echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
          echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
          echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';

          echo '<script>document.getElementById("pedido_auxilio").style.display = "block";</script>';
          
          echo '<script>document.getElementById("voltar").style.display = "block";</script>';

        }else{
          echo '<script>document.getElementById("cadtel_pessoa").value = "'.$_POST['cd_pais'].$_POST['ddd_estado'].$_POST['contel_pessoa'].'";</script>';
          echo '<script>document.getElementById("cadtel_pessoa").style.display = "block";</script>';
          echo '<script>document.getElementById("cademail_pessoa").style.display = "none";</script>';
          
          echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
          echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
          echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';

          echo '<script>document.getElementById("dados_pessoa").style.display = "block";</script>';
          
          echo '<script>document.getElementById("pedido_auxilio").style.display = "none";</script>';
          echo '<script>document.getElementById("voltar").style.display = "block";</script>';

        }
      }else{
        echo "<script>window.alert('Ops. Preencha o telefone com o DDD corretamente!');</script>";
      } 
    }

    if (isset($_POST['conemail_pessoa']))
    {
      
        $query = "SELECT * FROM tb_pessoa WHERE email_pessoa = '".$_POST['conemail_pessoa']."'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        // Exibe as informações do usuário no formulário
        if($row) {
          $_SESSION['cd_pessoa'] = $row['cd_pessoa'];
          $_SESSION['tel_pessoa'] = $row['tel_pessoa'];
          echo '<script>document.getElementById("full_name_pessoa").value = "'.$row['pnome_pessoa'].' '.$row['snome_pessoa'].'";</script>';
          echo '<script>document.getElementById("full_tel_pessoa").value = "'.$row['tel_pessoa'].'";</script>';
          
          
          echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
          echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
          echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';

          echo '<script>document.getElementById("pedido_auxilio").style.display = "block";</script>';
          
          echo '<script>document.getElementById("voltar").style.display = "block";</script>';

        }else{
          echo '<script>document.getElementById("cadtel_pessoa").value = "'.$_POST['cd_pais'].$_POST['ddd_estado'].$_POST['contel_pessoa'].'";</script>';
          echo '<script>document.getElementById("cadtel_pessoa").style.display = "block";</script>';
          echo '<script>document.getElementById("cademail_pessoa").style.display = "none";</script>';
          
          echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
          echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
          echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';

          echo '<script>document.getElementById("dados_pessoa").style.display = "block";</script>';
          
          echo '<script>document.getElementById("pedido_auxilio").style.display = "none";</script>';
          echo '<script>document.getElementById("voltar").style.display = "block";</script>';

        }
       
    }
    
  
    if(isset($_POST['cadtel_pessoa'])){
      if (isset($_POST['pnome_pessoa']) || isset($_POST['snome_pessoa']))
      {
        $query = "SELECT * FROM tb_pessoa WHERE tel_pessoa = '".$_POST['cadtel_pessoa']."'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        // Exibe as informações do usuário no formulário
        if($row) {
          $_SESSION['cd_pessoa'] = $row['cd_pessoa'];
          $_SESSION['tel_pessoa'] = $row['tel_pessoa'];
          echo '<script>document.getElementById("full_name_pessoa").value = "'.$row['pnome_pessoa'].' '.$row['snome_pessoa'].'";</script>';
          echo '<script>document.getElementById("full_email_pessoa").value = "";</script>';
          echo '<script>document.getElementById("full_tel_pessoa").value = "'.$row['tel_pessoa'].'";</script>';
          
          echo '<script>document.getElementById("full_tel_pessoa").style.display = "block";</script>';
          echo '<script>document.getElementById("full_email_pessoa").style.display = "none";</script>';
          
          echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
          echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
          echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';

          echo '<script>document.getElementById("pedido_auxilio").style.display = "block";</script>';
          
          echo '<script>document.getElementById("voltar").style.display = "block";</script>';
        }else{
          $cadPessoa = "INSERT INTO tb_pessoa (pnome_pessoa, snome_pessoa, tel_pessoa, dt_cad_pessoa) VALUES (
            '".mysqli_real_escape_string($conn, $_POST['pnome_pessoa'])."',
            '".mysqli_real_escape_string($conn, $_POST['snome_pessoa'])."',
            '".mysqli_real_escape_string($conn, $_POST['cadtel_pessoa'])."',
            NOW()
          )";

          if (mysqli_query($conn, $cadPessoa)) {
            $query = "SELECT * FROM tb_pessoa WHERE tel_pessoa = '".$_POST['cadtel_pessoa']."'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            // Exibe as informações do usuário no formulário
            if($row) {
              $_SESSION['cd_pessoa'] = $row['cd_pessoa'];
              $_SESSION['tel_pessoa'] = $row['tel_pessoa'];
              echo '<script>document.getElementById("full_name_pessoa").value = "'.$row['pnome_pessoa'].' '.$row['snome_pessoa'].'";</script>';
              echo '<script>document.getElementById("full_tel_pessoa").value = "'.$row['tel_pessoa'].'";</script>';
              
              
              echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
              echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
              echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
              echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
              echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
              echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';

              echo '<script>document.getElementById("pedido_auxilio").style.display = "block";</script>';
              
              echo '<script>document.getElementById("voltar").style.display = "block";</script>';
            }
            echo "<script>window.alert('Acabou de ser cadastrado!');</script>";
          } else {
            echo "<script>window.alert('Erro ao cadastrar: " . mysqli_error($conn) . "');</script>";
          }
        }
      }
    }

    if(isset($_POST['cademail_pessoa'])){
      if (isset($_POST['pnome_pessoa']) || isset($_POST['snome_pessoa']))
      {
        $query = "SELECT * FROM tb_pessoa WHERE email_pessoa = '".$_POST['cademail_pessoa']."'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        // Exibe as informações do usuário no formulário
        if($row) {
          $_SESSION['cd_pessoa'] = $row['cd_pessoa'];
          $_SESSION['email_pessoa'] = $row['email_pessoa'];
          echo '<script>document.getElementById("full_name_pessoa").value = "'.$row['pnome_pessoa'].' '.$row['snome_pessoa'].'";</script>';
          echo '<script>document.getElementById("full_email_pessoa").value = "'.$row['email_pessoa'].'";</script>';
          echo '<script>document.getElementById("full_tel_pessoa").value = "";</script>';
          
          echo '<script>document.getElementById("full_tel_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("full_email_pessoa").style.display = "block";</script>';
          
          
          echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
          echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
          echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
          echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';

          echo '<script>document.getElementById("pedido_auxilio").style.display = "block";</script>';
          
          echo '<script>document.getElementById("voltar").style.display = "block";</script>';
        }else{
          $cadPessoa = "INSERT INTO tb_pessoa (pnome_pessoa, snome_pessoa, email_pessoa, dt_cad_pessoa) VALUES (
            '".mysqli_real_escape_string($conn, $_POST['pnome_pessoa'])."',
            '".mysqli_real_escape_string($conn, $_POST['snome_pessoa'])."',
            '".mysqli_real_escape_string($conn, $_POST['cademail_pessoa'])."',
            NOW()
          )";

          if (mysqli_query($conn, $cadPessoa)) {
            $query = "SELECT * FROM tb_pessoa WHERE email_pessoa = '".$_POST['cademail_pessoa']."'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            // Exibe as informações do usuário no formulário
            if($row) {
              $_SESSION['cd_pessoa'] = $row['cd_pessoa'];
              $_SESSION['email_pessoa'] = $row['email_pessoa'];
              echo '<script>document.getElementById("full_name_pessoa").value = "'.$row['pnome_pessoa'].' '.$row['snome_pessoa'].'";</script>';
              echo '<script>document.getElementById("full_tel_pessoa").value = "'.$row['tel_pessoa'].'";</script>';
              
              
              echo '<script>document.getElementById("faixa_etaria").style.display = "none";</script>';
              echo '<script>document.getElementById("identidade_sexual").style.display = "none";</script>';
              echo '<script>document.getElementById("contato_pessoa").style.display = "none";</script>';
              echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
              echo '<script>document.getElementById("email_pessoa").style.display = "none";</script>';
              echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';

              echo '<script>document.getElementById("pedido_auxilio").style.display = "block";</script>';
              
              echo '<script>document.getElementById("voltar").style.display = "block";</script>';
            }
            echo "<script>window.alert('Acabou de ser cadastrado!');</script>";
          } else {
            echo "<script>window.alert('Erro ao cadastrar: " . mysqli_error($conn) . "');</script>";
          }
        }
      }
    }

    if(isset($_POST['passo_3'])){
      if (isset($_POST['obs_pedido_oracao']))
      {//date('Y-m-d', strtotime('-1 day')
      
        ////$query = "SELECT * FROM tb_pedido_oracao";
        //$query = "SELECT * FROM tb_pedido_oracao WHERE dt_primeira_abertura_pedido_oracao is null";
        ////$result = mysqli_query($conn, $query);
        ////$row = mysqli_fetch_assoc($result);
        // Exibe as informações do usuário no formulário
        ////if($row) {
          ////echo "<script>window.alert('Pessoa com pedido de oração em aberto ainda!');</script>";
          //echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
          //echo '<script>document.getElementById("primeiro_contato").style.display = "block";</script>';
          //echo '<script>document.getElementById("dados_empresa").style.display = "none";</script>';
          //echo "<script>window.alert('CNPJ ja cadastrado. Tente outro ou aguarde o contato!');</script>";
        ////}else{
          $cadClienteComercial = "INSERT INTO tb_pedido_oracao(cd_pessoa, tel_pedido_oracao, dt_pedido_oracao, obs_pedido_oracao) VALUES (
            '".$_SESSION['cd_pessoa']."',
            '".$_SESSION['tel_pessoa']."',
            NOW(),
            '".$_POST['obs_pedido_oracao']."'
        )";
        
          if(mysqli_query($conn, $cadClienteComercial)){
            echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
            echo '<script>document.getElementById("primeiro_contato").style.display = "block";</script>';
            echo '<script>document.getElementById("dados_pedido_oracao").style.display = "none";</script>';
            echo "<script>window.alert('Parabèns pela sua iniciativa, estamos em oração por voce e pela sua vida!');</script>";
            //echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';
          }else{
            echo "<script>window.alert('Erro!');</script>";
          }
        ////}
      }else{
        echo "<script>window.alert('Dados Incompletos!');</script>";
      }
    }
    
  ?>
</body>
</html>
