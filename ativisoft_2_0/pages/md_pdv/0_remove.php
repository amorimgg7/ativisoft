<?php
session_start();

if (!isset($_POST['id'])) {
    header('Location: pdv_balcao.php');
    exit;
}

$id = $_POST['id'];

if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
}

header('Location: pdv_balcao.php');
exit;
