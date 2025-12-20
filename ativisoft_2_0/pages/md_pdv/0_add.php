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

if (!isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] = [
        'name' => $name,
        'price' => $price,
        'qty' => 1
    ];
} else {
    $_SESSION['cart'][$id]['qty']++;
}

header("Location: pdv_balcao.php");
exit;
