<?php

session_start();

$usuario_dir = "guest";

if(isset($_SESSION['google_id'])){
    $usuario_dir = $_SESSION['google_id'];
}

$dir = "temp/".$usuario_dir;

$arquivos = [];

if(is_dir($dir)){

    foreach(scandir($dir) as $f){

        if($f=="." || $f=="..") continue;

        $arquivos[] = $f;

    }

}

echo json_encode($arquivos);