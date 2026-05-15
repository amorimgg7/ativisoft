<?php
session_start(); 
    
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    $u = new Usuario;

if (!$u->retPermissaoBool('813')) {
    die('Acesso negado');
}



if (isset($_POST['cancelar_venda']) && isset($_POST['cd_venda'])) {

    $cd_venda = (int) $_POST['cd_venda'];

    $update_venda = "
        UPDATE tb_venda
        SET status_venda = 'C', dt_cancelamento = now()
        WHERE cd_venda = $cd_venda
          AND status_venda = 'F'
    ";

    $update_movimento_financeiro = "
        UPDATE tb_movimento_financeiro
        SET status_movimento = 'C', dt_cancelamento = now()
        WHERE cd_venda_movimento = $cd_venda
    ";

    if (mysqli_query($conn, $update_venda) && mysqli_query($conn, $update_movimento_financeiro)) {

        // Limpa sessão da venda
        unset($_SESSION['cd_venda']);
        unset($_SESSION['cd_venda_seq_1']);
        unset($_SESSION['vpag_venda']);
        unset($_SESSION['orcamento_venda']);
        unset($_SESSION['carrinho']);

        header("Location: pdv_balcao.php");
        exit;
    } else {
        die('Erro ao cancelar venda');
    }
}




