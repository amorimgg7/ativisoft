
<?php
    $host = "localhost"; /* nome da conexão */
    $usuario = "if0_34596309"; /* nome do usuario da conexãp */
    $senha = "JA4bWXhxx4L"; /*senha do banco de dados caso exista */
    $nome = "if0_34596309_"; /* nome do seu banco  */
    //$cnpj_empresa = 37719768000120;
    //$nome = "if0_34596309_services"; /* nome do seu banco  */
//    // Create connection
    $conn = new mysqli($host, $usuario, $senha, $nome."".$_SESSION['cnpj_empresa']);
    //$conn = new mysqli($host, $usuario, $senha, $nome);
//    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $_SESSION['dominio'] = 'http://assistent.lovestoblog.com/';
//    //https://erp-nuvemsoft.com.br/
//?>

<?php
//    $host = "localhost"; /* nome da conexão */
//    $usuario = "root"; /* nome do usuario da conexãp */
//    $senha = ""; /*senha do banco de dados caso exista */
//    $nome = "erp_"; /* nome do seu banco  */
//    //$cnpj_empresa = 37719768000120;
//    //$nome = "if0_34596309_services"; /* nome do seu banco  */
////    // Create connection
//    $conn = new mysqli($host, $usuario, $senha, $nome."".$_SESSION['cnpj_empresa']);
//    //$conn = new mysqli($host, $usuario, $senha, $nome);
//    // Check connection
//    if ($conn->connect_error) {
//        die("Connection failed: " . $conn->connect_error);
//    }
//    $_SESSION['dominio'] = 'http://localhost/_1_0_assistent/';
//    //https://erp-nuvemsoft.com.br/
?>