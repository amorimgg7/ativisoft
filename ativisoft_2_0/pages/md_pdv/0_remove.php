<?php
session_start();

if (!isset($_POST['id'])) {
    header('Location: pdv_balcao.php');
    exit;
}

$id = $_POST['id'];

if (isset($_SESSION['carrinho'][$id])) {
    unset($_SESSION['carrinho'][$id]);
}

header('Location: pdv_balcao.php');
exit;
