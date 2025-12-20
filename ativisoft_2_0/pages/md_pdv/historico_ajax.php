<?php
session_start();
require_once '../../classes/conn.php'; // $conn = mysqli

if (!isset($conn)) {
    echo "<p class='text-danger'>Erro de conexão</p>";
    exit;
}

$cd_filial   = $_SESSION['cd_filial'] ?? 11;
$data_inicio = $_GET['data_inicio'] ?? date('Y-m-d');
$data_fim    = $_GET['data_fim']    ?? date('Y-m-d');

$data_inicio .= ' 00:00:00';
$data_fim    .= ' 23:59:59';

$sql = "
    SELECT v.cd_venda,
           v.abertura_venda,
           v.fechamento_venda,
           v.vpag_venda,
           v.orcamento_venda,
           c.pnome_pessoa AS cliente
    FROM tb_venda v
    LEFT JOIN tb_pessoa c ON v.cd_cliente = c.cd_pessoa
    WHERE v.cd_filial = ?
      AND v.abertura_venda BETWEEN ? AND ?
    ORDER BY v.abertura_venda DESC
    LIMIT 50
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $cd_filial, $data_inicio, $data_fim);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "<p class='text-muted'>Nenhuma venda registrada neste período.</p>";
    exit;
}

echo '<div class="accordion" id="historicoAccordion">';

while ($venda = $res->fetch_assoc()) {

    $cd_venda  = (int)$venda['cd_venda'];
    $cliente   = $venda['cliente'] ?: 'Consumidor Final';
    $abertura  = date('d/m/Y H:i', strtotime($venda['abertura_venda']));
    $subtotal  = number_format($venda['orcamento_venda'], 2, ',', '.');
    $total     = number_format($venda['vpag_venda'], 2, ',', '.');

    $sqlItens = "
        SELECT titulo_orcamento, qtd_orcamento, vtotal_orcamento
        FROM tb_orcamento_venda
        WHERE cd_venda = ?
    ";

    $stmtItens = $conn->prepare($sqlItens);
    $stmtItens->bind_param("i", $cd_venda);
    $stmtItens->execute();
    $resItens = $stmtItens->get_result();
    ?>
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading<?= $cd_venda ?>">
            <button class="accordion-button collapsed" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapse<?= $cd_venda ?>"
                aria-expanded="false"
                aria-controls="collapse<?= $cd_venda ?>">
                Venda #<?= $cd_venda ?> —
                <?= htmlspecialchars($cliente) ?> —
                <?= $abertura ?> —
                Total: R$ <?= $total ?>
            </button>
        </h2>

        <div id="collapse<?= $cd_venda ?>"
             class="accordion-collapse collapse"
             data-bs-parent="#historicoAccordion">

            <div class="accordion-body">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Produto / Serviço</th>
                            <th class="text-end">Qtd</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($item = $resItens->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['titulo_orcamento']) ?></td>
                            <td class="text-end"><?= $item['qtd_orcamento'] ?></td>
                            <td class="text-end">
                                <?= number_format($item['vtotal_orcamento'], 2, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

                <p class="mt-2">
                    <strong>Subtotal:</strong> R$ <?= $subtotal ?><br>
                    <strong>Total:</strong> R$ <?= $total ?>
                </p>
            </div>
        </div>
    </div>
    <?php
}

echo '</div>';
