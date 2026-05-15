
<?php 
    session_start();  
    
    require_once '../classes/conn.php';
?><!--Validar sessão aberta, se usuário está logado.-->




<?php
    //echo '<p>Atualizado em: '.date("d/m/Y H:i:s").' !</p>';
    //$sql_temp_umid = "SELECT * FROM tb_dispositivo where modelo_dispositivo = 'Higrometro_1_0' and cd_casa_dispositivo = ".$_SESSION['cd_casa']." ";
    //$sql_temp_umid = "SELECT (sum(canal_1)/count(canal_1)) as temp_media, (sum(canal_2)/count(canal_1)) as umid_media FROM tb_dispositivo WHERE modelo_dispositivo = 'Higrometro_1_0' and cd_casa_dispositivo = ".$_SESSION['cd_casa']." ";
    
    $sql_temp_umid = "SELECT 
        dt_status_dispositivo,
        ROUND(SUM(canal_1) / COUNT(canal_1), 2) AS temp_media, 
        ROUND(SUM(canal_2) / COUNT(canal_1), 2) AS umid_media,
        COUNT(canal_1) as dispositivos_online,
        (SELECT COUNT(*) FROM tb_dispositivo WHERE cd_casa_dispositivo = ".$_SESSION['cd_casa'].") AS dispositivos_casa
        FROM 
            tb_dispositivo 
        WHERE 
            modelo_dispositivo = 'Higrometro_1_0' 
            AND cd_casa_dispositivo = ".$_SESSION['cd_casa']." 
            AND TIMESTAMPDIFF(MINUTE, dt_status_dispositivo, '".date('Y-m-d H:i:s', time())."') <= 1 
        LIMIT 0, 25;
    ";
    $resulta_temp_umid = $conn->query($sql_temp_umid);
    if ($resulta_temp_umid->num_rows > 0) {
        while ($temp_umid_media = $resulta_temp_umid->fetch_assoc()) {
            if ($temp_umid_media['dispositivos_online'] > 0){
                echo '<table>';
                echo '<table>';
                echo '<tr>';
                echo '<td style="height: 50px; width: 100px; border: 0px solid black; text-align: center; vertical-align: middle;">Higrometro<br>Online<br>' . $temp_umid_media['dispositivos_online'] . '</td>';
                echo '<td style="height: 50px; width: 100px; border: 0px solid black; text-align: center; vertical-align: middle;">Temperatura<br>' . $temp_umid_media['temp_media'] . '°C</td>';
                echo '<td style="height: 50px; width: 100px; border: 0px solid black; text-align: center; vertical-align: middle;">Umidade<br>' . $temp_umid_media['umid_media'] . '%</td>';
                echo '</tr>';
                echo '</table>';
            }else{
                if($temp_umid_media['dispositivos_casa'] > 0){
                    echo '<p>Higrometro offline</p>';
                }else{
                    echo '<p>Sem Higrometro</p>';
                }
            }
        }
        
    }else{
        echo '<p>Sem Higrometro</p>';
    }
?>
                
              
                