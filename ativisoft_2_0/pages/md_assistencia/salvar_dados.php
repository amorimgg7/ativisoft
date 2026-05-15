<?php
// Este é um exemplo básico de como salvar dados em um banco de dados MySQL.
// Lembre-se de que você deve configurar as credenciais do banco de dados corretamente.

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dados = $_POST["dados"];

    // Conecte-se ao banco de dados MySQL
    $servername = "localhost";
    $username = "seu_usuario";
    $password = "sua_senha";
    $dbname = "seu_banco_de_dados";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifique a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Crie uma tabela chamada 'pessoas' com campos 'nome' e 'idade' (execute apenas uma vez)
    // $sql = "CREATE TABLE pessoas (id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(50) NOT NULL, idade INT NOT NULL)";
    // $conn->query($sql);

    // Insira os dados na tabela
    $sql = "INSERT INTO pessoas (nome, idade) VALUES ";

    foreach (json_decode($dados, true) as $dado) {
        $nome = $conn->real_escape_string($dado["nome"]);
        $idade = $conn->real_escape_string($dado["idade"]);
        $sql .= "('$nome', $idade), ";
    }

    $sql = rtrim($sql, ", "); // Remover a última vírgula e espaço
    $conn->query($sql);

    $conn->close();

    // Envie uma resposta para o cliente
    echo "Dados salvos com sucesso no banco de dados!";
}
?>
