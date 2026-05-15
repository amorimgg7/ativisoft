<?php
        echo "<script>console.log('0_finalizar.php');</script>";

session_start(); 
    
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    $u = new Usuario;

if (empty($_SESSION['carrinho'])) {
    header('Location: pdv_balcao.php');
    exit;
}

$cd_venda = $_SESSION['cd_venda'];
$carrinho = $_SESSION['carrinho'];
$desconto = $_SESSION['desconto'] ?? 0;

$subtotal = 0;
foreach ($carrinho as $item) {
    $subtotal += $item['price'] * $item['qtd_orcamento'];
}
$total = max(0, $subtotal - $desconto);

/* AQUI você pode salvar no banco */

$_SESSION['ultima_venda'] = [
    'cd_venda' => $cd_venda,
    'itens' => $carrinho,
    'subtotal' => $subtotal,
    'desconto' => $desconto,
    'total' => $total,
    'data' => date('d/m/Y H:i:s')
];
//$update_reserva = "UPDATE tb_reserva";
$retVenda = $u->finalVenda(
    $_SESSION['cd_venda'], 
    $subtotal, 
    '', 
    0,
    $subtotal
);
if($retVenda['status'] != 'OK'){
        echo "<script>console.log(".json_encode($retVenda['list_sql'], JSON_UNESCAPED_UNICODE).");</script>";
        //echo "<script>console.table(".json_encode($retVenda['list_sql'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT).");</script>";

        echo "<script>alert('| - | - | - | (".$retVenda['status'].") | - | - | - |');</script>";
        return false;
}else{
    /* LIMPA CARRINHO */
    $_SESSION['cd_venda'] = 0;
    unset($_SESSION['carrinho'], $_SESSION['desconto']);    
}


header('Location: 0_comprovante.php');
//header('Location: 0_confirmar_impressao.php');
//echo json_encode([
//    'status' => 'OK',
//    'cd_venda' => $cd_venda
//]);



exit;
