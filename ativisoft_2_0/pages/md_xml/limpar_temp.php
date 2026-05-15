<?php

session_start();

$usuario_dir = "guest";

if(isset($_SESSION['google_id'])){
    $usuario_dir = $_SESSION['google_id'];
}

$dir = "temp/".$usuario_dir."/";

if(isset($_POST['arquivo'])){

    $arquivo = basename($_POST['arquivo']);

    $caminho = $dir.$arquivo;

    if(file_exists($caminho)){
        unlink($caminho);
    }

}