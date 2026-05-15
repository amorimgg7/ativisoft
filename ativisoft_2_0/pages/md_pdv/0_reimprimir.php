<?php
session_start();

require_once '../../classes/conn.php';
include("../../classes/functions.php");

$u = new Usuario;


if (empty($_GET['cd_venda'])) {
    header('Location: pdv_balcao.php');
    exit;
}

$cd_venda = (int) $_GET['cd_venda'];


$result_impressao   = $u->impressao1($_SESSION['tipo_impressao'], 'PDV', $_SESSION['cd_empresa'], $cd_venda);
    echo $result_impressao['partial_impressao'];


/* ===============================
   BUSCA ITENS DA VENDA
================================= */
$sqlItens = "
    SELECT 
        o.titulo_orcamento,
        o.qtd_orcamento,
        o.vtotal_orcamento
    FROM tb_orcamento_venda o
    WHERE o.cd_venda = ?
";

$stmt = $conn->prepare($sqlItens);
$stmt->bind_param("i", $cd_venda);
$stmt->execute();
$resItens = $stmt->get_result();

if ($resItens->num_rows == 0) {
    header('Location: pdv_balcao.php');
    exit;
}

$carrinho = [];
$subtotal = 0;

while ($row = $resItens->fetch_assoc()) {

    $price = $row['vtotal_orcamento'] / $row['qtd_orcamento'];
    $subtotal += $row['vtotal_orcamento'];

    $carrinho[] = [
        'name'           => $row['titulo_orcamento'],
        'price'          => $price,
        'qtd_orcamento'  => $row['qtd_orcamento']
    ];
}

/* ===============================
   BUSCA DADOS DA VENDA
================================= */
$sqlVenda = "
    SELECT 
        abertura_venda,
        orcamento_venda
    FROM tb_venda
    WHERE cd_venda = ?
    LIMIT 1
";

$stmt = $conn->prepare($sqlVenda);
$stmt->bind_param("i", $cd_venda);
$stmt->execute();
$venda = $stmt->get_result()->fetch_assoc();

if (!$venda) {
    header('Location: pdv_balcao.php');
    exit;
}

$desconto = $venda['orcamento_venda'] ?? 0;
$total = max(0, $subtotal - $desconto);

/* ===============================
   MONTA A MESMA SESSION
================================= */
$_SESSION['ultima_venda'] = [
    'itens'     => $carrinho,
    'subtotal'  => $subtotal,
    'desconto'  => $desconto,
    'total'     => $total,
    'data'      => date('d/m/Y H:i:s', strtotime($venda['abertura_venda']))
];

/* ===============================
   REDIRECIONA PARA COMPROVANTE
================================= */
header('Location: 0_comprovante.php');
exit;
