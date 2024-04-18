
<?php
    $_SESSION['cnpj_revenda'] = 123;
    $host = "sv65.ifastnet14.org"; /* nome da conexão */
    $usuario = "assistent"; /* nome do usuario da conexãp */
    $senha = "p)0s5C[a3R8IEr"; /*senha do banco de dados caso exista */
    $nome = "assistent_"; /* nome do seu banco  */
    //$conn_base = new mysqli($host, $usuario, $senha, $nome."");
    $conn_revenda = new mysqli($host, $usuario, $senha, $nome."".$_SESSION['cnpj_revenda']);
   
    if ($conn_revenda->connect_error) {
        die("Connection failed: " . $conn_revenda->connect_error);
    }
    $_SESSION['dominio_revenda'] = 'http://localhost/ativisoft_1_0/';
?>