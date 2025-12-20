<?php
session_start();

if (!isset($_SESSION['cd_colab'])) {
    header("location: ../../pages/samples/login.php");
    exit;
}

require_once '../../classes/conn.php';
require_once '../../classes/functions.php';

$u = new Usuario();

/* ===== DADOS ===== */
$data       = $u->conProdServ($_SESSION['cd_empresa']);
$products   = $data['products']   ?? [];
$categories = $data['categories'] ?? [];

/* ===== CARRINHO ===== */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* ===== PERMISSÕES ===== */
$permAddProduto = $u->retPermissaoBool('301');
$permDesconto   = $u->retPermissaoBool('302');
$permRemover    = $u->retPermissaoBool('304');

/* ===== TOTAIS ===== */
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['qty'];
}
$desconto = $permDesconto ? ($_SESSION['desconto'] ?? 0) : 0;
$total    = max(0, $subtotal - $desconto);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>PDV Balcão</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<style>
body { background:#f5f7fb; }
.section { display:none; }
.section.active { display:block; }

.product-card {
    cursor:pointer;
    border-radius:12px;
    transition:transform .1s;
}
.product-card:active { transform:scale(.97); }

.bloqueado {
    opacity:.5;
    cursor:not-allowed;
}
</style>
</head>

<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar fixed-top bg-light border-bottom">
<div class="container-fluid">
    <span class="navbar-brand fw-bold">PDV - Ativisoft</span>

    <div class="d-flex gap-2">
        <button class="btn btn-info top-btn" id="btn-principal" onclick="showSection('principal')">
            <i class="bi bi-shop"></i>
        </button>
        <button class="btn btn-info top-btn" id="btn-historico" onclick="showSection('historico')">
            <i class="bi bi-clock-history"></i>
        </button>
        <button class="btn btn-info top-btn" id="btn-configuracoes" onclick="showSection('configuracoes')">
            <i class="bi bi-gear"></i>
        </button>
        <button class="btn btn-danger" onclick="location.href='../../pages/dashboard/index.php'">
            <i class="bi bi-x-octagon"></i>
        </button>
    </div>
</div>
</nav>

<div style="height:70px"></div>

<div class="container-fluid">

<!-- ================= SECTION PRINCIPAL ================= -->
<section id="principal" class="section active">

<div class="row">

<!-- ===== GRUPOS ===== -->
<div class="col-md-2">
<h6>Grupos</h6>

<ul class="list-group">

<li class="list-group-item list-group-item-action active"
    onclick="filtrarGrupo('all')">
    Todos
</li>

<?php
if (is_array($categories) && count($categories)) {
    foreach ($categories as $key => $cat) {

        // SE FOR ARRAY (CORRETO)
        if (is_array($cat)) {
            $id   = $cat['id']   ?? '';
            $name = $cat['name'] ?? '';
        }
        // SE FOR STRING (SEU CASO ATUAL)
        else {
            $id   = md5($cat); // gera ID estável
            $name = $cat;
        }

        if (!$name) continue;
        ?>
        <li class="list-group-item list-group-item-action"
            onclick="filtrarGrupo('<?= $id ?>')">
            <?= htmlspecialchars($name) ?>
        </li>
        <?php
    }
} else {
    echo '<li class="list-group-item text-muted">Nenhum grupo</li>';
}
?>

</ul>
</div>


<!-- ===== PRODUTOS ===== -->
<div class="col-md-7">
<div class="row">

<?php foreach ($products as $p): ?>
<div class="col-md-4 mb-3 product-wrapper">
<div class="card product-card"
     data-category-id="<?= md5($p['category']) ?>">


<div class="card-body">
    <h6><?= htmlspecialchars($p['name']) ?></h6>
    <small class="text-muted"><?= htmlspecialchars($p['category']) ?></small>
    <p class="fw-bold">R$ <?= number_format($p['price'],2,',','.') ?></p>

    <?php if ($permAddProduto): ?>
        <form method="post" action="0_add.php">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <input type="hidden" name="name" value="<?= htmlspecialchars($p['name']) ?>">
            <input type="hidden" name="price" value="<?= $p['price'] ?>">
            <button class="btn btn-sm btn-primary w-100">Adicionar</button>
        </form>
    <?php else: ?>
        <button class="btn btn-sm btn-danger w-100" disabled>Sem permissão</button>
    <?php endif; ?>

</div>
</div>
</div>
<?php endforeach; ?>

</div>
</div>

<!-- ===== CARRINHO ===== -->
<div class="col-md-3">
<div class="card">
<div class="card-body">

<h5>Carrinho</h5>

<?php if (empty($_SESSION['cart'])): ?>
<p class="text-muted">Carrinho vazio</p>
<?php else: ?>
<table class="table table-sm">
<thead>
<tr>
    <th>Item</th>
    <th>Qtd</th>
    <th>Total</th>
    <th></th>
</tr>
</thead>
<tbody>
<?php foreach ($_SESSION['cart'] as $id => $item): ?>
<tr>
    <td><?= htmlspecialchars($item['name']) ?></td>
    <td><?= $item['qty'] ?></td>
    <td>R$ <?= number_format($item['price'] * $item['qty'], 2, ',', '.') ?></td>
    <td class="text-end">
        <?php if ($permRemover): ?>
            <form method="post" action="0_remove.php" onsubmit="return confirm('Cancelar este item?');">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button class="btn btn-sm btn-danger">
                    <i class="bi bi-x-lg"></i>
                </button>
            </form>
        <?php else: ?>
            <button class="btn btn-sm btn-secondary" disabled>
                <i class="bi bi-lock"></i>
            </button>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php endif; ?>

<hr>
<p>Subtotal: <strong>R$ <?= number_format($subtotal,2,',','.') ?></strong></p>

<form method="post" action="0_desconto.php">
<label>Desconto</label>
<input type="number" step="0.01" name="desconto"
       class="form-control"
       value="<?= $desconto ?>"
       <?= !$permDesconto ? 'readonly' : '' ?>>
<?php if ($permDesconto): ?>
<button class="btn btn-secondary btn-sm w-100 mt-1">Aplicar</button>
<?php endif; ?>
</form>

<hr>
<p>Total: <strong>R$ <?= number_format($total,2,',','.') ?></strong></p>

<form method="post" action="0_finalizar.php">
<button class="btn btn-success w-100"
<?= empty($_SESSION['cart']) ? 'disabled' : '' ?>>
Finalizar Venda
</button>
</form>

</div>
</div>
</div>

</div>
</section>

<!-- ================= SECTION HISTÓRICO ================= -->
<section id="historico" class="section">
    <h2>Histórico de vendas</h2>

    <!-- ===== FILTRO ===== -->
    <form id="filtroHistorico" class="row g-2 mb-3">
        <div class="col-auto">
            <label for="data_inicio" class="form-label">Data Início:</label>
            <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?= date('Y-m-d') ?>">
        </div>

        <div class="col-auto">
            <label for="data_fim" class="form-label">Data Fim:</label>
            <input type="date" id="data_fim" name="data_fim" class="form-control" value="<?= date('Y-m-d') ?>">
        </div>

        <div class="col-auto align-self-end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <!-- ===== RESULTADOS ===== -->
    <div id="historicoResultados">
        <!-- Histórico carregado via AJAX aparecerá aqui -->
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('filtroHistorico');
    const resultado = document.getElementById('historicoResultados');

    function carregarHistorico() {
        const dataInicio = document.getElementById('data_inicio').value;
        const dataFim    = document.getElementById('data_fim').value;

        resultado.innerHTML = '<p class="text-muted">Carregando...</p>';

        fetch(`historico_ajax.php?data_inicio=${dataInicio}&data_fim=${dataFim}`)
            .then(resp => resp.text())
            .then(html => {
                resultado.innerHTML = html;
            })
            .catch(() => {
                resultado.innerHTML = '<p class="text-danger">Erro ao carregar histórico</p>';
            });
    }

    form.addEventListener('submit', function(e){
        e.preventDefault();
        carregarHistorico();
    });

    // Carrega histórico ao abrir a página
    carregarHistorico();
});
</script>


<!-- ================= SECTION CONFIGURAÇÕES ================= -->
<section id="configuracoes" class="section">
<h3>Configurações</h3>
<p class="text-muted">Em desenvolvimento</p>
</section>

</div>

<script>
function showSection(id){
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(id).classList.add('active');
}

function filtrarGrupo(id){
    document.querySelectorAll('.product-wrapper').forEach(col=>{
        const card = col.querySelector('.product-card');
        if(id === 'all' || card.dataset.categoryId === id){
            col.style.display = '';
        } else {
            col.style.display = 'none';
        }
    });
}
</script>

</body>
</html>
