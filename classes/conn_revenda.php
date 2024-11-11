
<?php
    session_start();
    $_SESSION['cnpj_revenda'] = 123;
    $host = "ass_123.mysql.dbaas.com.br"; /* nome da conexão */
    $usuario = "ass_123"; /* nome do usuario da conexãp */
    $senha = "GGA@20002021g"; /*senha do banco de dados caso exista */
    $nome = "ass_".$_SESSION['cnpj_revenda']; /* nome do seu banco  */
    //$conn_base = new mysqli($host, $usuario, $senha, $nome."");
    $conn_revenda = new mysqli($host, $usuario, $senha, $nome);
   echo "Revenda: ".$_SESSION['cnpj_revenda'];
    if ($conn_revenda->connect_error) {
        die("Connection failed: " . $conn_revenda->connect_error);
    }
    $_SESSION['dominio_revenda'] = 'http://ativisoft.tecnologia.ws/';
    date_default_timezone_set('America/Sao_Paulo');
?>