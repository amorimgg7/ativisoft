<?php 
    session_start(); 
    if(!isset($_SESSION['cd_pessoal']))
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
  <title>Geral Patrimonios</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo $_SESSION['logo_empresa']; ?>" />
</head>

<body onmousemove="resetTimer()" onclick="resetTimer()" onkeypress="resetTimer()">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include ("../../partials/_navbar.php");?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include ("../../partials/_sidebar.php");?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="card-body">
              <h4 class="card-title">Consulta de Patrimõnio</h4>
              <p class="card-description">Procure pela ordem de Marca Modelo e versão</p>
              <div class="kt-portlet__body">
                <div class="row">
                  <div class="col-12 col-md-12">
                    <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
                    
                


                <form method="POST">
                  <h3 class="kt-portlet__head-title">Dados do equipamento</h3> 
                  <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                    <label for="tipo_patrimonio">Tipo</label>
                    <select name="tipo_patrimonio" id="tipo_patrimonio"  class="aspNetDisabled form-control form-control-sm" placeholder="Estado Civil">
                      <option selected="selected" value=""></option>
                      <option value="DP">Desktop</option>
                      <option value="NK">Notebook</option>
                      <option value="MR">Monitor</option>
                      <option value="IA">Impressora</option>
                      <option value="SE">Smartphone</option>
                    </select>
                                      
                    <?php include("../../classes/conn.php");
                      if(isset($_POST['tipo_patrimonio'])) {
                        $_SESSION['tipo_patrimonio'] = $_POST['tipo_patrimonio'];
                        //echo '<h1>Sessão: '.$_SESSION['tipo_patrimonio'].'</h1>';
                        echo '<script>document.getElementById("tipo_patrimonio").value = "'.$_POST['tipo_patrimonio'].'"</script>';
                        $sql_tipo = "SELECT DISTINCT marca_patrimonio FROM tb_patrimonio WHERE tipo_patrimonio = '".$_SESSION['tipo_patrimonio']."' ORDER BY marca_patrimonio ASC"; 
                        $resulta = $conn->query($sql_tipo);
                        if ($resulta->num_rows > 0){
                          echo '<label for="marca_patrimonio">Marca</label>';
                          echo '<select name="marca_patrimonio" id="marca_patrimonio"  class="aspNetDisabled form-control form-control-sm">';
                          echo '  <option selected="selected" value=""></option>';

                          while ( $row = $resulta->fetch_assoc()){
                            echo '  <option value="'.$row['marca_patrimonio'].'">'.$row['marca_patrimonio'].'</option>';
                          }
                          echo '</select>';
                          //echo '<input type="submit" class="btn btn-success">';
                        }
                      }
                    ?>



                    <?php
                      if(isset($_POST['marca_patrimonio'])) {
                        $_SESSION['marca_patrimonio'] = $_POST['marca_patrimonio'];
                        //echo '<h1>Sessão: '.$_SESSION['marca_patrimonio'].'</h1>';
                        echo '<script>document.getElementById("marca_patrimonio").value = "'.$_POST['marca_patrimonio'].'"</script>';
                        $sql_tipo = "SELECT DISTINCT modelo_patrimonio FROM tb_patrimonio WHERE marca_patrimonio = '".$_SESSION['marca_patrimonio']."' ORDER BY modelo_patrimonio ASC"; 
                        $resulta = $conn->query($sql_tipo);
                        if ($resulta->num_rows > 0){
                          echo '<label for="modelo_patrimonio">Modelo</label>';
                          echo '<select name="modelo_patrimonio" id="modelo_patrimonio"  class="aspNetDisabled form-control form-control-sm">';
                          echo '<option selected="selected" value=""></option>';

                          while ( $row = $resulta->fetch_assoc()){
                            
                            echo '  <option value="'.$row['modelo_patrimonio'].'">'.$row['modelo_patrimonio'].'</option>';
                          }
                          echo '</select>';
                          //echo '<input type="submit" class="btn btn-success">';
                        }
                      }
                    ?>


                    <?php
                      if(isset($_POST['modelo_patrimonio'])) {
                        $_SESSION['modelo_patrimonio'] = $_POST['modelo_patrimonio'];
                        //echo '<h1>Sessão: '.$_SESSION['modelo_patrimonio'].'</h1>';
                        echo '<script>document.getElementById("modelo_patrimonio").value = "'.$_POST['modelo_patrimonio'].'"</script>';
                        $sql_tipo = "SELECT DISTINCT versao_patrimonio FROM tb_patrimonio WHERE marca_patrimonio = '".$_SESSION['marca_patrimonio']."' AND modelo_patrimonio = '".$_SESSION['modelo_patrimonio']."' ORDER BY versao_patrimonio ASC"; 
                        $resulta = $conn->query($sql_tipo);
                        if ($resulta->num_rows > 0){
                          echo '<label for="versao_patrimonio">Versao</label>';
                          echo '<select name="versao_patrimonio" id="versao_patrimonio"  class="aspNetDisabled form-control form-control-sm">';
                          echo '<option selected="selected" value=""></option>';

                          while ( $row = $resulta->fetch_assoc()){
                            
                            echo '  <option value="'.$row['versao_patrimonio'].'">'.$row['versao_patrimonio'].'</option>';
                          }
                          echo '</select>';
                          //echo '<input type="submit" class="btn btn-success">';
                        }
                      }
                    ?>



                    <?php
                      if(isset($_POST['versao_patrimonio'])) {
                        $_SESSION['versao_patrimonio'] = $_POST['versao_patrimonio'];
                        //echo '<h1>Sessão: '.$_SESSION['versao_patrimonio'].'</h1>';
                        echo '<script>document.getElementById("versao_patrimonio").value = "'.$_POST['versao_patrimonio'].'"</script>';
                        $sql_tipo = "SELECT DISTINCT nserie_patrimonio FROM tb_patrimonio WHERE modelo_patrimonio = '".$_SESSION['modelo_patrimonio']."' AND versao_patrimonio = '".$_SESSION['versao_patrimonio']."' ORDER BY nserie_patrimonio ASC"; 
                        $resulta = $conn->query($sql_tipo);
                        if ($resulta->num_rows > 0){
                          echo '<label for="nserie_patrimonio">Numero de Série</label>';
                          echo '<select name="nserie_patrimonio" id="nserie_patrimonio"  class="aspNetDisabled form-control form-control-sm">';
                          echo '<option selected="selected" value=""></option>';

                          while ( $row = $resulta->fetch_assoc()){
                            
                            echo '  <option value="'.$row['nserie_patrimonio'].'">'.$row['nserie_patrimonio'].'</option>';
                          }
                          echo '</select>';
                          //echo '<input type="submit" class="btn btn-success">';
                        }
                      }
                    ?>
                  </div>
                  <input type="submit" class="btn btn-success">
                </form>
              </div>
            </div>
          </div>
        
                        
          </div>
          </div>
          
            <div class="card-body">
              <h4 class="card-title">Consulta de Patrimõnio</h4>
              <p class="card-description">Procure pela ordem de Marca Modelo e versão</p>
              <div class="kt-portlet__body">
                <div class="row">
                  <div class="col-12 col-md-12">
                    <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">

                      <h3 class="kt-portlet__head-title">Dados do equipamento</h3> 
                      <div id="ContentPlaceHolder1_iAcCidade_iPnPrincipal" class="typeahead">
                      <h3 class="kt-portlet__head-title">Dados do equipamento</h3> 



                    <style>


                      .navbar {
                        overflow: hidden;
                        background-color: #333; 
                      }

                      .navbar a {
                        float: left;
                        font-size: 16px;
                        color: white;
                        text-align: center;
                        padding: 14px 16px;
                        text-decoration: none;
                      }

                      .subnav {
                        float: left;
                        overflow: hidden;
                      }

.subnav .subnavbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .subnav:hover .subnavbtn {
  background-color: red;
}

.subnav-content {
  display: none;
  position: absolute;
  left: 0;
  background-color: red;
  width: 100%;
  height: 100px;
  z-index: 1;
}

.subnav-content a {
  float: left;
  color: white;
  text-decoration: none;
}

.subnav-content a:hover {
  background-color: #eee;
  color: black;
}

.subnav:hover .subnav-content {
  display: block;
}
</style>


<div class="navbar" style="height: 500px;">

  <div class="subnav">
    <button class="subnavbtn">Status</button>
    <div class="subnav-content">
      <a href="#company">Company</a>
      <a href="#team">Team</a>
      <a href="#careers">Careers</a>
    </div>
  </div> 
  <div class="subnav">
    <button class="subnavbtn">Saúde</button>
    <div class="subnav-content" >
      <h2>Teste</h2>
      <a href="#bring">Bring</a>
      <a href="#deliver">Deliver</a>
      <a href="#package">Package</a>
      <a href="#express">Express</a>
    </div>
  </div> 
  <div class="subnav">
    <button class="subnavbtn">Histórioco</button>
    <div class="subnav-content">
      <a href="#link1">Link 1</a>
      <a href="#link2">Link 2</a>
      <a href="#link3">Link 3</a>
      <a href="#link4">Link 4</a>
    </div>
  </div>
  
</div>

<div style="padding:0 16px">
  <h3>Subnav/dropdown menu inside a Navigation Bar</h3>
  <p>Hover over the "about", "services" or "partners" link to see the sub navigation menu.</p>
</div>





                    



</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          

          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard templates</a> from Bootstrapdash.com</span>
          </div>
        </footer>
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
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>
