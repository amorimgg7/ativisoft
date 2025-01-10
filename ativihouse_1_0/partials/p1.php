
<?php 
    session_start();  
    
    require_once '../classes/conn.php';
?><!--Validar sessão aberta, se usuário está logado.-->

<?php


    echo 'Atualizado em: '.date("d/m/Y H:i:s").' !';
    //echo "<meta http-equiv='refresh' content='1;url=".$_SESSION['dominio']."pages/dashboard/index.php'>";//<meta http-equiv="refresh" content="1;url=https://www.novapagina.com">


    $select_dispositivo = "SELECT * FROM tb_dispositivo WHERE cd_dispositivo = '".$_SESSION['dispositivo']."'";
    $result_dispositivo = mysqli_query($conn, $select_dispositivo);
    $row_dispositivo = mysqli_fetch_assoc($result_dispositivo);
    // Exibe as informações do usuário no formulário
    if($row_dispositivo) {
      $_SESSION['canal_1'] = $row_dispositivo['canal_1'];
      $_SESSION['canal_2'] = $row_dispositivo['canal_2'];
      $_SESSION['canal_3'] = $row_dispositivo['canal_3'];
      $_SESSION['canal_4'] = $row_dispositivo['canal_4'];
      $_SESSION['canal_5'] = $row_dispositivo['canal_5'];
      $_SESSION['canal_6'] = $row_dispositivo['canal_6'];
      $_SESSION['canal_7'] = $row_dispositivo['canal_7'];
      $_SESSION['canal_8'] = $row_dispositivo['canal_8'];                  
    }


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

      echo '<div class="container">';
echo '<div class="row justify-content-center">'; // Flex container to align cards horizontally

if($row_dispositivo['modelo_dispositivo'] == "Luzes_2_0"){
    for ($i = 1; $i <= 8; $i++) {
        if ($_SESSION['canal_' . $i] > 0) {
            echo '<div class="col-6 col-md-3 mb-3">'; // Each card takes up a fraction of the row's width
            echo '<div class="card text-center">'; // Center text inside the card
            echo '<form method="POST">';
            //echo '<div>';
            echo '<p class="mb-2">Canal ' . $i . ' - ' . $_SESSION['canal_' . $i] . '</p>';
            if ($_SESSION['canal_' . $i] == 2) {
                echo '<input style="display:none;" type="text" id="btncanal_' . $i . '" name="btncanal_' . $i . '" value="1">';
                echo '<input type="submit" value="Canal ' . $i . '" class="btn btn-info">';
            } else {
                echo '<input style="display:none;" type="text" id="btncanal_' . $i . '" name="btncanal_' . $i . '" value="2">';
                echo '<input type="submit" value="Canal ' . $i . '" class="btn btn-dark">';
            }
            //echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
    }
}else if($row_dispositivo['modelo_dispositivo'] == "Higrometro_1_0"){
    echo '<div class="col-6 col-md-3 mb-3">'; // Each card takes up a fraction of the row's width
    echo '<div class="card text-center">'; // Center text inside the card
    //echo '<form method="POST">';
    //echo '<div>';
    echo '<p class="mb-2">Temperatura</p>';
    
    echo '<input style="display:none;" type="text" id="btncanal_1" name="btncanal_1">';
    echo '<input type="submit" value="'. $row_dispositivo['canal_1'] .'°C" class="btn btn-info">';
    
    //echo '</div>';
    //echo '</form>';
    echo '</div>';
    echo '</div>'; 

    echo '<div class="col-6 col-md-3 mb-3">'; // Each card takes up a fraction of the row's width
    echo '<div class="card text-center">'; // Center text inside the card
    //echo '<form method="POST">';
    //echo '<div>';
    echo '<p class="mb-2">Umidade</p>';
    
    echo '<input style="display:none;" type="text" id="btncanal_2" name="btncanal_1">';
    echo '<input type="submit" value="'. $row_dispositivo['canal_2'] .'%" class="btn btn-info">';
    
    //echo '</div>';
    //echo '</form>';
    

    echo '</div>';
    echo '</div>';
/*

    echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
  
    // Estrutura HTML para os gráficos
    echo '<div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Temperatura</h4>
                  <canvas id="lineChart_temperatura"></canvas>
                </div>
              </div>
            </div>
          <!--</div>
          <div class="row">-->
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Umidade</h4>
                  <canvas id="lineChart_umidade"></canvas>
                </div>
              </div>
            </div>
          </div>';
    
    // Consultar dados do banco de dados
    //$sql_clima_tempo = "SELECT temperatura_clima_tempo AS media_temperatura, umidade_clima_tempo AS media_umidade FROM clima_tempo WHERE mac_dispositivo_clima_tempo = '".$row_dispositivo['mac_dispositivo']."' order by dt_clima_tempo desc limit 1000";
    
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
    
    $temperaturas = [];
    $umidades = [];
    
    if ($resulta_clima_tempo->num_rows > 0) {
        while ($clima_tempo = $resulta_clima_tempo->fetch_assoc()) {
            $temperaturas[] = $clima_tempo["media_temperatura"];
            $umidades[] = $clima_tempo["media_umidade"];
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
    
        // Gráfico de barra
        /*
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var temperatureBarDataset = {
            ...temperatureDataset,
            backgroundColor: 'rgba(75, 192, 192, 0.2)'
        };
        var humidityBarDataset = {
            ...humidityDataset,
            backgroundColor: 'rgba(255, 159, 64, 0.2)'
        };
        createChart(ctxBar, 'bar', labels, [temperatureBarDataset, humidityBarDataset]);
        
    });
    </script>
    
<?PHP
*/

    $sql_clima_tempo = "SELECT * FROM clima_tempo WHERE mac_dispositivo_clima_tempo = '".$row_dispositivo['mac_dispositivo']."' order by dt_clima_tempo desc limit 5";
    $resulta_clima_tempo = $conn->query($sql_clima_tempo);
    if ($resulta_clima_tempo->num_rows > 0) {
        echo '<table>';
        echo '<tr>';
        echo '<td>----------Data e Hora----------</td>';
        echo '<td>Temperatura----------</td>';
        echo '<td>Umidade----------</td>';
        echo '</tr>';
        
        while ($clima_tempo = $resulta_clima_tempo->fetch_assoc()) {
            echo '<tr>';
            echo '<td>'.$clima_tempo["dt_clima_tempo"].'</td>';
            echo '<td>'.$clima_tempo["temperatura_clima_tempo"].'</td>';
            echo '<td>'.$clima_tempo["umidade_clima_tempo"].'</td>';
            echo '</tr>';
        }
        
        echo '</table>';

    }




    



 

}

echo '</div>';
echo '</div>';

?>



         