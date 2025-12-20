<?php
session_start();

if (empty($_SESSION['cart'])) {
    header('Location: pdv_balcao.php');
    exit;
}

$cart = $_SESSION['cart'];
$desconto = $_SESSION['desconto'] ?? 0;

$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['qty'];
}
$total = max(0, $subtotal - $desconto);

/* AQUI você pode salvar no banco */

$_SESSION['ultima_venda'] = [
    'itens' => $cart,
    'subtotal' => $subtotal,
    'desconto' => $desconto,
    'total' => $total,
    'data' => date('d/m/Y H:i:s')
];

/* LIMPA CARRINHO */
unset($_SESSION['cart'], $_SESSION['desconto']);

header('Location: 0_comprovante.php');
exit;
