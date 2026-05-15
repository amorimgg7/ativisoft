<?php 
    session_start();  
    if(!isset($_SESSION['cd_pessoa']))
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
  <title>Dispositivo</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">

  
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
            <div class="col-12 grid-margin">
              <div class="card">
                

                <?php
                  if(isset($_POST['limparOS'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    session_start();
                    $_SESSION['cd_cliente'] = 0;
                    $_SESSION['cd_dispositivo'] = 0;
                    $_SESSION['vtotal_casa'] = 0;
                    $_SESSION['vpag_total'] = 0;
                    echo '<script>document.getElementById("consulta").style.display = "block";</script>';//botoes
                    echo '<script>document.getElementById("botoes").style.display = "none";</script>';//
                }
                ?>
                
                <?php
                  if(isset($_POST['concd_dispositivo']) ){
                    $_SESSION['cd_dispositivo'] = $_POST['concd_dispositivo'];
                    $_SESSION['dispositivo'] = $_POST['concd_dispositivo'];
                  }

                  if(isset($_SESSION['dispositivo']) ){
                    $select_dispositivo = "SELECT * FROM tb_dispositivo WHERE cd_dispositivo = '".$_SESSION['dispositivo']."'";
                    $result_dispositivo = mysqli_query($conn, $select_dispositivo);
                    $row_dispositivo = mysqli_fetch_assoc($result_dispositivo);
                    // Exibe as informações do usuário no formulário
                    if($row_dispositivo) {
                      $_SESSION['dispositivo'] = $row_dispositivo['cd_dispositivo'];
                      $_SESSION['cd_dispositivo'] = $row_dispositivo['cd_dispositivo'];
                      $_SESSION['cd_casa_dispositivo'] = $row_dispositivo['cd_casa_dispositivo'];
                      $_SESSION['mac_dispositivo'] = $row_dispositivo['mac_dispositivo'];
                      $_SESSION['ip_dispositivo'] = $row_dispositivo['ip_dispositivo'];
                      $_SESSION['mascara_dispositivo'] = $row_dispositivo['mascara_dispositivo'];
                      $_SESSION['gateway_dispositivo'] = $row_dispositivo['gateway_dispositivo'];
                      $_SESSION['marca_dispositivo'] = $row_dispositivo['marca_dispositivo'];
                      $_SESSION['modelo_dispositivo'] = $row_dispositivo['modelo_dispositivo'];
                      $_SESSION['versao_dispositivo'] = $row_dispositivo['versao_dispositivo'];
                      $_SESSION['titulo_dispositivo'] = $row_dispositivo['titulo_dispositivo'];
                      $_SESSION['local_dispositivo'] = $row_dispositivo['local_dispositivo'];
                      $_SESSION['status_dispositivo'] = $row_dispositivo['status_dispositivo'];
                      $_SESSION['canal_1'] = $row_dispositivo['canal_1'];
                      $_SESSION['canal_2'] = $row_dispositivo['canal_2'];
                      $_SESSION['canal_3'] = $row_dispositivo['canal_3'];
                      $_SESSION['canal_4'] = $row_dispositivo['canal_4'];
                      $_SESSION['canal_5'] = $row_dispositivo['canal_5'];
                      $_SESSION['canal_6'] = $row_dispositivo['canal_6'];
                      $_SESSION['canal_7'] = $row_dispositivo['canal_7'];
                      $_SESSION['canal_8'] = $row_dispositivo['canal_8'];
                      
                    }

                  }

                  




                
                

                  //desfazer_rezerva

                  
                ?>
                
                <?php
                  if($_SESSION['cd_dispositivo'] > 0){
                    $_SESSION['dispositivo'] = $_SESSION['cd_dispositivo'];

                    echo '<div class="card-body" >';
                    echo '<div class="kt-portlet__body">';
                    echo '<div class="row">';
                    echo '<div class="col-12 col-md-12">';
                    echo '<div class="nc-form-tac">';
                    //echo '<form method="POST" id="alter_dispositivo" name="alter_dispositivo">';
                    echo '<div class="typeahead" style="display: block;">';
                    /*
                    echo '<label for="btncd_dispositivo">Código do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['cd_dispositivo'].'" type="tel" name="btncd_dispositivo" id="btncd_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btncd_casa_dispositivo">Código da Casa do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['cd_casa_dispositivo'].'" type="tel" name="btncd_casa_dispositivo" id="btncd_casa_dispositivo" class="form-control form-control-sm" readonly>';
*/
                    echo '<label for="btnmac_dispositivo">MAC do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['mac_dispositivo'].'" type="text" name="btnmac_dispositivo" id="btnmac_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnip_dispositivo">IP do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['ip_dispositivo'].'" type="text" name="btnip_dispositivo" id="btnip_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnmascara_dispositivo">Máscara do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['mascara_dispositivo'].'" type="text" name="btnmascara_dispositivo" id="btnmascara_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btngateway_dispositivo">Gateway do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['gateway_dispositivo'].'" type="text" name="btngateway_dispositivo" id="btngateway_dispositivo" class="form-control form-control-sm" readonly>';
/*
                    echo '<label for="btnmarca_dispositivo">Marca do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['marca_dispositivo'].'" type="text" name="btnmarca_dispositivo" id="btnmarca_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnmodelo_dispositivo">Modelo do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['modelo_dispositivo'].'" type="text" name="btnmodelo_dispositivo" id="btnmodelo_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnversao_dispositivo">Versão do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['versao_dispositivo'].'" type="text" name="btnversao_dispositivo" id="btnversao_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btntitulo_dispositivo">Título do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['titulo_dispositivo'].'" type="text" name="btntitulo_dispositivo" id="btntitulo_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnlocal_dispositivo">Local do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['local_dispositivo'].'" type="text" name="btnlocal_dispositivo" id="btnlocal_dispositivo" class="form-control form-control-sm" readonly>';

                    echo '<label for="btnstatus_dispositivo">Status do Dispositivo</label>';
                    echo '<input value="'.$_SESSION['status_dispositivo'].'" type="text" name="btnstatus_dispositivo" id="btnstatus_dispositivo" class="form-control form-control-sm" readonly>';
*/
                    



                    //echo "<meta http-equiv='refresh' content='1;url=".$_SESSION['dominio']."pages/md_hospedagem/p1.php'>";//<meta http-equiv="refresh" content="1;url=https://www.novapagina.com">


                    // Carregar a biblioteca Chart.js
    

?>
                      <script>
                        function updateContent1() {
                          fetch('../../partials/p1.php')
                          .then(response => response.text())
                          .then(data => {
                            document.getElementById('content1').innerHTML = data;
                          })
                          .catch(error => console.error('Erro:', error));
                        }
                        setInterval(updateContent1, 1000);
                        window.onload = updateContent1;
                      </script>
                      <div style="width:100%;" id="content1"><h1>Carregando #1...</h1></div>
                    <?php
                      echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
    

                      if($_SESSION['modelo_dispositivo'] == "Higrometro_1_0" ){

                        // Estrutura HTML para os gráficos
    echo '<div class="row">
    <div class="col-sm-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Temperatura</h4>
          <canvas id="lineChart_temperatura"></canvas>
        </div>
      </div>
    </div>
  <!--</div>
  <div class="row">-->
    <div class="col-sm-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Umidade</h4>
          <canvas id="lineChart_umidade"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Temperatura e Umidade</h4>
          <canvas id="lineChart2"></canvas>
        </div>
      </div>
    </div>
  </div>
  <!--<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Bar chart</h4>
          <canvas id="barChart"></canvas>
        </div>
      </div>
    </div>
  </div>-->';
                      }
    
    
    // Consultar dados do banco de dados
    $sql_clima_tempo2 = "SELECT temperatura_clima_tempo AS media_temperatura, umidade_clima_tempo AS media_umidade FROM clima_tempo WHERE mac_dispositivo_clima_tempo = '".$row_dispositivo['mac_dispositivo']."' order by dt_clima_tempo asc limit 1000";
    
    $sql_clima_tempo = "SELECT 
    DATE_FORMAT(dt_clima_tempo, '%Y-%m-%d %H:00:00') AS hora,
    ROUND(AVG(temperatura_clima_tempo), 2) AS media_temperatura,
    ROUND(AVG(umidade_clima_tempo), 2) AS media_umidade
FROM 
    clima_tempo
WHERE 
    mac_dispositivo_clima_tempo = '".$row_dispositivo['mac_dispositivo']."' 
    AND dt_clima_tempo >= NOW() - INTERVAL 24 HOUR
GROUP BY 
    DATE_FORMAT(dt_clima_tempo, '%Y-%m-%d %H:00:00')
ORDER BY 
    hora ASC
LIMIT 24";




$resulta_clima_tempo = $conn->query($sql_clima_tempo);
$resulta_clima_tempo2 = $conn->query($sql_clima_tempo2);
    
    $temperaturas = [];
    $umidades = [];
    
    if ($resulta_clima_tempo->num_rows > 0) {
        while ($clima_tempo = $resulta_clima_tempo->fetch_assoc()) {
            $temperaturas[] = $clima_tempo["media_temperatura"];
            $umidades[] = $clima_tempo["media_umidade"];
        }
    }

    $temperaturas2 = [];
    $umidades2 = [];
    
    if ($resulta_clima_tempo2->num_rows > 0) {
        while ($clima_tempo2 = $resulta_clima_tempo2->fetch_assoc()) {
            $temperaturas2[] = $clima_tempo2["media_temperatura"];
            $umidades2[] = $clima_tempo2["media_umidade"];
        }
    }
    ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Função para criar gráficos
        function createChart(ctx, type, labels, datasets) {
            return new Chart(ctx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    
        // Dados fornecidos pelo PHP
        var temperaturas = <?php echo json_encode($temperaturas); ?>;
        var umidades = <?php echo json_encode($umidades); ?>;
        var labels = Array.from({length: temperaturas.length}, (_, i) => i + 1); // Usando índices como rótulos
    
        // Configuração dos datasets
        var temperatureDataset = {
            label: 'Temperatura',
            data: temperaturas,
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            fill: false
        };
    
        var humidityDataset = {
            label: 'Umidade',
            data: umidades,
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1,
            fill: false
        };
    
        // Gráfico de linha
        var ctxLineTemp = document.getElementById('lineChart_temperatura').getContext('2d');
        var temperatureBarDataset = {
            ...temperatureDataset,
            backgroundColor: 'rgba(75, 192, 192, 0.2)'
        };
        createChart(ctxLineTemp, 'line', labels, [temperatureDataset]);


        var ctxLineUmid = document.getElementById('lineChart_umidade').getContext('2d');
        var humidityBarDataset = {
            ...humidityDataset,
            backgroundColor: 'rgba(255, 159, 64, 0.2)'
        };
        createChart(ctxLineUmid, 'line', labels, [humidityDataset]);
    


        // Dados fornecidos pelo PHP
        var temperaturas2 = <?php echo json_encode($temperaturas2); ?>;
        var umidades2 = <?php echo json_encode($umidades2); ?>;
        var labels2 = Array.from({length: temperaturas2.length}, (_, i) => i + 1); // Usando índices como rótulos
    
        // Configuração dos datasets
        var temperatureDataset2 = {
            label: 'Temperatura',
            data: temperaturas2,
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            fill: false
        };
    
        var humidityDataset2 = {
            label: 'Umidade',
            data: umidades2,
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 1,
            fill: false
        };
    
        // Gráfico de linha
        var ctxLine2 = document.getElementById('lineChart2').getContext('2d');
        var temperatureBarDataset2 = {
            ...temperatureDataset2,
            backgroundColor: 'rgba(75, 192, 192, 0.2)'
        };
        var humidityBarDataset2 = {
            ...humidityDataset2,
            backgroundColor: 'rgba(255, 159, 64, 0.2)'
        };
        createChart(ctxLine2, 'line', labels2, [temperatureDataset2, humidityDataset2]);
    });
    </script>
                    
                    <?php


                    for ($i = 1; $i <= 8; $i++) {
                      if (isset($_POST['btncanal_' . $i])) {
                          $edit_canais = "UPDATE tb_dispositivo SET
                              canal_" . $i . " = '" . $_POST['btncanal_' . $i] . "'
                              WHERE cd_dispositivo = '" . $_SESSION['cd_dispositivo'] . "'";
                          if (mysqli_query($conn, $edit_canais)) {
                              //echo "<script>window.alert('Canal " . $i . " atualizado para " . $_POST['btncanal_' . $i] . "!');</script>";
                              $select_dispositivo = "SELECT * FROM tb_dispositivo WHERE cd_dispositivo = '" . $_SESSION['cd_dispositivo'] . "'";
                              $result_dispositivo = mysqli_query($conn, $select_dispositivo);
                              $row_dispositivo = mysqli_fetch_assoc($result_dispositivo);
                              // Atualiza a sessão com o novo valor do canal
                              if ($row_dispositivo) {
                                  $_SESSION['canal_' . $i] = $row_dispositivo['canal_' . $i];
                              }
                          } else {
                              echo "<script>window.alert('Erro ao atualizar o canal " . $i . "!');</script>";
                          }
                      }
                    }

                    echo '</form>';


                    //echo '<td><a href="'.$_SESSION['dominio'].'/pages/md_hospedagem/editar_casa.php" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Voltar para Imóvel</a></td>';
                    echo '<td><a href="'.$_SESSION['dominio'].'/pages/dashboard/index.php" class="btn btn-block btn-outline-warning">Voltar ao início</a></td>';
                    //echo '</form>';
                    echo '</div>';
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                  }
                ?>
                
                

                

              </div>
            </div>
          </div>
      
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <?php
          //include("../../partials/_footer.php");
        ?>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="../../vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/file-upload.js"></script>
  <script src="../../js/typeahead.js"></script>
  <script src="../../js/select2.js"></script>
  <!-- End custom js for this page-->
</body>

</html>