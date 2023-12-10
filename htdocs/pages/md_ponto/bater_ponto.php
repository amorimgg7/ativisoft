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
  <title>Geral Empresas</title>
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
          
          

          <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
          <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />






          <div class="card-body" id="cadastro">
  <h4 class="card-title">Folha de ponto</h4>
  <div class="kt-portlet__body">
    <div class="row">
      <div class="col-12 col-md-12">
        <div id="ContentPlaceHolder1_iAcCidade_iUpPnGeral" class="nc-form-tac">
          <form method="POST" >

            <div class="typeahead" style="display:none;">
              <label for="data_ponto">Data</label>
              <input name="data_ponto" type="text" id="data_ponto" class="aspNetDisabled form-control form-control-sm" />

              <label for="hora_ponto">Hora</label>
              <input name="hora_ponto" type="text" id="hora_ponto" class="aspNetDisabled form-control form-control-sm" />

              <!--<input type="submit" class="btn btn-success" value="Salvar">-->
            </div>

            <div class="typeahead" style="display:none;">
              <label for="cdempresa_ponto">CD Empresa</label>
              <input name="cdempresa_ponto" type="tel" id="cdempresa_ponto" class="aspNetDisabled form-control form-control-sm" />

              <label for="pais_ponto">Pais</label>
              <input name="pais_ponto" type="text" id="pais_ponto" class="aspNetDisabled form-control form-control-sm" />

              <label for="estado_ponto">Estado</label>
              <input name="estado_ponto" type="text" id="estado_ponto" class="aspNetDisabled form-control form-control-sm" />

              <label for="cidade_ponto">Cidade</label>
              <input name="cidade_ponto" type="text" id="cidade_ponto" class="aspNetDisabled form-control form-control-sm" />

              <label for="bairro_ponto">Bairro</label>
              <input name="bairro_ponto" type="text" id="bairro_ponto" class="aspNetDisabled form-control form-control-sm" />

              <!--<input type="submit" class="btn btn-success" value="Salvar">-->
            </div>


            <div class="typeahead" style="display:none;">
              <label for="cdpessoal_ponto">CD Pessoal</label>
              <input name="cdpessoal_ponto" type="tel" id="cdpessoal_ponto" class="aspNetDisabled form-control form-control-sm" />

              <label for="cpf_ponto">CPF</label>
              <input name="cpf_ponto" type="text" id="cpf_ponto" class="aspNetDisabled form-control form-control-sm" />

              <label for="nome_ponto">Nome</label>
              <input name="nome_ponto" type="text" id="nome_ponto" class="aspNetDisabled form-control form-control-sm" />


            </div>


            <input type="submit" name="bater_ponto" id="bater_ponto" class="btn btn-success" value="Bater Ponto" onmousedown="startTimer()" onmouseup="checkTimer()">

            <script>
              var timerId;

              function startTimer() {
                timerId = setTimeout(function() {
                  document.querySelector('form').submit();
                }, 5000);
              }

              function checkTimer() {
                clearTimeout(timerId);
              }
            </script>

          </form>
        </div>

                          <?php 
                          
                          if (isset($_POST['bater_ponto']))
                          {
                            $cdpessoal_ponto = addslashes($_POST['cdpessoal_ponto']);
                            $cdempresa_ponto = addslashes($_POST['cdempresa_ponto']);
                            $pais_ponto = addslashes($_POST['pais_ponto']);
                            $estado_ponto = addslashes($_POST['estado_ponto']);
                            $cidade_ponto = addslashes($_POST['cidade_ponto']);
                            $bairro_ponto = addslashes($_POST['bairro_ponto']);
                            $data_ponto = addslashes($_POST['data_ponto']);
                            $hora_ponto = addslashes($_POST['hora_ponto']);
                            
                              $u->conectar(); 
                              if ($u-> $msgErro == "")
                              {
                                //if($u->baterPonto($cdpessoal_ponto, $cdempresa_ponto, $pais_ponto, $estado_ponto, $cidade_ponto, $bairro_ponto, $data_ponto, $hora_ponto)) 
                                if($u->baterPonto($cdpessoal_ponto, $cdempresa_ponto, $pais_ponto, $estado_ponto, $cidade_ponto, $bairro_ponto, $data_ponto, $hora_ponto)) 
                                {
                                  ?>
                                  
                                  
                                  <!--<script>window.alert("SUCESSO");</script>-->
                                  <script>// Limpa os cookies
                                    // Remove as informações do formulário do histórico de navegação
                                    history.replaceState({}, document.title, window.location.href.split('?')[0]);

                                    // Recarrega a página
                                    window.location.reload();
                                  </script>
                                  <?php
                                  //echo '<script>location.href="AreaPrivada.php";</script>';
                                }
                                else
                                {
                                 ?>
                                  <!--<script>window.alert("FALHA");</script>-->
                                  
                                  <?php
                                }
                                
                              }
                              else
                              {
                                
                              }
                            
                          }
                          ?>




                        





<div class="row mt-3">
            <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
              <div class="row flex-grow">
                <?php 
  // Obter a data atual no formato correto
  $data_atual = date('Y-m-d');
  if($_SESSION['cd_empresa'] == 0){
    echo '<h1>Entre em contato com seu contratante</h1>';
  }
  else
  {
  // Construir a consulta SQL usando a data atual
  $sql_tipo = "SELECT * FROM fl_ponto WHERE cdpessoal_ponto = ".$_SESSION['cd_pessoal']." AND cdempresa_ponto = ".$_SESSION['cd_empresa'].""; 
  //$sql_tipo = "SELECT * FROM fl_ponto WHERE cdpessoal_ponto = ".$_SESSION['cd_pessoal']." AND cdempresa_ponto = ".$_SESSION['cd_empresa']." AND data_ponto = '$data_atual'"; 
  //$sql_tipo = "SELECT * FROM fl_ponto WHERE cdpessoal_ponto = ".$_SESSION['cd_pessoal']." AND cdempresa_ponto = ".$_SESSION['cd_empresa']." AND data_ponto = '1/5/2023'"; 

  // Executar a consulta SQL e verificar se há resultados
  $resulta = $conn->query($sql_tipo);
  if ($resulta->num_rows > 0){
    // Gerar a tabela com os dados dos pontos batidos
    echo '<div class="col-xl-4 grid-margin stretch-card">';
    echo '<div class="card">';
    echo '<div class="card-body">';
    echo '<h3>Ponto batido</h3>';
                    
    echo '<style>';
    echo '  table, th, td {border:1px solid black;}';
    echo '</style>';

    echo '<table style="width:100%">';
    echo '<tr>';
    echo '  <th>Token</th>';
    echo '  <th>Data</th>';
    echo '  <th>Hora</th>';
    echo '  <th>UF</th>';
    echo '  <th>Estado</th>';
    echo '  <th>Cidade</th>';
    echo '  <th>Bairro</th>';
    echo '</tr>';

    while ( $row = $resulta->fetch_assoc()){
      echo '<tr>';
      echo '<td>'.$row['token_alter'].'</td>';
      echo '<td>'.$row['data_ponto'].'</td>';
      echo '<td>'.$row['hora_ponto'].'</td>';
      echo '<td>'.$row['pais_ponto'].'</td>';
      echo '<td>'.$row['estado_ponto'].'</td>';
      echo '<td>'.$row['cidade_ponto'].'</td>';
      echo '<td>'.$row['bairro_ponto'].'</td>';
      echo '</tr>';
    }

    echo '</table>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }
}
?>

              </div>
            </div>
          </div>
          



                              <script>
                                var data = new Date();
                                var mesPorExtenso = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(data).toUpperCase();
                                var mes = data.getMonth() + 1;
                                var dia = data.getDate();
                                var ano = data.getFullYear();
                                var hora = data.getHours();
                                var minuto = data.getMinutes();
                                var segundo = data.getSeconds();
                                //document.getElementById("data-atual").innerHTML = 'HOJE É '+dia + ' DE ' + mesPorExtenso + ', ' + ano;
                                document.getElementById("data_ponto").value = ''+dia+'/'+mes+'/'+ano;
                                //document.getElementById("data_ponto2").innerHTML = ''+dia+'/'+mes+'/'+ano;
                                document.getElementById("hora_ponto").value = ''+hora+':'+minuto+':'+segundo;
                                
                                document.getElementById("cdpessoal_ponto").value = '<?php echo $_SESSION['cd_pessoal']?>';
                                document.getElementById("cpf_ponto").value = '<?php echo $_SESSION['cpf_pessoal']?>';
                                document.getElementById("nome_ponto").value = '<?php echo $_SESSION['pnome_pessoal'].' '.$_SESSION['snome_pessoal']?>';
                                
                                document.getElementById("cdempresa_ponto").value = '<?php echo $_SESSION['cd_empresa'];?>';
                              </script>


  

                        
                      </div>
                    </div>
                  </div>
                </div>




                








<div class="row mt-3" style="display:none;">
  <div class="col-xl-3 flex-column d-flex grid-margin stretch-card">
    <div class="row flex-grow">
      <div class="col-xl-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h1 id="latitude"></h1>
            <h1 id="longitude"></h1>
            <table>
              <tr>
                <th>Pais</th>
                <th>Estado</th>
                <th>Cidade</th>
                <th>Bairro</th>
              </tr>
              <tr>
                <td id="pais"></td>
                <td id="estado"></td>
                <td id="cidade"></td>
                <td id="bairro"></td>
              </tr>
            </table>
            <div id='map' style='width: 100%; height: 300px;'></div>
            <script>
              const endpoint =
                "https://geo.ipify.org/api/v1?apiKey=at_LqW8tIqzQA3fCKMB8hDkXDkkgu8a9";

              fetch(endpoint)
                .then((response) => response.json())
                .then((data) => {
                  const { country, region, city, district, lat, lng } = data.location;
                  const message = `Você está em ${district}, ${city}, ${region}, ${country}.`;

                 //window.alert(message);

                  // Atualize o valor das células da tabela com os dados da localização
                  document.getElementById("pais").innerHTML = country;
                  document.getElementById("pais_ponto").value = country;
                  document.getElementById("estado").innerHTML = region;
                  document.getElementById("estado_ponto").value = region;
                  document.getElementById("cidade").innerHTML = city;
                  document.getElementById("cidade_ponto").value = city;
                  document.getElementById("bairro").innerHTML = district;
                  document.getElementById("bairro_ponto").value = district;
                  document.getElementById("latitude").innerHTML = lat;
                  document.getElementById("longitude").innerHTML = lng;

                  // Crie o mapa do Mapbox e defina o centro para a localização atual
                  mapboxgl.accessToken = 'pk.eyJ1IjoiYW1vcmltZ2c3IiwiYSI6ImNsZ3d2bmVqNjAxa3ozZWxwZWprbHB1MDMifQ.sIgLSAu9fBvSU8pAMEQ3fQ';
                  const map = new mapboxgl.Map({
                    container: 'map', // container ID
                    style: 'mapbox://styles/mapbox/streets-v12', // style URL
                    center: [lng, lat], // starting position [lng, lat]
                    zoom: 13 // starting zoom
                  });
                })
                .catch((error) => {
                  console.error(error);
                  window.alert("Erro ao obter localização.");
                });
            </script>
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
  <script src="../../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>
