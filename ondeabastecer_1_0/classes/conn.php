<?php
    $host = "ass_astecer.mysql.dbaas.com.br"; /* nome da conexão */
    $usuario = "ass_astecer"; /* nome do usuario da conexãp */
    $senha = "GGA@20002021g"; /*senha do banco de dados caso exista */
    $nome = "ass_astecer"; /* nome do seu banco  */
    //echo "<br> HOST - ".$host."<br> USUARIO - ".$usuario."<br> SENHA - ".$senha."<br> NOME - ".$nome;
    $conn = new mysqli($host, $usuario, $senha, $nome);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $_SESSION['dominio'] = 'https://ondeabastecer.ativisoft.com.br/';

    date_default_timezone_set('America/Sao_Paulo');
?>