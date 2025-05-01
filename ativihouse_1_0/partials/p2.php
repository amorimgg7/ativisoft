
<?php 
    session_start();  
    
    require_once '../classes/conn.php';
?><!--Validar sessão aberta, se usuário está logado.-->




<?php
if(isset($_SESSION['cd_casa']) && $_SESSION['cd_casa'] > 0){

    echo '<p>Atualizado em: '.date("d/m/Y H:i:s").' !</p>';
    $count = 0;
    $sql_Higrometro_1_0 = "SELECT * FROM tb_dispositivo where modelo_dispositivo = 'Higrometro_1_0' AND cd_casa_dispositivo = ".$_SESSION['cd_casa']." ";
    //$select_dispositivo = "SELECT * FROM tb_dispositivo WHERE cd_dispositivo = '".$_SESSION['dispositivo']."'";
    $result_Higrometro_1_0 = mysqli_query($conn, $sql_Higrometro_1_0);
    $row_Higrometro_1_0 = mysqli_fetch_assoc($result_Higrometro_1_0);
    // Exibe as informações do usuário no formulário
    if($row_Higrometro_1_0) {
        // A data e hora não são maiores que 30 segundos
        echo '<div class="card text-white border-success shadow-lg bg-secondary  align-items-center" style="margin: 10px;">';
        echo '<div class="card-header btn-block"><h1 class="card-title">Central de controle térmico</h1>';
        //echo '<td><a href="'.$_SESSION['dominio'].'/pages/dashboard/index.php" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Voltar ao início</a></td>';
        echo '</div>'; 
        echo '<div class="col col-md-6 col-lg-6 d-flex justify-content-center">';
        echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/view_clima_tempo.php">';
        echo '<input type="text" id="concd_casa" name="concd_casa" value="'.$_SESSION['cd_casa'].'" style="display:none;">';
        echo '<input class="btn btn-outline-success btn-lg btn-block" type="submit" value="Visualizar Dados">';
        echo '</form>';
        echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/edit_clima_tempo.php">';
        echo '<input type="text" id="concd_casa" name="concd_casa" value="'.$_SESSION['cd_casa'].'" style="display:none;">';
        //echo '<input class="btn btn-outline-success btn-lg btn-info" type="submit" value="preferencias do ambiente">';
        echo '</form>';
        echo '</div>';
        echo '<div class="card-footer text-muted">';
        echo '</div>';
        echo '</div>';

        $sql_casa = "SELECT * FROM tb_dispositivo where modelo_dispositivo = 'Higrometro_1_0' AND cd_casa_dispositivo = ".$_SESSION['cd_casa']." ";
        $resulta_casa = $conn->query($sql_casa);
        if ($resulta_casa->num_rows > 0) {
            while ($casas = $resulta_casa->fetch_assoc()) {
                if ($count % 6 == 0) {
                    if ($count > 0) {
                        echo '</div>'; // Fecha a div anterior, exceto na primeira iteração
                    }
                    echo '<div class="card-deck justify-content-center">';
                }
                if (isset($casas['dt_status_dispositivo'])) {
                    $dataStatus = strtotime($casas['dt_status_dispositivo']);
                    $dataAtual = time();
                    if (($dataAtual - $dataStatus) > 10) {
                        // A data e hora são maiores que 30 segundos
                        echo '<div class="card text-white border-danger mb-3 shadow-lg d-inline-block bg-secondary align-items-center" style="margin: 5px; max-width: 7rem;">';
                        if($_SESSION['md_edicao_hw'] == 0){
                            echo '<div class="card-header"><i style="color: #D00;" class="icon-thermometer"></i><i style="color: #D00;" class="icon-battery"> '.$casas['canal_8'].'%</i></div>';
                        }else if($_SESSION['md_edicao_hw'] == 1){
                            echo '<div class="card-header"><i style="color: #D00;" class="icon-thermometer"></i><i style="color: #D00;" class="icon-battery"> '.$casas['canal_8'].'%</i></div>';
                        }else if($_SESSION['md_edicao_hw'] == 2){
                            echo '<div class="card-header"><i style="color: #D00;" class="icon-thermometer"></i><i style="color: #D00;" class="icon-battery"> '.$casas['canal_8'].'%</i></div>';
                        }
                    } else {
                        // A data e hora não são maiores que 30 segundos
                        echo '<div class="card text-white border-success mb-3 shadow-lg  d-inline-block bg-secondary align-items-center" style="margin: 5px; max-width: 8rem;">';
                        $vin = $casas['canal_8'];  // Tensão medida
                        $batPercent = round(($vin / 3.5) * 100);
                        if($_SESSION['md_edicao_hw'] == 0){
                            echo '<div class="card-header"><i style="color: #0D0;" class="icon-battery"> '.$batPercent.'% '.$vin.'V</i></div>';
                        }else if($_SESSION['md_edicao_hw'] == 1){
                            echo '<div class="card-header"><i style="color: #0D0;" class="icon-battery"> '.$batPercent.'% '.$vin.'V</i></div>';
                        }else if($_SESSION['md_edicao_hw'] == 2){
                            echo '<div class="card-header"><i style="color: #0D0;" class="icon-battery"> '.$batPercent.'% '.$vin.'V</i></div>';
                        }
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title"><i style="color: #000;" class="icon-thermometer"></i> '.$casas['canal_1'].'</h5>';
                        echo '<h5 class="card-title"><i style="color: #000;" class="icon-drop"></i> '.$casas['canal_2'].'</h5>';
                        echo '</div>';
                        echo '<div class="card-footer text-muted">';
                        echo '</div>';
                    }
                }
                
                
                echo '</div>';
                $count++;
            }
            if ($count % 6 != 0) {
                echo '</div>'; // Fecha a última div se não for múltiplo de 3
            }
        }


    }
    $sql_casa = "SELECT * FROM tb_dispositivo where modelo_dispositivo != 'Higrometro_1_0' AND cd_casa_dispositivo = ".$_SESSION['cd_casa']." ";
    $resulta_casa = $conn->query($sql_casa);
    if ($resulta_casa->num_rows > 0) {
        while ($casas = $resulta_casa->fetch_assoc()) {
            if ($count % 3 == 0) {
                if ($count > 0) {
                    echo '</div>'; // Fecha a div anterior, exceto na primeira iteração
                }
                echo '<div class="card-deck justify-content-center">';
            }
            if (isset($casas['dt_status_dispositivo'])) {
                $dataStatus = strtotime($casas['dt_status_dispositivo']);
                $dataAtual = time();
                if (($dataAtual - $dataStatus) > 10) {
                    // A data e hora são maiores que 30 segundos
                    echo '<div class="card text-white border-danger mb-3 shadow-lg bg-secondary align-items-center" style="margin: 10px; max-width: 18rem;">';
                    if($_SESSION['md_edicao_hw'] == 0){
                        echo '<div class="card-header bg-danger">Offline';
                    }else if($_SESSION['md_edicao_hw'] == 1){
                        echo '<div class="card-header bg-danger">Offline';
                    }else if($_SESSION['md_edicao_hw'] == 2){
                        echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/edit_dispositivo.php">';
                        echo '<input type="text" value="'.$casas['cd_dispositivo'].'" id="concd_dispositivo" name="concd_dispositivo" style="display:none;">';
                        echo '<div class="card-header bg-danger"><input class="btn btn-block btn-danger" type="submit" value="Offline"></div>'; 
                        echo '</form>';
                    }
                } else {
                    // A data e hora não são maiores que 30 segundos
                    echo '<div class="card text-white border-success mb-3 shadow-lg bg-secondary mb-3 align-items-center" style="margin: 10px; max-width: 18rem;">';
                    if($_SESSION['md_edicao_hw'] == 0){
                        echo '<div class="card-header bg-success">Online <i class="icon-ellipsis"></i></div>';
                    }else if($_SESSION['md_edicao_hw'] == 1){
                        echo '<div class="card-header bg-success">Online <i class="icon-ellipsis"></i></div>';
                    }else if($_SESSION['md_edicao_hw'] == 2){
                        echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/edit_dispositivo.php">';
                        echo '<input type="text" value="'.$casas['cd_dispositivo'].'" id="concd_dispositivo" name="concd_dispositivo" style="display:none;">';
                        echo '<div class="card-header bg-success"><input class="btn btn-block btn-success" type="submit" value="Online"></div>'; 
                        echo '</form>';
                        //echo '<div class="card-header bg-success"><a href="'.$_SESSION['dominio'].'/pages/md_dispositivo/edit_dispositivo.php" class="btn btn-block btn-success">Online&nbsp<i class="icon-ellipsis"></i></a></div>'; 
                    }
                    //echo '<td><a href="'.$_SESSION['dominio'].'/pages/dashboard/index.php" class="btn btn-block btn-outline-warning"><i class="icon-cog"></i>Voltar ao início</a></td>';
                }
                echo '<p style="text-align: center;"> ';
                for($i = 1; $i < 7; $i++){
                    if($casas['canal_'.$i] > 0){
                        if($casas['canal_'.$i] == 1){
                            echo ' <i style="color: #D00;" class="icon-circle-cross"></i> ';
                        }
                        if($casas['canal_'.$i] == 2){
                            echo ' <i style="color: #0D0;" class="icon-circle-check"></i> ';
                        }   
                    }
                }
                echo ' </p>';
            }
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'.$casas['titulo_dispositivo'].' - '.$casas['local_dispositivo'].'</h5>';
            //echo '<h5 class="card-title">'.$casas['marca_dispositivo'].' '.$casas['modelo_dispositivo'].' '.$casas['versao_dispositivo'].'</h5>';
            echo '<p class="card-title">IP - '.$casas['ip_dispositivo'].'</p>';
            echo '<p class="card-title">MAC - '.$casas['mac_dispositivo'].'</p>';
            echo '</div>';
            echo '<div class="card-footer text-muted">';
            if (($dataAtual - $dataStatus) > 10) {
                //echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/editar_dispositivo.php">';
                //echo '<form>';
                echo '<input type="text" id="concd_dispositivo" name="concd_dispositivo" value="'.$casas['cd_dispositivo'].'" style="display:none;">';
                echo '<input class="btn btn-outline-danger btn-lg btn-block" type="submit" value="Acionar suporte">';
                //echo '</form>';
            } else {
                echo '<form method="post" action="'.$_SESSION['dominio'].'/pages/md_dispositivo/view_dispositivo.php">';
                if($casas['modelo_dispositivo'] == "Higrometro_1_0"){
                    echo '<input value="'. $casas['canal_1'] .'°C" class="btn mb-3 btn-block btn-sm btn-info">';
                    echo '<input value="'. $casas['canal_2'] .'%" class="btn mb-3 btn-block btn-sm btn-info">';
                }
                echo '<input type="text" id="concd_dispositivo" name="concd_dispositivo" value="'.$casas['cd_dispositivo'].'" style="display:none;">';
                echo '<input class="btn btn-outline-success btn-lg btn-block" type="submit" value="Parametros">';
                echo '</form>';
            }
            echo '</div>';
            echo '</div>';
            $count++;
        }
        if ($count % 3 != 0) {
            echo '</div>'; // Fecha a última div se não for múltiplo de 3
        }
    }


}
    
?>
                
              
                