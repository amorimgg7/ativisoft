<?php
session_start();

if (!isset($_SESSION['ultima_venda'])) {
    header('Location: pdv_balcao.php');
    exit;
}

$venda = $_SESSION['ultima_venda'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Comprovante</title>
<style>
body { font-family: monospace; }
@media print {
    button { display:none; }
}
</style>
</head>
<body>

<h3>*** COMPROVANTE ***</h3>
<p>Data: <?= $venda['data'] ?></p>

<hr>

<?php foreach ($venda['itens'] as $item): ?>
<?= $item['qtd_orcamento_venda'] ?>x <?= $item['name'] ?>  
R$ <?= number_format($item['price'] * $item['qtd_orcamento_venda'],2,',','.') ?><br>
<?php endforeach; ?>

<hr>
Subtotal: R$ <?= number_format($venda['subtotal'],2,',','.') ?><br>
Desconto: R$ <?= number_format($venda['desconto'],2,',','.') ?><br>
<strong>Total: R$ <?= number_format($venda['total'],2,',','.') ?></strong>

<hr>

<button onclick="window.print()">Imprimir</button>
<button onclick="location.href='pdv_balcao.php'">Nova Venda</button>

</body>
</html>
