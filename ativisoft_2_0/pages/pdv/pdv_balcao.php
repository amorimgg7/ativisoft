<?php
// pdv_orcamento.php - PDV simples com categorias (Bebidas, Refeições, Entradas, Alcoólicos)

// Simulação de produtos (normalmente viria do banco de dados)
$products = [
    ['id'=>1, 'sku'=>'B001', 'name'=>'Refrigerante Lata', 'price'=>6.00, 'category'=>'Bebidas'],
    ['id'=>2, 'sku'=>'B002', 'name'=>'Água Mineral 500ml', 'price'=>4.00, 'category'=>'Bebidas'],
    ['id'=>3, 'sku'=>'B003', 'name'=>'Suco Natural', 'price'=>9.50, 'category'=>'Bebidas'],
    ['id'=>4, 'sku'=>'R001', 'name'=>'Prato Feito (PF)', 'price'=>22.90, 'category'=>'Refeições'],
    ['id'=>5, 'sku'=>'R002', 'name'=>'Macarronada', 'price'=>19.90, 'category'=>'Refeições'],
    ['id'=>6, 'sku'=>'R003', 'name'=>'Feijoada', 'price'=>27.90, 'category'=>'Refeições'],
    ['id'=>7, 'sku'=>'E001', 'name'=>'Batata Frita', 'price'=>14.90, 'category'=>'Entradas'],
    ['id'=>8, 'sku'=>'E002', 'name'=>'Porção de Calabresa', 'price'=>18.00, 'category'=>'Entradas'],
    ['id'=>9, 'sku'=>'E003', 'name'=>'Pastéis (6un)', 'price'=>12.00, 'category'=>'Entradas'],
    ['id'=>10, 'sku'=>'A001', 'name'=>'Cerveja Long Neck', 'price'=>11.00, 'category'=>'Alcoólicos'],
    ['id'=>11, 'sku'=>'A002', 'name'=>'Caipirinha', 'price'=>16.00, 'category'=>'Alcoólicos'],
    ['id'=>12, 'sku'=>'A003', 'name'=>'Vinho Taça', 'price'=>14.00, 'category'=>'Alcoólicos'],
];

// Endpoint de finalização simulado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    $input = json_decode(file_get_contents('php://input'), true);
    echo json_encode(['success' => true, 'message' => 'Venda recebida (simulação)', 'payload' => $input]);
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PDV - Ativisoft</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f5f7fb; font-family:sans-serif; }

.product-card {
    cursor:pointer;
    transition: transform .08s ease-in-out;
    border-radius:12px;
    min-height:130px;
}
.product-card:active { transform: scale(.97); }

#categoryFilters {
    overflow-x:auto;
    white-space:nowrap;
    width:100%;
}
#categoryFilters button {
    flex:0 0 auto;
}

.left-pane { order:1; }
.right-pane { order:2; }

@media (max-width: 768px) {
    .left-pane { order:2; }
    .right-pane { order:1; margin-bottom:1rem; }
    .product-card .card-body { padding:10px; }
    .product-card h5 { font-size:1.05rem; }
    .product-card strong { font-size:1rem; }
    #productSearch, #barcodeInput { width:100%; margin-bottom:.5rem; }
    .cart-table td, .cart-table th { font-size:.85rem; }
    .product-wrapper { padding-left:6px; padding-right:6px; }
}
@media (max-width: 400px) {
    h3 { font-size:1.3rem; }
    .add-btn { padding:2px 6px; font-size:.75rem; }
    .product-card { min-height:110px; }
    #cartBody td { padding:4px; }
}
</style>
</head>
<body>
<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        
        <h3 class="m-0">PDV - Ativisoft</h3>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" id="btn-reset">Limpar</button>
            <button class="btn btn-primary" id="btn-finalizar">Finalizar Venda</button>
        </div>
    </div>

    <div class="row g-3">
        <!-- FILTRO DE CATEGORIAS -->
        <div class="col-12 mb-2">
            <div class="btn-group w-100 flex-nowrap" role="group" id="categoryFilters">
                <button class="btn btn-outline-primary active" data-category="all">Todos</button>
                <button class="btn btn-outline-primary" data-category="Bebidas">Bebidas</button>
                <button class="btn btn-outline-primary" data-category="Refeições">Refeições</button>
                <button class="btn btn-outline-primary" data-category="Entradas">Entradas</button>
                <button class="btn btn-outline-primary" data-category="Alcoólicos">Alcoólicos</button>
            </div>
        </div>

        <!-- PRODUTOS -->
        <div class="col-lg-8 left-pane">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-2 align-items-center">
                        <div class="col-sm-12 col-md-8">
                            <input id="productSearch" class="form-control" placeholder="Buscar produto por nome ou SKU..." autofocus>
                        </div>
                        <div class="col-sm-12 col-md-4 d-flex gap-2">
                            <input id="barcodeInput" class="form-control scan-input" placeholder="Leitura (código)">
                            <button class="btn btn-outline-secondary" id="btn-scan">Adicionar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="productList">
                <?php foreach($products as $p): ?>
                <div class="col-sm-6 col-md-4 mb-3 product-wrapper">
                    <div class="card product-card"
                        data-id="<?= $p['id'] ?>"
                        data-name="<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>"
                        data-price="<?= number_format($p['price'], 2, '.', '') ?>"
                        data-sku="<?= $p['sku'] ?>"
                        data-category="<?= $p['category'] ?>">
                        <div class="card-body">
                            <h5 class="card-title mb-1"><?= htmlspecialchars($p['name']) ?></h5>
                            <p class="card-text text-muted small">SKU: <?= $p['sku'] ?> · <?= $p['category'] ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>R$ <?= number_format($p['price'],2,',','.') ?></strong>
                                <button class="btn btn-sm btn-outline-primary add-btn">Adicionar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- CARRINHO -->
        <div class="col-lg-4 right-pane">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Carrinho</h5>
                    <div class="table-responsive" style="max-height:320px; overflow:auto">
                        <table class="table table-sm cart-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="text-end">Qtd</th>
                                    <th class="text-end">Unit.</th>
                                    <th class="text-end">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cartBody">
                                <tr class="text-center"><td colspan="5" class="text-muted">Carrinho vazio</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between"><div>Subtotal</div><div id="subtotalText">R$ 0,00</div></div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div>Desconto</div>
                        <div><input id="discount" class="form-control form-control-sm" type="number" min="0" step="0.01" value="0" style="width:140px"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <div><strong>Total</strong></div>
                        <div><strong id="totalText">R$ 0,00</strong></div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label small">Forma de pagamento</label>
                        <select id="payMethod" class="form-select form-select-sm mb-2">
                            <option value="cash">Dinheiro</option>
                            <option value="card">Cartão</option>
                            <option value="pix">PIX</option>
                        </select>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success" id="btn-pay">Receber pagamento</button>
                            <button class="btn btn-outline-secondary" id="btn-print">Imprimir Cupom</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6>Resumo Rápido</h6>
                    <p class="small text-muted mb-1">Itens: <span id="countItems">0</span></p>
                    <p class="small text-muted mb-1">Cliente: <span id="clientName">Consumidor Final</span></p>
                    <button class="btn btn-sm btn-outline-primary" id="btn-client">Selecionar Cliente</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cliente -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Nome</label>
          <input id="clientInput" class="form-control" placeholder="Nome do cliente">
        </div>
        <div class="mb-3">
          <label class="form-label">Identificação (CPF/CNPJ)</label>
          <input id="clientId" class="form-control" placeholder="CPF ou CNPJ">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button class="btn btn-primary" id="saveClient">Salvar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ====== PRODUTOS ======
const products = [];
document.querySelectorAll('.product-card').forEach(card => {
  products.push({
    id: String(card.dataset.id),
    sku: card.dataset.sku,
    name: card.dataset.name,
    price: parseFloat(card.dataset.price),
    category: card.dataset.category
  });
});
let cart = [];
function formatBRL(v){ return 'R$ '+v.toFixed(2).replace('.',','); }
function renderCart(){
    const tbody=document.getElementById('cartBody'); tbody.innerHTML='';
    if(cart.length===0){ tbody.innerHTML='<tr class="text-center"><td colspan="5" class="text-muted">Carrinho vazio</td></tr>'; }
    else{
        cart.forEach((item,i)=>{
            const tr=document.createElement('tr');
            tr.innerHTML=`<td>${item.name}<br><small class="text-muted">SKU: ${item.sku}</small></td>
            <td class="text-end"><input type="number" min="1" value="${item.qty}" data-index="${i}" class="form-control form-control-sm qty-input" style="width:70px; margin-left:auto"></td>
            <td class="text-end">${formatBRL(item.price)}</td>
            <td class="text-end">${formatBRL(item.price*item.qty)}</td>
            <td class="text-end"><button class="btn btn-sm btn-danger btn-remove" data-index="${i}">X</button></td>`;
            tbody.appendChild(tr);
        });
    }
    updateTotals();
}
function updateTotals(){
    const subtotal=cart.reduce((s,it)=>s+it.price*it.qty,0);
    document.getElementById('subtotalText').innerText=formatBRL(subtotal);
    const discount=parseFloat(document.getElementById('discount').value||0);
    const total=Math.max(0,subtotal-discount);
    document.getElementById('totalText').innerText=formatBRL(total);
    document.getElementById('countItems').innerText=cart.reduce((s,it)=>s+it.qty,0);
}

// ====== FILTRO ======
document.querySelectorAll('#categoryFilters button').forEach(btn=>{
    btn.addEventListener('click',()=>{
        document.querySelectorAll('#categoryFilters button').forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
        const cat=btn.dataset.category;
        document.querySelectorAll('#productList .product-wrapper').forEach(col=>{
            const card=col.querySelector('.product-card');
            col.style.display=(cat==='all'||card.dataset.category===cat)?'':'none';
        });
    });
});

// ====== CARRINHO ======
function addToCartById(id){
    const p=products.find(x=>x.id==id);
    if(!p) return;
    const existing=cart.find(x=>x.id==p.id);
    if(existing) existing.qty++; else cart.push({...p, qty:1});
    renderCart();
}
document.querySelectorAll('.add-btn').forEach(btn=>btn.addEventListener('click',e=>{
    addToCartById(e.target.closest('.product-card').dataset.id);
}));
document.querySelectorAll('.product-card').forEach(c=>c.addEventListener('dblclick',e=>{
    addToCartById(c.dataset.id);
}));

// ====== BUSCA ======
document.getElementById('productSearch').addEventListener('input',function(){
    const q=this.value.toLowerCase().trim();
    document.querySelectorAll('#productList .product-wrapper').forEach(col=>{
        const card=col.querySelector('.product-card');
        col.style.display=(card.dataset.name.toLowerCase().includes(q)||card.dataset.sku.toLowerCase().includes(q))?'':'none';
    });
});

// ====== LEITURA SKU ======
document.getElementById('btn-scan').addEventListener('click',()=>{
    const code=document.getElementById('barcodeInput').value.trim();
    if(!code) return;
    const p=products.find(x=>x.sku===code);
    if(p) addToCartById(p.id); else alert('Produto não encontrado: '+code);
    document.getElementById('barcodeInput').value='';
});

// ====== REMOVER / ALTERAR QTD ======
document.getElementById('cartBody').addEventListener('click',e=>{
    if(e.target.classList.contains('btn-remove')){
        const idx=parseInt(e.target.dataset.index);
        cart.splice(idx,1); renderCart();
    }
});
document.getElementById('cartBody').addEventListener('change',e=>{
    if(e.target.classList.contains('qty-input')){
        const idx=parseInt(e.target.dataset.index);
        const val=parseInt(e.target.value)||1;
        cart[idx].qty=Math.max(1,val);
        renderCart();
    }
});
document.getElementById('discount').addEventListener('input',updateTotals);

// ====== RESET ======
document.getElementById('btn-reset').addEventListener('click',()=>{
    if(!confirm('Limpar carrinho?')) return;
    cart=[]; document.getElementById('discount').value=0; renderCart();
});

// ====== CLIENTE ======
const clientModal=new bootstrap.Modal(document.getElementById('clientModal'));
document.getElementById('btn-client').addEventListener('click',()=>clientModal.show());
document.getElementById('saveClient').addEventListener('click',()=>{
    const name=document.getElementById('clientInput').value.trim()||'Consumidor Final';
    document.getElementById('clientName').innerText=name;
    clientModal.hide();
});

// ====== FINALIZAR PAGAMENTO ======
document.getElementById('btn-pay').addEventListener('click',receberPagamento);
document.getElementById('btn-finalizar').addEventListener('click',receberPagamento);
function receberPagamento(){
    if(cart.length===0){ alert('Carrinho vazio'); return; }
    const payload={
        client: document.getElementById('clientName').innerText,
        items: cart,
        subtotal: cart.reduce((s,it)=>s+it.price*it.qty,0),
        discount: parseFloat(document.getElementById('discount').value||0),
        total: parseFloat(document.getElementById('totalText').innerText.replace('R$ ','').replace(/\./g,'').replace(',','.'))
    };
    fetch('',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)})
    .then(r=>r.json())
    .then(resp=>{
        if(resp.success){ alert('Venda finalizada!'); printReceipt(payload); cart=[]; renderCart();}
        else alert('Erro: '+(resp.message||''));
    }).catch(err=>alert('Erro de comunicação: '+err));
}

function printReceipt(payload){
    let w=window.open('','PDV','width=400,height=600');
    w.document.write('<pre style="font-family:monospace">');
    w.document.write('*** CUPOM ***\n\nCliente: '+payload.client+'\n\n');
    payload.items.forEach(it=>{
        w.document.write(`${it.qty}x ${it.name}  R$${it.price.toFixed(2).replace('.',',')}  => R$${(it.price*it.qty).toFixed(2).replace('.',',')}\n`);
    });
    w.document.write('\nSubtotal: R$'+payload.subtotal.toFixed(2).replace('.',',')+'\n');
    w.document.write('Desconto: R$'+payload.discount.toFixed(2).replace('.',',')+'\n');
    w.document.write('TOTAL: R$'+payload.total.toFixed(2).replace('.',',')+'\n');
    w.document.write('\n*** Obrigado! ***\n');
    w.document.write('</pre>'); w.print();
}
renderCart();
</script>
</body>
</html>
