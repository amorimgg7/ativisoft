<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['cd_colab'])) {
    echo json_encode(['success' => false, 'message' => 'Sessão expirada']);
    exit;
}

require_once '../../classes/conn.php'; // deve definir $conn como mysqli
include("../../classes/functions.php");
$u = new Usuario;

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Nenhum dado recebido']);
    exit;
}

// Salva carrinho na sessão
$_SESSION['carrinho'] = $data['items'];

// Dados da venda
$cd_filial  = $_SESSION['cd_filial'] ?? null;
$cd_cliente = $_SESSION['cd_cliente'] ?? null;

$abertura   = date('Y-m-d H:i:s');
$fechamento = $abertura;
$status     = '1';

// 1) Inserir venda usando mysqli
$sqlVenda = "INSERT INTO tb_venda 
    (cd_filial, cd_cliente, abertura_venda, fechamento_venda, orcamento_venda, vpag_venda, status_venda)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sqlVenda);
$stmt->bind_param(
    "iissdds",
    $cd_filial,
    $cd_cliente,
    $abertura,
    $fechamento,
    $data['subtotal'],
    $data['total'],
    $status
);
$stmt->execute();

$cd_venda = $conn->insert_id; // pega o último ID inserido no mysqli

// 2) Inserir itens
$sqlItem = "INSERT INTO tb_orcamento_venda 
    (cd_filial, cd_venda, cd_cliente, cd_produto, titulo_orcamento, vcusto_orcamento, qtd_orcamento, vtotal_orcamento, tipo_orcamento, status_orcamento)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmtItem = $conn->prepare($sqlItem);

foreach ($data['items'] as $item) {
    $tipo = 'VENDA';
    $statusItem = 1;
    $vtotal = $item['price'] * $item['qtd'];

    $stmtItem->bind_param(
        "iiissdidsi",
        $cd_filial,
        $cd_venda,
        $cd_cliente,
        $item['id'],
        $item['name'],
        $item['price'],
        $item['qtd'],
        $vtotal,
        $tipo,
        $statusItem
    );
    $stmtItem->execute();
}

echo json_encode([
    'success' => true,
    'message' => 'Venda registrada com sucesso',
    'cd_venda' => $cd_venda
]);
