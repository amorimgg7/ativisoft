<?php
// pdv_mesas_avancado.php - PDV avançado com mesas

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

// Mesas
$tables = [];
for($i=1;$i<=10;$i++) $tables[$i] = ['id'=>$i,'name'=>"Mesa $i",'order'=>[],'client'=>['name'=>'Consumidor Final','id'=>'']];

// Endpoint de finalização simulado
if ($_SERVER['REQUEST_METHOD']==='POST'){
    header('Content-Type: application/json; charset=utf-8');
    $input = json_decode(file_get_contents('php://input'), true);
    echo json_encode(['success'=>true,'message'=>'Venda recebida (simulação)','payload'=>$input]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PDV - Mesas Avançado</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f5f7fb; font-family:sans-serif; }
.table-card { cursor:pointer; margin-bottom:10px; transition:.1s; }
.table-card:hover { transform:scale(1.02); }
.table-card.active { border:2px solid #0d6efd; }
.product-card { cursor:pointer; transition:0.08s; border-radius:12px; min-height:120px; }
.product-card:active { transform:scale(0.97); }
</style>
</head>
<body>
<div class="container-fluid py-3">
    <div class="row g-3">
        <!-- MESAS -->
        <div class="col-md-2">
            <h5>Mesas</h5>
            <div id="tableList">
                <?php foreach($tables as $t): ?>
                    <div class="card table-card p-2" data-id="<?= $t['id'] ?>">
                        <?= $t['name'] ?> - <span class="badge bg-secondary">0</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- PRODUTOS -->
        <div class="col-md-5">
            <h5>Produtos</h5>
            <div class="btn-group mb-2 w-100 flex-nowrap" id="categoryFilters">
                <button class="btn btn-outline-primary active" data-category="all">Todos</button>
                <button class="btn btn-outline-primary" data-category="Bebidas">Bebidas</button>
                <button class="btn btn-outline-primary" data-category="Refeições">Refeições</button>
                <button class="btn btn-outline-primary" data-category="Entradas">Entradas</button>
                <button class="btn btn-outline-primary" data-category="Alcoólicos">Alcoólicos</button>
            </div>
            <input id="productSearch" class="form-control mb-2" placeholder="Buscar produto por nome ou SKU">
            <div class="row" id="productList">
                <?php foreach($products as $p): ?>
                <div class="col-sm-6 mb-3 product-wrapper">
                    <div class="card product-card"
                        data-id="<?= $p['id'] ?>"
                        data-name="<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>"
                        data-price="<?= number_format($p['price'],2,'.','') ?>"
                        data-sku="<?= $p['sku'] ?>"
                        data-category="<?= $p['category'] ?>">
                        <div class="card-body">
                            <h6><?= htmlspecialchars($p['name']) ?></h6>
                            <small>SKU: <?= $p['sku'] ?> · <?= $p['category'] ?></small>
                            <div class="d-flex justify-content-between mt-2">
                                <strong>R$ <?= number_format($p['price'],2,',','.') ?></strong>
                                <button class="btn btn-sm btn-outline-primary add-btn">Adicionar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- CARRINHO DA MESA -->
        <div class="col-md-5">
            <h5 id="currentTableName">Selecione uma mesa</h5>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label small">Cliente</label>
                        <div class="d-flex gap-2">
                            <input id="clientName" class="form-control form-control-sm" readonly>
                            <button class="btn btn-sm btn-outline-primary" id="btn-client">Alterar</button>
                        </div>
                    </div>
                    <div class="table-responsive" style="max-height:300px; overflow:auto">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th class="text-end">Qtd</th>
                                    <th class="text-end">Unit</th>
                                    <th class="text-end">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="orderBody">
                                <tr class="text-center"><td colspan="5" class="text-muted">Nenhum item</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between"><div>Subtotal:</div><div id="subtotal">R$ 0,00</div></div>
                    <div class="d-flex justify-content-between mt-2"><div>Desconto:</div>
                        <input id="discount" class="form-control form-control-sm" type="number" min="0" step="0.01" value="0" style="width:120px">
                    </div>
                    <div class="d-flex justify-content-between mt-2"><strong>Total:</strong> <span id="total">R$ 0,00</span></div>
                    <div class="mt-3 d-grid gap-2">
                        <button class="btn btn-success" id="btn-close">Fechar Conta</button>
                        <button class="btn btn-outline-secondary" id="btn-print">Imprimir Cupom</button>
                    </div>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input id="modalClientName" class="form-control mb-2" placeholder="Nome do cliente">
        <input id="modalClientId" class="form-control" placeholder="CPF/CNPJ">
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
// MESAS
let tables={}, currentTableId=null;
document.querySelectorAll('.table-card').forEach(c=>{
    const id=c.dataset.id;
    tables[id]={name:c.innerText.split('-')[0].trim(), order:[], client:{name:'Consumidor Final',id:''}};
    c.addEventListener('click',()=>{
        currentTableId=id;
        document.getElementById('currentTableName').innerText=tables[id].name;
        document.getElementById('clientName').value=tables[id].client.name;
        document.querySelectorAll('.table-card').forEach(tc=>tc.classList.remove('active'));
        c.classList.add('active');
        renderOrder();
    });
});

// PRODUTOS
let products=[];
document.querySelectorAll('.product-card').forEach(c=>{
    products.push({
        id:c.dataset.id, sku:c.dataset.sku, name:c.dataset.name, price:parseFloat(c.dataset.price), category:c.dataset.category
    });
});
function addToCartById(id){
    if(!currentTableId){ alert('Selecione uma mesa!'); return; }
    const p=products.find(x=>x.id==id);
    if(!p) return;
    const existing=tables[currentTableId].order.find(x=>x.id==p.id);
    if(existing) existing.qty++; else tables[currentTableId].order.push({...p, qty:1});
    renderOrder();
}
document.querySelectorAll('.add-btn').forEach(btn=>{
    btn.addEventListener('click',e=>addToCartById(e.target.closest('.product-card').dataset.id));
});

// FILTRO CATEGORIAS
document.querySelectorAll('#categoryFilters button').forEach(btn=>{
    btn.addEventListener('click',()=>{
        document.querySelectorAll('#categoryFilters button').forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
        const cat=btn.dataset.category;
        document.querySelectorAll('.product-wrapper').forEach(col=>{
            const card=col.querySelector('.product-card');
            col.style.display=(cat==='all'||card.dataset.category===cat)?'':'none';
            if(cat==='all'||card.dataset.category===cat) col.style.display='';
        });
    });
});

// BUSCA
document.getElementById('productSearch').addEventListener('input',function(){
    const q=this.value.toLowerCase().trim();
    document.querySelectorAll('.product-wrapper').forEach(col=>{
        const card=col.querySelector('.product-card');
        col.style.display=(card.dataset.name.toLowerCase().includes(q)||card.dataset.sku.toLowerCase().includes(q))?'':'none';
    });
});

// RENDER CARRINHO
function renderOrder(){
    const tbody=document.getElementById('orderBody'); tbody.innerHTML='';
    const order=tables[currentTableId]?.order||[];
    if(order.length===0){ tbody.innerHTML='<tr class="text-center"><td colspan="5" class="text-muted">Nenhum item</td></tr>'; }
    else{
        order.forEach((item,i)=>{
            const tr=document.createElement('tr');
            tr.innerHTML=`<td>${item.name}<br><small>${item.sku}</small></td>
                <td class="text-end"><input type="number" min="1" value="${item.qty}" data-index="${i}" class="form-control form-control-sm qty-input" style="width:60px"></td>
                <td class="text-end">R$ ${item.price.toFixed(2).replace('.',',')}</td>
                <td class="text-end">R$ ${(item.price*item.qty).toFixed(2).replace('.',',')}</td>
                <td class="text-end"><button class="btn btn-sm btn-danger btn-remove" data-index="${i}">X</button></td>`;
            tbody.appendChild(tr);
        });
    }
    updateTotals();
}
function updateTotals(){
    const order=tables[currentTableId]?.order||[];
    const subtotal=order.reduce((s,it)=>s+it.price*it.qty,0);
    const discount=parseFloat(document.getElementById('discount').value||0);
    const total=Math.max(0,subtotal-discount);
    document.getElementById('subtotal').innerText='R$ '+subtotal.toFixed(2).replace('.',',');
    document.getElementById('total').innerText='R$ '+total.toFixed(2).replace('.',',');
    document.querySelector(`.table-card[data-id="${currentTableId}"] .badge`).innerText=order.reduce((s,it)=>s+it.qty,0);
}

// ALTERAR QTD / REMOVER
document.getElementById('orderBody').addEventListener('click',e=>{
    if(e.target.classList.contains('btn-remove')){
        const idx=parseInt(e.target.dataset.index);
        tables[currentTableId].order.splice(idx,1); renderOrder();
    }
});
document.getElementById('orderBody').addEventListener('change',e=>{
    if(e.target.classList.contains('qty-input')){
        const idx=parseInt(e.target.dataset.index);
        const val=parseInt(e.target.value)||1;
        tables[currentTableId].order[idx].qty=Math.max(1,val);
        renderOrder();
    }
});
document.getElementById('discount').addEventListener('input',updateTotals);

// CLIENTE
const clientModal=new bootstrap.Modal(document.getElementById('clientModal'));
document.getElementById('btn-client').addEventListener('click',()=>{
    if(!currentTableId) return alert('Selecione uma mesa!');
    document.getElementById('modalClientName').value=tables[currentTableId].client.name;
    document.getElementById('modalClientId').value=tables[currentTableId].client.id;
    clientModal.show();
});
document.getElementById('saveClient').addEventListener('click',()=>{
    const name=document.getElementById('modalClientName').value.trim()||'Consumidor Final';
    const id=document.getElementById('modalClientId').value.trim();
    tables[currentTableId].client={name,id};
    document.getElementById('clientName').value=name;
    clientModal.hide();
});

// FECHAR CONTA / IMPRIMIR
document.getElementById('btn-close').addEventListener('click',fecharConta);
document.getElementById('btn-print').addEventListener('click',()=>printReceipt(tables[currentTableId]));

function fecharConta(){
    if(!currentTableId || tables[currentTableId].order.length===0) return alert('Nenhum item!');
    const payload={client:tables[currentTableId].client, items:tables[currentTableId].order};
    fetch('',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)})
    .then(r=>r.json()).then(resp=>{
        if(resp.success){
            alert('Venda finalizada!');
            printReceipt(payload);
            tables[currentTableId].order=[];
            updateTotals();
            renderOrder();
        } else alert('Erro: '+(resp.message||''));
    }).catch(err=>alert('Erro de comunicação: '+err));
}

function printReceipt(payload){
    if(!payload) return;
    let w=window.open('','PDV','width=400,height=600');
    w.document.write('<pre style="font-family:monospace">');
    w.document.write('*** CUPOM ***\n\nCliente: '+payload.client.name+'\n');
    payload.items.forEach(it=>{
        w.document.write(`${it.qty}x ${it.name}  R$${it.price.toFixed(2).replace('.',',')}  => R$${(it.price*it.qty).toFixed(2).replace('.',',')}\n`);
    });
    const subtotal=payload.items.reduce((s,it)=>s+it.price*it.qty,0);
    w.document.write('\nSubtotal: R$'+subtotal.toFixed(2).replace('.',',')+'\n');
    w.document.write('TOTAL: R$'+subtotal.toFixed(2).replace('.',',')+'\n');
    w.document.write('\n*** Obrigado! ***\n');
    w.document.write('</pre>'); w.print();
}
</script>
</body>
</html>
