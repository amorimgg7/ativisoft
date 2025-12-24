<?php
session_start(); 
    
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    $u = new Usuario;

if (!$u->retPermissaoBool('301')) {
    die('Acesso negado');
}

$id    = $_POST['id'];
$name  = $_POST['name'];
$price = floatval($_POST['price']);


if(!isset($_SESSION['cd_venda']) || $_SESSION['cd_venda'] == 0){
    $retVenda = $u->inicioVenda(1, $_SESSION['cd_filial'], $_SESSION['cd_pessoa']);
    $_SESSION['cd_venda'] = $retVenda['cd_venda'];
    echo '<script>console.log("'.$_SESSION['cd_venda'].'");</script>';
}else{
    echo '<script>console.log("'.$_SESSION['cd_venda'].'");</script>';
}



if (!isset($_SESSION['carrinho'][$id])) {
    $retOrcamento = $u->addOrcamentoVenda(
        $_SESSION['cd_filial'], 
        $_SESSION['cd_venda'], 
        $id, 
        $name, 
        $price,
        1,
        '', 
        0, 
        $price);
    if($retOrcamento['status'] != 'OK'){
        echo "<script>alert('| - | - | - | (".$retOrcamento['status'].") | - | - | - |');</script>";
        return false;
    }
    $_SESSION['carrinho'][$id] = [
        'cd_orcamento' => $retOrcamento['cd_orcamento'],
        'cd_venda' => $_SESSION['cd_venda'],
        'cd_produto' => $id,
        'name' => $name,
        'price' => $price,
        'tipo_desconto' => $tipo_desconto,
        'desconto_orcamento' => $desconto_orcamento,
        'qtd_orcamento' => 1,
        'vtotal_orcamento' => $vtotal_orcamento
    ];
} else {
    $_SESSION['carrinho'][$id]['qtd_orcamento']++;
    $_SESSION['carrinho'][$id]['vtotal_orcamento'] = $_SESSION['carrinho'][$id]['price']*$_SESSION['carrinho'][$id]['qtd_orcamento'];

    $retOrcamento = $u->editOrcamentoVenda(
        $_SESSION['carrinho'][$id]['cd_orcamento'], 
        $_SESSION['carrinho'][$id]['qtd_orcamento'],
        $_SESSION['carrinho'][$id]['price'],
        $_SESSION['carrinho'][$id]['tipo_desconto'],
        $_SESSION['carrinho'][$id]['desconto_orcamento'],
        $_SESSION['carrinho'][$id]['vtotal_orcamento']
    );
    echo "<script>alert('| - | - | - | (".$retOrcamento['status'].") | - | - | - |');</script>";

    //return false;
    
}

header("Location: pdv_balcao.php");
exit;
