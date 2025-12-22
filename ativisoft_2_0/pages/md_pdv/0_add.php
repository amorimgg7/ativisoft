<?php
session_start();
include("../../classes/functions.php");

$u = new Usuario;

if (!$u->retPermissaoBool('301')) {
    die('Acesso negado');
}

$id    = $_POST['id'];
$name  = $_POST['name'];
$price = floatval($_POST['price']);

/*
if(!isset($venda['cd_venda']) || $venda['cd_venda'] = '0'){
    $retVenda = $u->cadVenda(1, $_SESSION['cd_colab'], $_SESSION['cd_filial']);
    $_SESSION['cd_venda'] = $retVenda['cd_venda'];
}else{
    echo '<script>console.log("'.$_SESSION['cd_venda'].'");</script>';
}
*/

if (!isset($_SESSION['carrinho'][$id])) {
    $_SESSION['carrinho'][$id] = [
        'cd_orcamento' => $cd_orcamento,
        'cd_venda' => $cd_venda,
        'cd_produto' => $id,
        'name' => $name,
        'price' => $price,
        'tipo_desconto_orcamento' => $tipo_desconto_orcamento,
        'desconto_orcamento' => $desconto_orcamento,
        'qtd_orcamento_venda' => 1,
        'vtotal_orcamento' => $vtotal_orcamento
    ];
} else {
    $_SESSION['carrinho'][$id]['qtd_orcamento_venda']++;
}

header("Location: pdv_balcao.php");
exit;
