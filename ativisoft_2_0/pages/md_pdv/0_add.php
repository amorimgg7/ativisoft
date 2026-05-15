<?php
session_start(); 
    
    require_once '../../classes/conn.php';
    include("../../classes/functions.php");
    $u = new Usuario;

if (!$u->retPermissaoBool('813')) {
    die('Acesso negado');
}

$id    = $_POST['id'];
$name  = $_POST['name'];
$price = floatval($_POST['price']);


if(!isset($_SESSION['cd_venda']) || $_SESSION['cd_venda'] == 0){
    $retVenda = $u->inicioVenda($_SESSION['cd_cliente_venda'], $_SESSION['cd_empresa'], $_SESSION['cd_filial'], $_SESSION['cd_pessoa']);
    $_SESSION['cd_venda'] = $retVenda['cd_venda'];
    //$_SESSION['cd_venda_seq_1'] = $retVenda['cd_venda_seq_1'];
    //$_SESSION['vpag_venda'] = $retVenda['vpag_venda'];
    //$_SESSION['orcamento_venda'] = $retVenda['orcamento_venda'];

    echo '<script>console.log("'.$_SESSION['cd_venda'].'");</script>';
}else{
    echo '<script>console.log("'.$_SESSION['cd_venda'].'");</script>';
}



if (!isset($_SESSION['carrinho'][$id])) {
    $retOrcamento = $u->addOrcamentoVenda(
        $_SESSION['cd_empresa'],
        $_SESSION['cd_filial'],
        $_SESSION['cd_cliente_venda'], 
        $_SESSION['cd_venda'], 
        $id,
        $name, 
        number_format($price, 2, '.', '.'),
        1,
        '', 
        0, 
        number_format($price, 2, '.', '.'),);
    if($retOrcamento['status'] != 'OK'){
        echo "<script>alert('| - | - | - | (".$retOrcamento['status'].") | - | - | - |');</script>";
        return false;
    }else
    $_SESSION['carrinho'][$id] = [
        'cd_orcamento' => $retOrcamento['cd_orcamento'],
        'cd_venda' => $_SESSION['cd_venda'],
        'cd_produto' => $id,
        'name' => $name,
        'price' => $price,
        'tipo_desconto' => $tipo_desconto,
        'desconto_orcamento' => $desconto_orcamento,
        'qtd_orcamento' => 1,
        'vtotal_orcamento' => $price
    ];
} else {
    $_SESSION['carrinho'][$id]['qtd_orcamento']++;
    $_SESSION['carrinho'][$id]['vtotal_orcamento'] = number_format($_SESSION['carrinho'][$id]['price'], 2, '.', '.')*$_SESSION['carrinho'][$id]['qtd_orcamento'];

    $retOrcamento = $u->editOrcamentoVenda(
        $_SESSION['carrinho'][$id]['cd_orcamento'],
        $_SESSION['carrinho'][$id]['cd_venda'],
        $_SESSION['carrinho'][$id]['qtd_orcamento'],
        number_format($_SESSION['carrinho'][$id]['price'], 2, '.', '.'),
        $_SESSION['carrinho'][$id]['tipo_desconto'],
        number_format($_SESSION['carrinho'][$id]['desconto_orcamento'], 2, '.', '.'),
        number_format($_SESSION['carrinho'][$id]['vtotal_orcamento'], 2, '.', '.')
    );
    echo "<script>alert('| - | - | - | (".$retOrcamento['status'].") | - | - | - |');</script>";

    //return false;
    
}

header("Location: pdv_balcao.php");
exit;
