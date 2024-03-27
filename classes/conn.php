
<?php
    $host = "localhost"; /* nome da conexão */
    $usuario = "root"; /* nome do usuario da conexãp */
    $senha = ""; /*senha do banco de dados caso exista */
    $nome = "ativisoft_"; /* nome do seu banco  */
    $conn = new mysqli($host, $usuario, $senha, $nome."".$_SESSION['cnpj_empresa']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $_SESSION['dominio'] = 'http://localhost/ativisoft/';
?>