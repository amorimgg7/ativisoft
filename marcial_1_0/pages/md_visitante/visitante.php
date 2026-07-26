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
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0" style="background-color:#36433c;">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="user-image">     
              <img style="width:300px; height:150px;" src="https://lh3.googleusercontent.com/pw/AP1GczMjvhfvluzXdD21t7UwOUSUxe0SfX86H7DSeUN44kmDwPFyBD72ogTu_ClQNdE2GS8RmzWQImKTD4CFidRWWwjDYJ8DPng84tbZwsjUTyQuUEFwLYb5gdCU0qrsiQeutT0ejtXdeyEYNOWIsOBb0fSL5Q=w1563-h879-s-no-gm?authuser=0">
            </div> 
            <div class="auth-form-light text-center py-5 px-4 px-sm-5" name="entrada_saida" id="entrada_saida" style="display:block; background-color:#424d47; color:#fff;">
              <h4>Escolha o tipo do formulário</h4>
              <form class="pt-3" method="POST">
                <div class="mt-3">
                  <input class="btn btn-info btn-lg" type="submit" id="formulario_entrada" name="formulario_entrada" value="Entrada" >
                  <input class="btn  btn-info btn-lg" type="submit" id="formulario_entrada" name="formulario_saida" value="Saída" >
                </div>
              </form> 
            </div>
            
            <form method="post">
              <input type="submit" class="btn btn-block btn-outline-danger btn-lg font-weight-medium auth-form-btn" name="voltar" id="voltar" style="display:none;" value="Voltar"></input>
            </form>
            <?php echo '<a href="'.$_SESSION['dominio'].'pages/dashboard/index.php" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">Ir ao Dashboard</a>'; ?>

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

    if(isset($_POST['formulario_entrada'])){
      echo '<script>location.href="'.$_SESSION['dominio'].'/pages/md_visitante/visitante_entrada.php";</script>';
    }
    if(isset($_POST['formulario_saida'])){
      echo '<script>location.href="'.$_SESSION['dominio'].'/pages/md_visitante/visitante_saida.php";</script>';
    }
    
  ?>
</body>
</html>
