<?php
    $host = "localhost"; /* nome da conexão */
    $usuario = "root"; /* nome do usuario da conexãp */
    $senha = ""; /*senha do banco de dados caso exista */
    $nome = "assistent_master"; /* nome do seu banco  */
    //echo "<br> HOST - ".$host."<br> USUARIO - ".$usuario."<br> SENHA - ".$senha."<br> NOME - ".$nome;
    $conn = new mysqli($host, $usuario, $senha, $nome);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $_SESSION['dominio'] = 'http://localhost/ativisoft_2_0/';

    date_default_timezone_set('America/Sao_Paulo');

?>