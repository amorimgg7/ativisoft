<?php
session_start();

if (!isset($_SESSION['cd_colab'])) {
    header("location: ../../pages/samples/login.php");
    exit;
}

require_once '../../classes/conn.php';
require_once '../../classes/functions.php';

$u = new Usuario();

if(!isset($_SESSION['cd_venda']) || $_SESSION['cd_venda'] == 0){
  $retVenda = $u->conVenda('VA', '', $_SESSION['cd_filial']);
  

  if($retVenda['status'] != 'OK'){
    $_session['cd_venda'] = '0';
    echo "<script>alert('| - | - | - | (".$retVenda['status'].") | - | - | - |');</script>";
  }else{
    $_session['cd_venda'] = $retVenda['cd_venda'];
    $retOrcamentoVenda = $u->conOrcamentoVenda($retVenda['cd_venda']);
    
    $orcamento_venda_array = $retOrcamentoVenda['orcamento_venda_array'] ?? [];

    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    foreach ($orcamento_venda_array as $item) {
    
        $id = $item['cd_produto'] ?? null;
    
        if (!$id) {
            continue;
        }
      
        // Não sobrescreve item já no carrinho
        if (isset($_SESSION['carrinho'][$id])) {
            continue;
        }
      
        $_SESSION['carrinho'][$id] = $item;
    }


    echo $retOrcamentoVenda['partial_orcamento'];
    $_SESSION['cd_venda'] = $retVenda['cd_venda'];
    echo "<script>alert('| - | - | - | (Venda aberta(".$_SESSION['cd_venda'].")) | - | - | - |');</script>";
  }
}


/* ===== DADOS ===== */
$data       = $u->conProdServ($_SESSION['cd_empresa']);
$products   = $data['products']   ?? [];
$categories = $data['categories'] ?? [];

/* ===== CARRINHO ===== */
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

/* ===== PERMISSÕES ===== */
$permAddProduto = $u->retPermissaoBool('301');
$permDesconto   = $u->retPermissaoBool('302');
$permRemover    = $u->retPermissaoBool('304');

/* ===== TOTAIS ===== */
$subtotal = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $subtotal += $item['price'] * $item['qtd_orcamento'];
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

.grupo-card {
  cursor: pointer;
  border: 2px solid #dee2e6;
  transition: all .2s;
}

.grupo-card:hover {
  border-color: #0d6efd;
}

.grupo-card.active {
  background-color: #0d6efd;
  color: #fff;
  border-color: #0d6efd;
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
<?php
// ===== CONFIGURAÇÃO =====
$mostrarTodos = false; // <<< MUDE AQUI (true / false)

// Descobre o primeiro grupo
$primeiroGrupoId = null;

if (is_array($categories) && count($categories)) {
    foreach ($categories as $cat) {
        if (is_array($cat)) {
            $primeiroGrupoId = $cat['id'] ?? '';
        } else {
            $primeiroGrupoId = md5($cat);
        }
        break;
    }
}
?>

<section id="principal" class="section active">
  <div class="row">

    <!-- ================== GRUPOS + PRODUTOS ================== -->
    <div class="col-md-9">

      <!-- ===== GRUPOS ===== -->
      <h6 class="mb-2">Grupos</h6>

      <div class="row mb-4" id="grupoCards">

        <?php if ($mostrarTodos): ?>
          <!-- TODOS -->
          <div class="col-6 col-md-3 mb-3">
            <div class="card grupo-card active"
                 onclick="filtrarGrupo('all', this)">
              <div class="card-body text-center fw-bold">
                Todos
              </div>
            </div>
          </div>
        <?php endif; ?>

        <?php
        if (is_array($categories) && count($categories)) {
            foreach ($categories as $cat) {

                if (is_array($cat)) {
                    $id   = $cat['id']   ?? '';
                    $name = $cat['name'] ?? '';
                } else {
                    $id   = md5($cat);
                    $name = $cat;
                }

                if (!$name) continue;

                $ativoInicial = (!$mostrarTodos && $id == $primeiroGrupoId) ? 'active' : '';
                ?>
                <div class="col-6 col-md-3 mb-3">
                  <div class="card grupo-card <?= $ativoInicial ?>"
                       onclick="filtrarGrupo('<?= $id ?>', this)">
                    <div class="card-body text-center fw-bold">
                      <?= htmlspecialchars($name) ?>
                    </div>
                  </div>
                </div>
                <?php
            }
        }
        ?>
      </div>

      <!-- ===== PRODUTOS ===== -->
      <h6 class="mb-2">Produtos</h6>

      <div class="row" id="productList">

<?php foreach ($products as $p): 
  $catId = md5($p['category']);
  $style = ($mostrarTodos || $catId == $primeiroGrupoId) ? '' : 'display:none;';
?>
  <div class="col-md-4 mb-3 product-wrapper"
       data-category-id="<?= $catId ?>"
       style="<?= $style ?>">

    <div class="card product-card h-100 position-relative">
      <div class="card-body">

        <!-- BOTÃO 3 PONTINHOS -->
        <button
          type="button"
          class="btn btn-sm btn-light position-absolute top-0 end-0 m-2"
          onclick="abrirModalDesconto(
            <?= $p['id'] ?>,
            '<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>',
            <?= $p['price'] ?>
          )">
          &#8942;
        </button>

        <h6><?= htmlspecialchars($p['name']) ?></h6>
        <small class="text-muted">
          <?= htmlspecialchars($p['category']) ?>
        </small>

        <p class="fw-bold mt-2">
           <input type="hidden" name="descontoPercentual" id="descPerc_<?= $p['id'] ?>" value="0">
            <input type="hidden" name="descontoValor" id="descVal_<?= $p['id'] ?>" value="0">

          R$ <?= number_format($p['price'],2,',','.') ?>
        </p>

        <?php if ($permAddProduto): ?>
          <form method="post" action="0_add.php">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <input type="hidden" name="name" value="<?= htmlspecialchars($p['name']) ?>">
            <input type="hidden" name="price" value="<?= $p['price'] ?>">
            <input type="hidden" name="desconto" value="0" id="desconto_<?= $p['id'] ?>">

            <button class="btn btn-sm btn-primary w-100">
              Adicionar
            </button>
          </form>
        <?php else: ?>
          <button class="btn btn-sm btn-danger w-100" disabled>
            Sem permissão
          </button>
        <?php endif; ?>

      </div>
    </div>

  </div>
<?php endforeach; ?>

</div>

    </div>

    <!-- ================== CARRINHO ================== -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">

          <h5>Carrinho.  Venda aberta: <?php echo $_SESSION['cd_venda'];?></h5>

          <?php if (empty($_SESSION['carrinho'])): ?>
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
                <?php foreach ($_SESSION['carrinho'] as $id => $item): ?>
                  <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['qtd_orcamento'] ?></td>
                    <td>
                      R$ <?= number_format($item['price'] * $item['qtd_orcamento'], 2, ',', '.') ?>
                    </td>
                    <td class="text-end">
                      <?php if ($permRemover): ?>
                        <form method="post" action="0_remove.php"
                              onsubmit="return confirm('Cancelar este item?');">
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
          <p>Subtotal:
            <strong>R$ <?= number_format($subtotal,2,',','.') ?></strong>
          </p>

          <form method="post" action="0_desconto.php">
            <label>Desconto</label>
            <input type="number" step="0.01" name="desconto"
                   class="form-control"
                   value="<?= $desconto ?>"
                   <?= !$permDesconto ? 'readonly' : '' ?>>
            <?php if ($permDesconto): ?>
              <button class="btn btn-secondary btn-sm w-100 mt-1">
                Aplicar
              </button>
            <?php endif; ?>
          </form>

          <hr>
          <p>Total:
            <strong>R$ <?= number_format($total,2,',','.') ?></strong>
          </p>

          <form method="post" action="0_finalizar.php">
  <button class="btn btn-success w-100"
    <?= empty($_SESSION['carrinho']) ? 'disabled' : '' ?>>
    Finalizar Venda
  </button>
</form>


          <?php 

$ultima_venda = $_SESSION['carrinho'] ?? null;

                    // JSON_PRETTY_PRINT e JSON_UNESCAPED_UNICODE continuam funcionando normalmente no 8.3
                    $json = json_encode($ultima_venda, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                    if ($json === false) {
                      echo '<pre id="jsonAcesso">Erro ao gerar JSON: ' . json_last_error_msg() . '</pre>';
                    } else {
                      echo '<pre id="jsonAcesso">' . $json . '</pre>';
                    }
                    
                    
                    
?>

        </div>
      </div>
    </div>

  </div>


<div class="modal fade" id="modalDesconto" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Aplicar desconto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p id="produtoNome" class="fw-bold"></p>

       

        <label class="form-label">Desconto (%)</label>
        <input type="number" id="descontoPercentual"
               class="form-control mb-2"
               min="0" max="100" step="0.01"
               placeholder="Ex: 10">

        <label class="form-label">Desconto (R$)</label>
        <input type="number" id="descontoValor"
               class="form-control"
               min="0" step="0.01"
               placeholder="Ex: 5.00">
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">
          Cancelar
        </button>
        <button class="btn btn-primary" onclick="aplicarDesconto()">
          Aplicar
        </button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modalImpressao" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Imprimir comprovante?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        Deseja imprimir o comprovante desta venda?
      </div>

      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary" id="btnNaoImprimir">
          Não
        </button>
        <button class="btn btn-success" id="btnImprimir">
          Sim, imprimir
        </button>
      </div>

    </div>
  </div>
</div>



<script>
let produtoAtualId = null;
let produtoPreco = 0;

function abrirModalDesconto(id, nome, preco) {
  produtoAtualId = id;
  produtoPreco = preco;

  document.getElementById('produtoNome').innerText = nome;
  document.getElementById('descontoPercentual').value = '';
  document.getElementById('descontoValor').value = '';

  new bootstrap.Modal(document.getElementById('modalDesconto')).show();
}

// Bloqueia usar os dois campos ao mesmo tempo
document.getElementById('descontoPercentual').addEventListener('input', () => {
  document.getElementById('descontoValor').value = '';
});

document.getElementById('descontoValor').addEventListener('input', () => {
  document.getElementById('descontoPercentual').value = '';
});

function aplicarDesconto() {
  const perc = parseFloat(document.getElementById('descontoPercentual').value) || 0;
  const val  = parseFloat(document.getElementById('descontoValor').value) || 0;

  if (perc <= 0 && val <= 0) {
    alert('Informe um desconto percentual ou em valor');
    return;
  }

  if (perc > 100) {
    alert('Desconto percentual não pode ser maior que 100%');
    return;
  }

  const descontoCalculado = perc > 0
    ? (produtoPreco * perc / 100)
    : val;

  if (descontoCalculado > produtoPreco) {
    alert('O desconto não pode exceder o valor do produto');
    return;
  }

  document.getElementById('descPerc_' + produtoAtualId).value = perc.toFixed(2);
  document.getElementById('descVal_' + produtoAtualId).value  = val.toFixed(2);

  bootstrap.Modal.getInstance(
    document.getElementById('modalDesconto')
  ).hide();
}

function finalizarVenda() {

  fetch('finalizar_venda.php', {
    method: 'POST',
    body: new FormData(document.getElementById('formVenda'))
  })
  .then(r => r.json())
  .then(data => {
    if (data.status === 'OK') {
      window.cdVendaFinalizada = data.cd_venda;
      const modal = new bootstrap.Modal(document.getElementById('modalImpressao'));
      modal.show();
    }
  });
}

document.getElementById('btnImprimir').onclick = function () {
  window.location.href = '0_comprovante.php?print=1&cd_venda=' + window.cdVendaFinalizada;
};

document.getElementById('btnNaoImprimir').onclick = function () {
  window.location.href = '0_comprovante.php?cd_venda=' + window.cdVendaFinalizada;
};




</script>


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
function filtrarGrupo(grupoId, el) {

  // salva o grupo selecionado
  localStorage.setItem('grupoSelecionado', grupoId);

  document.querySelectorAll('.grupo-card').forEach(card => {
    card.classList.remove('active');
  });

  el.classList.add('active');

  document.querySelectorAll('.product-wrapper').forEach(prod => {
    if (grupoId === 'all') {
      prod.style.display = '';
    } else {
      prod.style.display =
        prod.dataset.categoryId === grupoId ? '' : 'none';
    }
  });
}



document.addEventListener('DOMContentLoaded', function () {

  let grupoSalvo = localStorage.getItem('grupoSelecionado');

  if (!grupoSalvo) return;

  // encontra o card correspondente
  let card = document.querySelector(
    `.grupo-card[onclick*="'${grupoSalvo}'"]`
  );

  if (card) {
    card.click(); // reaplica filtro e destaque
  }
});



function showSection(id){
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(id).classList.add('active');
}

</script>








</body>
</html>
