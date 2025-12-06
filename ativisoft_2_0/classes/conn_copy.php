<?php
   if(!isset($_SESSION['host_cliente'])){
  $_SESSION['host_cliente'] = "localhost";
}
if(!isset($_SESSION['usuario_cliente'])){
  $_SESSION['usuario_cliente'] = "root";
}
if(!isset($_SESSION['senha_cliente'])){
  $_SESSION['senha_cliente'] = "";
}
if(!isset($_SESSION['nome_cliente'])){
  $_SESSION['nome_cliente'] = "assistent_master";
}
 

    $host = $_SESSION['host_cliente']; /* nome da conexão */
    $usuario = $_SESSION['usuario_cliente']; /* nome do usuario da conexãp */
    $senha = $_SESSION['senha_cliente']; /*senha do banco de dados caso exista */
    //$nome = "assistent_master"; /* nome do seu banco  */
    $nome = $_SESSION['nome_cliente']; /* nome do seu banco  */
    
    //echo "<br> HOST - ".$host."<br> USUARIO - ".$usuario."<br> SENHA - ".$senha."<br> NOME - ".$nome;
    $conn = new mysqli($host, $usuario, $senha, $nome);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $_SESSION['dominio'] = 'http://localhost/ativisoft_1_0/ativisoft_2_0/';

    //print_r(DateTimeZone::listIdentifiers());
    date_default_timezone_set('America/Sao_Paulo');
    header('Content-Type: text/html; charset=UTF-8'); 
?>