<?php
    session_start();
    require_once 'classes/conn.php';
    
    if(isset($_SESSION['cd_pessoa']))
    {
        //header("location: http://amorimgg77.lovestoblog.com/pages/samples/login.php");
        //echo '<script>location.href="'.$_SESSION['dominio'].'pages/samples/login.php";</script>';
        echo '<script>location.href="'.$_SESSION['dominio'].'/pages/dashboard/index.php";</script>';   
        //echo '<script>location.href="'.$_SESSION['dominio'].'pages/samples/login.php";</script>';    
        //exit;
    }else{
        echo '<script>location.href="'.$_SESSION['dominio'].'/pages/samples/login.php";</script>';    
        //exit;
    }
    //require_once 'classes/conn.php';
    
    //include("classes/functions.php");
    //conectar($_SESSION['cnpj_empresa']);

    //$u = new Usuario;
    
    
?><!--Validar sessão aberta, se usuário está logado.-->
