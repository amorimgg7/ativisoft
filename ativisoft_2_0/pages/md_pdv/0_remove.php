<?php
session_start(); 
    
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    $u = new Usuario;
    
if (!isset($_POST['id'])) {
    header('Location: pdv_balcao.php');
    exit;
}

$id = $_POST['id'];

if (isset($_SESSION['carrinho'][$id])) {
    $retOrcamento = $u->remOrcamentoVenda($_SESSION['carrinho'][$id]['cd_orcamento'], $_SESSION['carrinho'][$id]['cd_venda'], $_SESSION['carrinho'][$id]['vtotal_orcamento']);
    if($retOrcamento['status'] != 'OK'){
        echo "<script>alert('| - | - | - | (".$retOrcamento['status'].") | - | - | - |');</script>";
        exit;
    }else{
        $_SESSION['falta_pagar_venda'] = $_SESSION['falta_pagar_venda']-$_SESSION['carrinho'][$id]['vtotal_orcamento'];
        echo "<script>alert('| - | - | - | (".$retOrcamento['status'].") | - | - | - |');</script>";
        unset($_SESSION['carrinho'][$id]);
    }
}

header('Location: pdv_balcao.php');
exit;
