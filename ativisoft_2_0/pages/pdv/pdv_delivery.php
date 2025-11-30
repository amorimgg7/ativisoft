<?php
session_start();
if (!isset($_SESSION['cd_colab'])) {
    header("location: ../../pages/samples/login.php");
    exit;
}
require_once '../../classes/conn.php';
include("../../classes/functions.php");
$u = new Usuario;

// Carrega produtos e categorias
$data = $u->conProdServ($_SESSION['cd_empresa']);
$products = $data['products'];
$categories = $data['categories'];

// pedidos_interativos.php
$orders = [
    [
        'id'=>101,
        'client'=>'João Silva',
        'phone'=>'(21)99999-0001',
        'address'=>'Rua A, 123',
        'status'=>'Aguardando',
        'items'=>[
            ['name'=>'Prato Feito (PF)','qty'=>1,'price'=>22.9],
            ['name'=>'Refrigerante Lata','qty'=>2,'price'=>6]
        ]
    ],
    [
        'id'=>102,
        'client'=>'Maria Souza',
        'phone'=>'(21)98888-1111',
        'address'=>'Av. B, 456',
        'status'=>'Preparando',
        'items'=>[
            ['name'=>'Feijoada','qty'=>1,'price'=>27.9],
            ['name'=>'Água Mineral 500ml','qty'=>1,'price'=>4]
        ]
    ]
];

$statuses = ['Aguardando','Preparando','Pronto','Entregue'];
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PDV Delivery Demo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
body { background:#f5f7fb; font-family:sans-serif; }
.column { background:#e2e6ea; padding:10px; border-radius:8px; min-height:400px; }
.column h5 { text-align:center; margin-bottom:10px; }
.order-card { background:#fff; margin-bottom:10px; padding:10px; border-radius:6px; cursor:pointer; transition:0.2s; }
.order-card:hover { background:#f1f3f5; }
.badge-total { float:right; font-weight:bold; }
.drag-over { background:#d0ebff !important; }
</style>
</head>
<body>
<div class="container-fluid py-3">
                    <?php include("../../partials/_navbar_pdv.php"); ?>
<h1>PDV Delivery Demo</h1>

                    <section id="principal" class="active">
    <div class="d-flex justify-content-between align-items-center mb-3">
        
        <button class="btn btn-primary" id="btn-new-order">Novo Pedido</button>
    </div>
    <div class="row g-3" id="board">
        <?php foreach($statuses as $status): ?>
        <div class="col-lg-3 col-md-6">
            <div class="column" data-status="<?= $status ?>">
                <h5><?= $status ?></h5>
                <?php foreach($orders as $o): ?>
                    <?php if($o['status']==$status): ?>
                        <div class="order-card" draggable="true" 
                             data-id="<?= $o['id'] ?>" 
                             data-items='<?= json_encode($o['items']) ?>' 
                             data-client="<?= htmlspecialchars($o['client'],ENT_QUOTES) ?>" 
                             data-phone="<?= $o['phone'] ?>" 
                             data-address="<?= htmlspecialchars($o['address'],ENT_QUOTES) ?>">
                            <div><?= $o['client'] ?></div>
                            <div class="badge-total">R$ <?= number_format(array_sum(array_map(fn($i)=>$i['qty']*$i['price'],$o['items'])),2,',','.') ?></div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    </section>

    <section id="historico">
    <h2>Histórico de vendas</h2>

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

    <div id="historicoResultados">
        <!-- Histórico carregado via AJAX -->
    </div>
</section>

<script>
document.getElementById('filtroHistorico').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita recarregar a página

    const dataInicio = document.getElementById('data_inicio').value;
    const dataFim = document.getElementById('data_fim').value;

    fetch('historico_ajax.php?data_inicio=' + dataInicio + '&data_fim=' + dataFim)
        .then(resp => resp.text())
        .then(html => {
            document.getElementById('historicoResultados').innerHTML = html;
        })
        .catch(err => console.error(err));
});

// Carrega o histórico inicial ao abrir a página
window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('filtroHistorico').dispatchEvent(new Event('submit'));
});
</script>


                    <section id="integracao">
                        <h2>Integrações com parceiros</h2>
                        <p>...</p>
                    </section>
</div>
<?php include("../../partials/_footer.php"); ?>
<!-- Modal Pedido -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalhes do Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Cliente:</strong> <span id="modalClient"></span></p>
        <p><strong>Telefone:</strong> <span id="modalPhone"></span></p>
        <p><strong>Endereço:</strong> <span id="modalAddress"></span></p>
        <table class="table table-sm">
            <thead><tr><th>Produto</th><th>Qtd</th><th>Preço Unit.</th><th>Total</th></tr></thead>
            <tbody id="modalItems"></tbody>
        </table>
        <p class="text-end"><strong>Total: R$ <span id="modalTotal">0,00</span></strong></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Novo Pedido -->
<div class="modal fade" id="newOrderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Novo Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label>Cliente</label>
          <input id="newClient" class="form-control" placeholder="Nome do cliente">
        </div>
        <div class="mb-2">
          <label>Telefone</label>
          <input id="newPhone" class="form-control" placeholder="Telefone">
        </div>
        <div class="mb-2">
          <label>Endereço</label>
          <input id="newAddress" class="form-control" placeholder="Endereço">
        </div>
        <div class="mb-2">
          <label>Itens (JSON simplificado)</label>
          <textarea id="newItems" class="form-control" placeholder='Ex: [{"name":"PF","qty":1,"price":22.9}]'></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button class="btn btn-primary" id="saveNewOrder">Salvar Pedido</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const orderCards = () => document.querySelectorAll('.order-card');
const columns = document.querySelectorAll('.column');

// Abrir modal de pedido
orderCards().forEach(card=>{
    card.addEventListener('click',()=>{
        document.getElementById('modalClient').innerText=card.dataset.client;
        document.getElementById('modalPhone').innerText=card.dataset.phone;
        document.getElementById('modalAddress').innerText=card.dataset.address;
        const items=JSON.parse(card.dataset.items);
        const tbody=document.getElementById('modalItems'); tbody.innerHTML='';
        let total=0;
        items.forEach(i=>{
            const tr=document.createElement('tr');
            const line=i.qty*i.price;
            total+=line;
            tr.innerHTML=`<td>${i.name}</td><td>${i.qty}</td><td>R$ ${i.price.toFixed(2).replace('.',',')}</td><td>R$ ${line.toFixed(2).replace('.',',')}</td>`;
            tbody.appendChild(tr);
        });
        document.getElementById('modalTotal').innerText=total.toFixed(2).replace('.',',');
        new bootstrap.Modal(document.getElementById('orderModal')).show();
    });
});

// Drag & Drop
let dragged = null;
orderCards().forEach(card=>{
    card.addEventListener('dragstart', e=>{ dragged=card; });
});
columns.forEach(col=>{
    col.addEventListener('dragover', e=>{ e.preventDefault(); col.classList.add('drag-over'); });
    col.addEventListener('dragleave', e=>{ col.classList.remove('drag-over'); });
    col.addEventListener('drop', e=>{
        e.preventDefault();
        col.classList.remove('drag-over');
        if(dragged){
            col.appendChild(dragged);
            dragged.dataset.status = col.dataset.status; // atualizar status
            dragged=null;
        }
    });
});

// Novo Pedido
const newOrderModal = new bootstrap.Modal(document.getElementById('newOrderModal'));
document.getElementById('btn-new-order').addEventListener('click',()=>newOrderModal.show());
document.getElementById('saveNewOrder').addEventListener('click',()=>{
    const client = document.getElementById('newClient').value.trim()||'Consumidor Final';
    const phone = document.getElementById('newPhone').value.trim();
    const address = document.getElementById('newAddress').value.trim();
    let items = [];
    try { items = JSON.parse(document.getElementById('newItems').value); } catch(e){ alert('Itens inválidos'); return; }
    const id = Date.now();
    const col = document.querySelector('.column[data-status="Aguardando"]');
    const card = document.createElement('div');
    card.className='order-card';
    card.setAttribute('draggable','true');
    card.dataset.id = id;
    card.dataset.client = client;
    card.dataset.phone = phone;
    card.dataset.address = address;
    card.dataset.items = JSON.stringify(items);
    card.dataset.status = 'Aguardando';
    const total = items.reduce((s,it)=>s+it.qty*it.price,0);
    card.innerHTML=`<div>${client}</div><div class="badge-total">R$ ${total.toFixed(2).replace('.',',')}</div>`;
    col.appendChild(card);
    // Reaplicar drag & click
    card.addEventListener('click',()=>{ card.click(); });
    card.addEventListener('dragstart', e=>{ dragged=card; });
    newOrderModal.hide();
    document.getElementById('newClient').value='';
    document.getElementById('newPhone').value='';
    document.getElementById('newAddress').value='';
    document.getElementById('newItems').value='';
});
</script>
</body>
</html>
