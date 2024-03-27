
<?php
    $host = "sv65.ifastnet14.org"; /* nome da conex���o */
    $usuario = "assistent"; /* nome do usuario da conex���p */
    $senha = "p)0s5C[a3R8IEr"; /*senha do banco de dados caso exista */
    $nome = "assistent_"; /* nome do seu banco  */
    $conn = new mysqli($host, $usuario, $senha, $nome."".$_SESSION['cnpj_empresa']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $_SESSION['dominio'] = 'https://ativisoft.com.br/';
?>
