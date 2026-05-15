
<?php 
    session_start();  
    require_once '../../classes/conn.php';
?>
<?php
    function getParameterByName($name, $url = null) {
        if ($url === null) {
            $url = $_SERVER['REQUEST_URI'];
        }

        $name = preg_quote($name, '/');
        if (preg_match("/[?&]$name=([^&]+)/", $url, $matches)) {
            return urldecode($matches[1]);
        } else {
            return null;
        }
    }
    //session_start();
    $casa       = getParameterByName('casa');
    $mac        = getParameterByName('mac');
    $ip         = getParameterByName('ip');
    $mascara    = getParameterByName('mascara');
    $gateway    = getParameterByName('gateway');
    $marca      = getParameterByName('marca');
    $modelo     = getParameterByName('modelo');
    $versao     = getParameterByName('versao');
    $titulo     = getParameterByName('titulo');
    $local      = getParameterByName('local');
    $status     = getParameterByName('status');
    $canal_1 = getParameterByName('canal_1');
    $canal_2 = getParameterByName('canal_2');
    $canal_3 = getParameterByName('canal_3');
    $canal_4 = getParameterByName('canal_4');
    $canal_5 = getParameterByName('canal_5');
    $canal_6 = getParameterByName('canal_6');
    $canal_7 = getParameterByName('canal_7');
    $canal_8 = getParameterByName('canal_8');
    if (isset($canal_1)) {
        //echo ' <p>Canal 1: '.$canal_1.'</p> ';
    }else{
        $canal_1 = 0;
    }
    if (isset($canal_2)) {
        //echo ' <p>Canal 2: '.$canal_2.'</p> ';
    }else{
        $canal_2 = 0;
    }
    if (isset($canal_3)) {
        //echo ' <p>Canal 3: '.$canal_3.'</p> ';
    }else{
        $canal_3 = 0;
    }
    if (isset($canal_4)) {
        //echo ' <p>Canal 4: '.$canal_4.'</p> ';
    }else{
        $canal_4 = 0;
    }
    if (isset($canal_5)) {
        //echo ' <p>Canal 5: '.$canal_5.'</p> ';
    }else{
        $canal_5 = 0;
    }
    if (isset($canal_6)) {
        //echo ' <p>Canal 6: '.$canal_6.'</p> ';
    }else{
        $canal_6 = 0;
    }
    if (isset($canal_7)) {
        //echo ' <p>Canal 7: '.$canal_7.'</p> ';
    }else{
        $canal_7 = 0;
    }
    if (isset($canal_8)) {
        //echo ' <p>Canal 8: '.$canal_8.'</p> ';
    }else{
        $canal_8 = 0;
    }
    //date_default_timezone_set('America/Sao_Paulo');
    $data_hora = date("Y-m-d H:i:s");
    if($conn) {
        if($mac > 0){
            $sql_dispositivo = "SELECT * FROM tb_dispositivo WHERE mac_dispositivo = '".$mac."'";
            $result_dispositivo = mysqli_query($conn, $sql_dispositivo);
            $row_dispositivo = mysqli_fetch_assoc($result_dispositivo);
            if($row_dispositivo) {
                $alterado = 0;
                $_SESSION['mac_dispositivo'] = $row_dispositivo['mac_dispositivo'];
                if($row_dispositivo['canal_1'] != $canal_1){
                        $update = "UPDATE tb_dispositivo SET 
                        dt_status_dispositivo   =   '".$data_hora."',
                        status_dispositivo      =   'Manual',
                        canal_1                 =   '".$canal_1."'
                    WHERE mac_dispositivo       =   '".$mac."'";
                    if(mysqli_query($conn, $update)){                    
                        echo ' <p>canal_1 editado</p> ';
                        $alterado = 1;
                    }
                }
                if($row_dispositivo['canal_2'] != $canal_2){
                    $update = "UPDATE tb_dispositivo SET 
                        dt_status_dispositivo   =   '".$data_hora."',
                        status_dispositivo      =   'Manual',
                        canal_2                 =   '".$canal_2."'
                    WHERE mac_dispositivo       =   '".$mac."'";
                    if(mysqli_query($conn, $update)){                    
                        echo ' <p>canal_2 editado</p> ';
                        $alterado = 1;
                    }
                    
                    
                }

                if($row_dispositivo['canal_8'] != $canal_8){
                    $update = "UPDATE tb_dispositivo SET 
                        dt_status_dispositivo   =   '".$data_hora."',
                        status_dispositivo      =   'Manual',
                        canal_8                 =   '".$canal_8."'
                    WHERE mac_dispositivo       =   '".$mac."'";
                    if(mysqli_query($conn, $update)){                    
                        echo ' <p>canal_2 editado</p> ';
                        $alterado = 1;
                    }
                    
                    
                }


                if($alterado == 0){
                    $update = "UPDATE tb_dispositivo SET 
                        dt_status_dispositivo   = '".$data_hora."',
                        ip_dispositivo          = '".$ip."',
                        mascara_dispositivo     = '".$mascara."',
                        gateway_dispositivo     = '".$gateway."'
                    WHERE mac_dispositivo   = '".$mac."'";
                    if(mysqli_query($conn, $update)){                    
                        echo ' <p>OnLine</p> ';
                        $alterado = 1;
                    }
                }else{
                    if($row_dispositivo['modelo_dispositivo'] = "Higrometro_1_0"){
/*
                        $valor_referencia = 1.0;
                        if ((abs($canal_2 - $valor_referencia) < 0.5) || (abs($canal_2 - $valor_referencia) < 0.5)) {
                            echo $canal_2.' - '.$valor_referencia.'<p>maior ou menor que 0,5</p>';
                        }
*/
                        $insert_clima_tempo = "INSERT INTO clima_tempo (dt_clima_tempo, mac_dispositivo_clima_tempo, temperatura_clima_tempo, umidade_clima_tempo) VALUES(
                        '".$data_hora."',
                        '".$mac."',
                        '".$canal_1."',
                        '".$canal_2."'
                        )";
                        if(mysqli_query($conn, $insert_clima_tempo)){
                            echo ' <p>Inserindo Temperatura e Umidade</p> ';
                        }
                    }
                }
                
            }else{

                $insert = "INSERT INTO tb_dispositivo(
                    cd_casa_dispositivo, 
                    mac_dispositivo, 
                    ip_dispositivo, 
                    mascara_dispositivo, 
                    gateway_dispositivo, 
                    marca_dispositivo, 
                    modelo_dispositivo, 
                    versao_dispositivo, 
                    titulo_dispositivo, 
                    local_dispositivo, 
                    status_dispositivo, 
                    dt_status_dispositivo, 
                    canal_1, 
                    canal_2, 
                    canal_3, 
                    canal_4, 
                    canal_5, 
                    canal_6, 
                    canal_7, 
                    canal_8
                ) VALUES(
                    '".$casa."',
                    '".$mac."',
                    '".$ip."',     
                    '".$mascara."',
                    '".$gateway."',
                    '".$marca."',
                    '".$modelo."',
                    '".$versao."',
                    '".$titulo."',
                    '".$local."',
                    'Ativo',
                    '".$data_hora."',
                    '".$canal_1."',
                    '".$canal_2."',
                    '".$canal_3."',
                    '".$canal_4."',
                    '".$canal_5."',
                    '".$canal_6."',
                    '".$canal_7."',
                    '".$canal_8."'
                )";
                if(mysqli_query($conn, $insert)){
                    echo ' <p>Dispositivo Cadastrado com sucesso!</p> ';
                }
            }
        }else{
            echo ' <p>Mac não informado</p> ';
        }
        
    }else{
        echo ' <p>Sem conexão com o banco de dados!</p> ';
    }

?>