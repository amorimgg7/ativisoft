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
  <title>Entrada</title>

  
     
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
  <style>
        #contel_pessoa::placeholder {
            color: #fff; /* Defina a cor desejada aqui */
        }
        #pnome_pessoa::placeholder {
            color: #fff; /* Defina a cor desejada aqui */
        }
        #cadtel_pessoa::placeholder {
            color: #fff; /* Defina a cor desejada aqui */
        }
    </style>
</head>

<body>
  <div class="container-scroller">


  


    <div class="container-fluid page-body-wrapper full-page-wrapper" >
    
      <div class="content-wrapper d-flex align-items-center auth px-0" style="background-color:#36433c;"><!--style="background-color:#424d47;"-->
      
      <div class="row w-100 mx-0">
       
          <div class="col-lg-4 mx-auto">
            <div class="user-image">     
              <img style="width:300px; height:150px;" src="https://lh3.googleusercontent.com/pw/AP1GczMjvhfvluzXdD21t7UwOUSUxe0SfX86H7DSeUN44kmDwPFyBD72ogTu_ClQNdE2GS8RmzWQImKTD4CFidRWWwjDYJ8DPng84tbZwsjUTyQuUEFwLYb5gdCU0qrsiQeutT0ejtXdeyEYNOWIsOBb0fSL5Q=w1563-h879-s-no-gm?authuser=0">
            </div> 

            <div class="auth-form-light text-center py-5 px-4 px-sm-5" name="telefone_pessoa" id="telefone_pessoa" style="display:none; background-color:#424d47; color:#fff;">
              <h4>Seja Bem Vindo</h4>
              <h4>Informe o Seu Telefone</h4>
              <form class="pt-3" method="POST">
                <div class="form-outline mb-4">
                  <div class="input-group-prepend">
                    <select name="cd_pais" id="cd_pais"  class="input-group-text" style="background-color:#4473c5; color:#fff;" required>
                      <option selected="selected"value='55'>+55 Brasil</option>
                    </select>
                    <input type="tel" name="contel_pessoa" id="contel_pessoa" oninput="tel(this)" class="form-control" style="background-color:#4473c5; color:#fff;" required oninput="validateInput(this)" placeholder="(00) 9 0000-0000">
                  </div>
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" type="submit" id="consulta_telefone" name="consulta_telefone" value="Prosseguir" >
                </div>
              </form> 
            </div>

            <div class="auth-form-light text-center py-5 px-4 px-sm-5" name="dados_pessoa" id="dados_pessoa" style="display:none; background-color:#424d47; color:#fff;">
              <h4>Informações pessoais</h4>
              <form class="pt-3" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="pnome_pessoa" maxlength="50" name="pnome_pessoa" placeholder="Nome" style="background-color:#4473c5; color:#fff;" required>
                </div>
                <div class="form-outline mb-4">
                  <div class="input-group-prepend">
                    <input type="tel" name="cadtel_pessoa" id="cadtel_pessoa" class="form-control" readonly style="background-color:#4473c5; color:#fff;">
                  </div>
                </div>
                <div class="mt-3">
                  <input class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="passo_2" id="passo_2" type="submit" value="Prosseguir" >
                </div>
              </form>
            </div>
            
            <div class="auth-form-light text-center py-5 px-4 px-sm-5" name="saldacao_entrada" id="saldacao_entrada" style="display:none; background-color:#424d47; color:#fff;">
              <h5>Estamos Muito Felizes Com a Sua Presença.</h5>
              <h5>Entre e Vamos Adorar o Criador.</h5>
              <h5 id="full_name_visitante"></h5>
            </div>

            
            <form method="post">
              <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" name="voltar" id="voltar" style="display:none;" value="Voltar"></input>
            </form>
            <?php //echo '<a href="'.$_SESSION['dominio'].'pages/dashboard/index.php" class="btn btn-block btn-outline-info btn-lg font-weight-medium auth-form-btn">Ir ao Dashboard</a>'; ?>

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
      session_start();
    
      session_destroy();
      echo '<script>location.href="'.$_SESSION['dominio'].'pages/md_visitante/visitante_entrada.php";</script>';
      echo "<script>window.close();</script>";
    }
    if(!isset($_SESSION['full_name_visitante'])){
      echo '<script>document.getElementById("telefone_pessoa").style.display = "block";</script>';
    }
    

    if (isset($_POST['cd_pais']) && isset($_POST['contel_pessoa']))
    {
      if(strlen($_POST['contel_pessoa']) >= 10){
        $query = "SELECT concat(pnome_pessoa, ' ', snome_pessoa) as full_name, cd_pessoa, tel_pessoa FROM tb_pessoa WHERE tel_pessoa = '".$_POST['cd_pais'].$_POST['contel_pessoa']."'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        // Exibe as informações do usuário no formulário
        if($row) {
          $_SESSION['cd_pessoa'] = $row['cd_pessoa'];
          $_SESSION['tel_pessoa'] = $row['tel_pessoa'];


          $query2 = "SELECT * FROM tb_visita WHERE DATE(dt_visita_entrada) = CURDATE() and cd_pessoa = ".$_SESSION['cd_pessoa']."";
          $result2 = mysqli_query($conn, $query2);
          $row2 = mysqli_fetch_assoc($result2);
          // Exibe as informações do usuário no formulário
          if($row2) {
            echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
            echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
            echo '<script>document.getElementById("saldacao_entrada").style.display = "block";</script>';
            echo '<script>document.getElementById("voltar").style.display = "block";</script>';
            //echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';
            echo "<script>window.alert('Visitante ja deu entrada hoje!');</script>";
          }else{
            $cadVisita = "INSERT INTO tb_visita(cd_pessoa, tel_visita, dt_visita_entrada, obs_visita) VALUES (
              '".$_SESSION['cd_pessoa']."',
              '".$_SESSION['tel_pessoa']."',
              NOW(),
              'Deu entrada mas não saiu ainda.'
            )";
            if(mysqli_query($conn, $cadVisita)){

              echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
              echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
              echo '<script>document.getElementById("saldacao_entrada").style.display = "block";</script>';
              echo '<script>document.getElementById("voltar").style.display = "block";</script>';
              //echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';
              echo "<script>window.alert('Sucesso!');</script>";
            }
          }

          echo '<script>document.getElementById("full_name_visitante").innerHTML = "Sinta-se Bem Vindo <b>'.$row['full_name'].'</b>.";</script>';

          //$_SESSION['full_name_visitante'] = $row['full_name'];
          

        }else{
          echo '<script>document.getElementById("cadtel_pessoa").value = "'.$_POST['cd_pais'].$_POST['ddd_estado'].$_POST['contel_pessoa'].'";</script>';
          echo '<script>document.getElementById("cadtel_pessoa").style.display = "block";</script>';
          
          echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';

          echo '<script>document.getElementById("dados_pessoa").style.display = "block";</script>';
          
          echo '<script>document.getElementById("saldacao_entrada").style.display = "none";</script>';
          echo '<script>document.getElementById("voltar").style.display = "block";</script>';

        }
      }else{
        echo "<script>window.alert('Ops. Preencha o telefone com o DDD corretamente!');</script>";
      } 
    }

    if(isset($_POST['cadtel_pessoa'])){
      if (isset($_POST['pnome_pessoa']))
      {
        $query = "SELECT * FROM tb_pessoa WHERE tel_pessoa = '".$_POST['cadtel_pessoa']."'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        // Exibe as informações do usuário no formulário
        if($row) {
          $_SESSION['cd_pessoa'] = $row['cd_pessoa'];
          $_SESSION['tel_pessoa'] = $row['tel_pessoa'];




          $query2 = "SELECT * FROM tb_visita WHERE DATE(dt_visita_entrada) = CURDATE() and cd_pessoa = ".$_SESSION['cd_pessoa']."";
          $result2 = mysqli_query($conn, $query2);
          $row2 = mysqli_fetch_assoc($result2);
          // Exibe as informações do usuário no formulário
          if($row2) {
            echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
            echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
            echo '<script>document.getElementById("saldacao_entrada").style.display = "block";</script>';
            echo '<script>document.getElementById("voltar").style.display = "block";</script>';
            //echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';
            echo "<script>window.alert('Visitante ja deu entrada hoje!');</script>";
          }else{
            $cadVisita = "INSERT INTO tb_visita(cd_pessoa, tel_visita, dt_visita_entrada, obs_visita) VALUES (
              '".$_SESSION['cd_pessoa']."',
              '".$_SESSION['tel_pessoa']."',
              NOW(),
              'Deu entrada mas não saiu ainda.'
            )";
            if(mysqli_query($conn, $cadVisita)){

              echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
              echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
              echo '<script>document.getElementById("saldacao_entrada").style.display = "block";</script>';
              echo '<script>document.getElementById("voltar").style.display = "block";</script>';
              //echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';
              //echo "<script>window.alert('Sucesso!');</script>";
            }
          }
        }else{
          $cadPessoa = "INSERT INTO tb_pessoa (pnome_pessoa, tel_pessoa, dt_cad_pessoa) VALUES (
            '".mysqli_real_escape_string($conn, $_POST['pnome_pessoa'])."',
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
              $query2 = "SELECT * FROM tb_visita WHERE DATE(dt_visita_entrada) = CURDATE() and cd_pessoa = ".$_SESSION['cd_pessoa']."";
              $result2 = mysqli_query($conn, $query2);
              $row2 = mysqli_fetch_assoc($result2);
              // Exibe as informações do usuário no formulário
              if($row2) {
                echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
                echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
                echo '<script>document.getElementById("saldacao_entrada").style.display = "block";</script>';
                echo '<script>document.getElementById("voltar").style.display = "block";</script>';
                //echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';
                echo "<script>window.alert('Visitante ja deu entrada hoje!');</script>";
              }else{
                $cadVisita = "INSERT INTO tb_visita(cd_pessoa, tel_visita, dt_visita_entrada, obs_visita) VALUES (
                  '".$_SESSION['cd_pessoa']."',
                  '".$_SESSION['tel_pessoa']."',
                  NOW(),
                  'Deu entrada mas não saiu ainda.'
                )";
                if(mysqli_query($conn, $cadVisita)){

                  echo '<script>document.getElementById("telefone_pessoa").style.display = "none";</script>';
                  echo '<script>document.getElementById("dados_pessoa").style.display = "none";</script>';
                  echo '<script>document.getElementById("saldacao_entrada").style.display = "block";</script>';
                  echo '<script>document.getElementById("voltar").style.display = "block";</script>';
                  //echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';
                  //echo "<script>window.alert('Sucesso2!');</script>";
                }
              }
            }
            //echo "<script>window.alert('Acabou de ser cadastrado!');</script>";
          } else {
            echo "<script>window.alert('Erro ao cadastrar pessoa: " . mysqli_error($conn) . "');</script>";
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
