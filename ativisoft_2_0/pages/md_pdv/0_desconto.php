<?php
session_start();
include("../../classes/functions.php");

$u = new Usuario;

if ($u->retPermissaoBool('302')) {
    $_SESSION['desconto'] = floatval($_POST['desconto']);
}

header("Location: pdv_balcao.php");
exit;
