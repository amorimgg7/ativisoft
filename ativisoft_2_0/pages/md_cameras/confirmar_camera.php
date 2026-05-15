<?php
session_start();
require_once '../../classes/conn.php';
include("../../classes/functions.php");

// Criação de objeto, se precisar
$u = new Usuario;

if(isset($_POST['rtmp'])) {
    // Protege contra SQL Injection
    $rtmp = mysqli_real_escape_string($conn, $_POST['rtmp']);
    $cd_empresa = $_SESSION['cd_empresa'];
    $cd_filial = $_SESSION['cd_filial'];

    $select_camera = "SELECT * FROM tb_cameras WHERE chave_camera = '$rtmp'";
    $result_camera = mysqli_query($conn, $select_camera);
    //$row_camera = mysqli_fetch_assoc($result_camera);
    // Exibe as informações do usuário no formulário
    if(mysqli_num_rows($result_camera) == 0) {
        // Comando de inserção
        $insert_camera = "INSERT INTO tb_cameras (chave_camera, cd_empresa, cd_filial) 
                      VALUES ('$rtmp', '$cd_empresa', '$cd_filial')";

        // Executa o insert
        if(mysqli_query($conn, $insert_camera)){
            echo "Câmera '$rtmp' inserida com sucesso!";
        } else {
            // Retorna o erro do MySQL
            echo "Erro ao inserir câmera: " . mysqli_error($conn);
        }
    }else{
        echo "Chave ja foi gerada!";
    }
} else {
    echo "Nenhuma chave enviada!";
}
?>
