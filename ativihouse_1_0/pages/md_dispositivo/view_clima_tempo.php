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
  <title>Clima Tempo</title>
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
                  if(isset($_POST['limparTela'])){
                    //echo "<script>window.alert('Mostrar botão de limpar OS!');</script>";
                    session_start();
                    $_SESSION['cd_pessoa'] = 0;
                    $_SESSION['cd_casa'] = 0;
                    $_SESSION['cd_dispositivo'] = 0;
                    $_SESSION['vtotal_casa'] = 0;
                    $_SESSION['vpag_total'] = 0;
                }
                ?>
                
                <?php
                  if(isset($_POST['concd_casa']) ){
                    $_SESSION['cd_casa'] = $_POST['concd_casa'];
                    $_SESSION['casa'] = $_POST['concd_casa'];
                  }
                  

                  echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

if (isset($_SESSION['casa'])) {
    $sql_Higrometro_1_0 = "SELECT * FROM tb_dispositivo WHERE modelo_dispositivo = 'Higrometro_1_0' AND cd_casa_dispositivo = " . $_SESSION['casa'];
    $resulta_Higrometro_1_0 = $conn->query($sql_Higrometro_1_0);

    if ($resulta_Higrometro_1_0->num_rows > 0) {
        $counter = 0;

        while ($Higrometro_1_0 = $resulta_Higrometro_1_0->fetch_assoc()) {
            $counter++;


            $dataStatus = strtotime($Higrometro_1_0['dt_status_dispositivo']);
            $dataAtual = time();

            if (($dataAtual - $dataStatus) > 10) {
                echo '<div class="card text-white border-danger mb-3 shadow-lg bg-secondary align-items-center" style="margin: 10px;">';
                if($_SESSION['md_edicao_hw'] == 0){
                    echo '<div class="card-header bg-danger">Offline';
                }else if($_SESSION['md_edicao_hw'] == 1){
                    echo '<div class="card-header bg-danger">Offline';
                }else if($_SESSION['md_edicao_hw'] == 2){
                    echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/edit_dispositivo.php">';
                    echo '<input type="text" value="'.$Higrometro_1_0['cd_dispositivo'].'" id="concd_dispositivo" name="concd_dispositivo" style="display:none;">';
                    echo '<div class="card-header bg-danger"><input class="btn btn-block btn-danger" type="submit" value="'.$Higrometro_1_0['local_dispositivo'].' - '.$Higrometro_1_0['cd_dispositivo'].'V"></div>'; 
                    echo '</form>';
                }
                    
            } else {
                
              echo '<div class="card text-white border-success mb-3 shadow-lg bg-secondary align-items-center" style="margin: 10px;">';

                if($_SESSION['md_edicao_hw'] == 0){
                    echo '<div class="card-header bg-success">Offline';
                }else if($_SESSION['md_edicao_hw'] == 1){
                    echo '<div class="card-header bg-success">Offline';
                }else if($_SESSION['md_edicao_hw'] == 2){
                    echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/edit_dispositivo.php">';
                    echo '<input type="text" value="'.$Higrometro_1_0['cd_dispositivo'].'" id="concd_dispositivo" name="concd_dispositivo" style="display:none;">';
                    //echo '<div class="card-header bg-danger"><input class="btn btn-block btn-danger" type="submit" value="'.$Higrometro_1_0['cd_dispositivo'].' - '.$Higrometro_1_0['mac_dispositivo'].'"></div>'; 
                    echo '<div class="card-header bg-success"><input class="btn btn-block btn-success" type="submit" value="'.$Higrometro_1_0['local_dispositivo'].' - '.$Higrometro_1_0['canal_8'].'V"></div>'; 
                    echo '</form>';
                }
                /*
                echo '<div class="card text-white border-success mb-3 shadow-lg bg-secondary mb-3 align-items-center" style="margin: 10px; max-width: 18rem;">';
                
                if($_SESSION['md_edicao_hw'] == 0){
                    echo '<div class="card-header bg-success">Online <i class="icon-ellipsis"></i></div>';
                }else if($_SESSION['md_edicao_hw'] == 1){
                    echo '<div class="card-header bg-success">Online <i class="icon-ellipsis"></i></div>';
                }else if($_SESSION['md_edicao_hw'] == 2){
                    echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/edit_dispositivo.php">';
                    echo '<input type="text" value="'.$Higrometro_1_0['cd_dispositivo'].'" id="concd_dispositivo" name="concd_dispositivo" style="display:none;">';
                    //echo '<div class="card-header bg-success"><input class="btn btn-block btn-success" type="submit" value="Online"></div>'; 
                    echo '<div class="card-header bg-success"><input class="btn btn-block btn-success" type="submit" value="'.$Higrometro_1_0['local_dispositivo'].'"></div>'; 
                    echo '</form>';

                    //echo '<div class="card-header bg-success"><a href="'.$_SESSION['dominio'].'/pages/md_dispositivo/edit_dispositivo.php" class="btn btn-block btn-success">Online&nbsp<i class="icon-ellipsis"></i></a></div>'; 
                }
                    */
                //echo '<td><a href="'.$_SESSION['dominio'].'/pages/dashboard/index.php" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Voltar ao início</a></td>';
            }


            // Estrutura HTML para os gráficos
            
            //echo '<div class="card-header bg-danger">' . $counter . ' - ' . $Higrometro_1_0['mac_dispositivo'] . '</div>';

            /*
              <!--<div class="row mb-3 shadow-lg bg-secondary" style="margin: 0px;">
                    <div class="col-sm-6 col-lg-6 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Última Hora</h4>
                          <canvas id="lineChart_1H_' . $counter . '"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>-->
             */
            echo '<!--<div class="row mb-3 shadow-lg bg-secondary" style="margin: 0px;">-->
                    <div class="col-sm-6 col-lg-6 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body" style="padding:0; margin:0;">
                          
                          <canvas id="lineChart_24H_' . $counter . '"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>';
              
                  /*
            $sql_clima_tempo_24H = "SELECT 
                                    DATE_FORMAT(dt_clima_tempo, '%H:%i') AS hora,
                                    ROUND(AVG(temperatura_clima_tempo), 2) AS media_temperatura,
                                    ROUND(AVG(umidade_clima_tempo), 2) AS media_umidade
                                FROM 
                                    clima_tempo
                                WHERE 
                                    mac_dispositivo_clima_tempo = '" . $Higrometro_1_0['mac_dispositivo'] . "' 
                                    AND dt_clima_tempo >= NOW() - INTERVAL 24 HOUR
                                GROUP BY 
                                    DATE_FORMAT(dt_clima_tempo, '%Y-%m-%d %H:00:00')
                                ORDER BY 
                                    hora DESC
                                LIMIT 24";
                                */


                                $sql_clima_tempo_24H = "SELECT 
                                        DATE_FORMAT(clima_tempo.dt_clima_tempo, '%Y-%m-%d %H:00:00') AS hora_leitura,
                                        DATE_FORMAT(clima_tempo.dt_clima_tempo, '%H:00') AS hora,
                                        ROUND(AVG(clima_tempo.temperatura_clima_tempo), 2) AS media_temperatura,
                                        ROUND(AVG(clima_tempo.umidade_clima_tempo), 2) AS media_umidade,
                                        COUNT(*) AS quantidade_leituras
                                    FROM clima_tempo
                                    WHERE clima_tempo.dt_clima_tempo >= NOW() - INTERVAL 24 HOUR
                                      AND clima_tempo.dt_clima_tempo <= NOW()
                                      AND mac_dispositivo_clima_tempo = '" . $Higrometro_1_0['mac_dispositivo'] . "'
                                    GROUP BY DATE_FORMAT(clima_tempo.dt_clima_tempo, '%Y-%m-%d %H')
                                    ORDER BY hora_leitura DESC;";

            $resulta_clima_tempo_24H = $conn->query($sql_clima_tempo_24H);
            $temperaturas_24H = [];
            $umidades_24H = [];
            $hora_24H = [];

            if ($resulta_clima_tempo_24H->num_rows > 0) {
                while ($clima_tempo_24H = $resulta_clima_tempo_24H->fetch_assoc()) {
                    $temperaturas_24H[] = $clima_tempo_24H["media_temperatura"];
                    $umidades_24H[] = $clima_tempo_24H["media_umidade"];
                    $hora_24H[] = $clima_tempo_24H["hora"];
                }
            }

?>
            <script>





document.addEventListener('DOMContentLoaded', function () {
    // Função para criar gráficos
    function createChart(ctx, type, labels, datasets) {
        // Calcula o valor mínimo e máximo dos dados
        var allData = [].concat(...datasets.map(dataset => dataset.data));
        var minY = Math.min(...allData);
        var maxY = Math.max(...allData);

        return new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        min: minY - 2, // Define o mínimo do eixo Y
                        max: maxY + 2, // Define o máximo do eixo Y
                        ticks: {
                            // Opção para não incluir o zero
                            callback: function(value) {
                                return value !== 0 ? value : '';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Últimas 24 horas. Retroativo.'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var datasetLabel = tooltipItem.dataset.label || '';
                                var dataPoint = tooltipItem.raw;
                                if (datasetLabel === 'Temperatura') {
                                    return datasetLabel + ': ' + dataPoint + ' °C'; // Ajuste a unidade conforme necessário
                                } else if (datasetLabel === 'Umidade') {
                                    return datasetLabel + ': ' + dataPoint + ' %'; // Ajuste a unidade conforme necessário
                                }
                                return '';
                            }
                        }
                    }
                }
            }
        });
    }

    // Dados fornecidos pelo PHP para as últimas 24 horas
    var temperaturas_24H = <?php echo json_encode($temperaturas_24H); ?>;
    var umidades_24H = <?php echo json_encode($umidades_24H); ?>;
    var labels_hora = <?php echo json_encode($hora_24H); ?>; // Adiciona as horas como rótulos do eixo X

    // Configuração dos datasets para as últimas 24 horas
    var temperatureDataset_24H = {
        label: 'Temperatura',
        data: temperaturas_24H,
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        fill: false,
        pointRadius: 5,
        pointHoverRadius: 7
    };

    var humidityDataset_24H = {
        label: 'Umidade',
        data: umidades_24H,
        borderColor: 'rgba(255, 159, 64, 1)',
        borderWidth: 1,
        fill: false,
        pointRadius: 5,
        pointHoverRadius: 7
    };

    // Gráfico de linha para as últimas 24 horas
    var counter = 0; // Use 'var' para a variável
    var ctxLine_24H = document.getElementById('lineChart_24H_<?php echo $counter; ?>').getContext('2d');
    createChart(ctxLine_24H, 'line', labels_hora, [temperatureDataset_24H, humidityDataset_24H]);
});


/*
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

                    // Dados fornecidos pelo PHP para as últimas 24 horas
                    var temperaturas_24H = <?php //echo json_encode($temperaturas_24H); ?>;
                    var umidades_24H = <?php //echo json_encode($umidades_24H); ?>;
                    var labels_24H = Array.from({length: temperaturas_24H.length}, (_, i) => i + 1);

                    // Configuração dos datasets para as últimas 24 horas
                    var temperatureDataset_24H = {
                        label: 'Temperatura ('+temperaturas_24H+')',
                        data: temperaturas_24H,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    };

                    var humidityDataset_24H = {
                        label: 'Umidade ('+umidades_24H+')',
                        data: umidades_24H,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1,
                        fill: false,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    };

                    // Gráfico de linha para as últimas 24 horas
                    var ctxLine_24H = document.getElementById('lineChart_24H_<?php //echo $counter; ?>').getContext('2d');
                    createChart(ctxLine_24H, 'line', labels_24H, [temperatureDataset_24H, humidityDataset_24H]);

                    
/*

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

                    // Dados fornecidos pelo PHP para as últimas 24 horas
                    var temperaturas_24H = <?php //echo json_encode($temperaturas_24H); ?>;
                    var umidades_24H = <?php //echo json_encode($umidades_24H); ?>;
                    var horas_24H = <?php //echo json_encode($horas_24H); ?>; // Adicione um array de horas lido do PHP

                    // Defina labels_24H como o array de horas de leitura
                    var labels_24H = horas_24H;

                    // Pegue a última temperatura e umidade lidas
                    var ultimaTemperatura = temperaturas_24H[temperaturas_24H.length - 1];
                    var ultimaUmidade = umidades_24H[umidades_24H.length - 1];

                    // Configuração dos datasets para as últimas 24 horas
                    var temperatureDataset_24H = {
                        label: 'Última Temperatura: ' + ultimaTemperatura + ' °C',
                        data: temperaturas_24H,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    };

                    var humidityDataset_24H = {
                        label: 'Última Umidade: ' + ultimaUmidade + ' %',
                        data: umidades_24H,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1,
                        fill: false
                    };

                    // Gráfico de linha para as últimas 24 horas
                    var ctxLine_24H = document.getElementById('lineChart_24H_<?php //echo $counter; ?>').getContext('2d');
                    createChart(ctxLine_24H, 'line', labels_24H, [temperatureDataset_24H, humidityDataset_24H]);
*/
                //});
            </script>
          <?php
                  }
              }
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