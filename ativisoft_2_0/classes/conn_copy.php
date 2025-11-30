<?php
  if(!isset($_SESSION['host_cliente'])){
    $_SESSION['host_cliente'] = "ass_geral.mysql.dbaas.com.br";
  }
  if(!isset($_SESSION['usuario_cliente'])){
    $_SESSION['usuario_cliente'] = "ass_geral";
  }
  if(!isset($_SESSION['senha_cliente'])){
    $_SESSION['senha_cliente'] = "GGA@20002021g";
  }
  if(!isset($_SESSION['nome_cliente'])){
    $_SESSION['nome_cliente'] = "ass_geral";
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
    $_SESSION['dominio'] = 'https://sistema.ativisoft.com.br/';

    date_default_timezone_set('America/Sao_Paulo');
    header('Content-Type: text/html; charset=UTF-8'); 

?>