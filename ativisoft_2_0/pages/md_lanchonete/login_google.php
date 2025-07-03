<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email'])) {
    session_start();
    $id_google = $data['id'];
    $email_colab = $data['email'];
    $_SESSION['user_name'] = $data['name'];
    $_SESSION['user_picture'] = $data['picture'];

    // Salvar no banco de dados (se necessário)
    require_once '../../classes/functions.php';
    $u = new Usuario;

    if ($email_colab && $id_google) {
        $u->conectar();
        if ($msgErro == "")
        {
            // Tente realizar o login do colaborador
            if ($u->logar($email_colab, '', 'colab', $id_google, '')) {
                //echo '<script>window.location.href = "../../session_open.php";</script>'; // Redireciona após login
                //echo '<script>window.location.href = "../dashboard/index.php";</script>'; // Redireciona após login
                echo json_encode(["success" => true, "message" => "Login realizado com sucesso"]);
                exit();
                //return true;
            } else {
                //echo json_encode(["success" => false, "message" => "Erro ao realizar login"]);
                return false;
                //exit();
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Campos obrigatórios não preenchidos"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Erro ao autenticar"]);
}
?>
