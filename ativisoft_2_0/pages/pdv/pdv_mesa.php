<?php
// pdv_mesas.php - PDV com mesas e categorias

$products = [
    ['id'=>1, 'sku'=>'B001', 'name'=>'Refrigerante Lata', 'price'=>6.00, 'category'=>'Bebidas'],
    ['id'=>2, 'sku'=>'B002', 'name'=>'Água Mineral 500ml', 'price'=>4.00, 'category'=>'Bebidas'],
    ['id'=>3, 'sku'=>'R001', 'name'=>'Prato Feito (PF)', 'price'=>22.90, 'category'=>'Refeições'],
    ['id'=>4, 'sku'=>'E001', 'name'=>'Batata Frita', 'price'=>14.90, 'category'=>'Entradas'],
    ['id'=>5, 'sku'=>'A001', 'name'=>'Cerveja Long Neck', 'price'=>11.00, 'category'=>'Alcoólicos'],
];

// Simulação de mesas
$tables = [];
for($i=1;$i<=10;$i++) $tables[$i] = ['id'=>$i,'name'=>"Mesa $i",'order'=>[]];

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
<title>PDV - Mesas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f5f7fb; font-family:sans-serif; }
.table-card { cursor:pointer; margin-bottom:10px; transition:0.1s; }
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
        <div class="col-md-3">
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
            <div class="btn-group mb-2" id="categoryFilters">
                <button class="btn btn-outline-primary active" data-category="all">Todos</button>
                <button class="btn btn-outline-primary" data-category="Bebidas">Bebidas</button>
                <button class="btn btn-outline-primary" data-category="Refeições">Refeições</button>
                <button class="btn btn-outline-primary" data-category="Entradas">Entradas</button>
                <button class="btn btn-outline-primary" data-category="Alcoólicos">Alcoólicos</button>
            </div>
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

        <!-- PEDIDO DA MESA -->
        <div class="col-md-4">
            <h5 id="currentTableName">Selecione uma mesa</h5>
            <div class="card mb-3">
                <div class="card-body">
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
                    <div class="d-flex justify-content-between"><strong>Subtotal:</strong> <span id="subtotal">R$ 0,00</span></div>
                    <div class="d-flex justify-content-between mt-2">
                        <strong>Total:</strong> <span id="total">R$ 0,00</span>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-success w-100" id="btn-close">Fechar Conta</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ====== MESAS ======
let tables={};
let currentTableId=null;
document.querySelectorAll('.table-card').forEach(c=>{
    const id=c.dataset.id;
    tables[id]={name:c.innerText.split('-')[0].trim(), order:[]};
    c.addEventListener('click',()=>{
        currentTableId=id;
        document.getElementById('currentTableName').innerText=tables[id].name;
        document.querySelectorAll('.table-card').forEach(tc=>tc.classList.remove('active'));
        c.classList.add('active');
        renderOrder();
    });
});

// ====== PRODUTOS ======
let products=[];
document.querySelectorAll('.product-card').forEach(c=>{
    products.push({
        id:c.dataset.id,
        sku:c.dataset.sku,
        name:c.dataset.name,
        price:parseFloat(c.dataset.price),
        category:c.dataset.category
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

// Botões adicionar
document.querySelectorAll('.add-btn').forEach(btn=>{
    btn.addEventListener('click',e=>{
        addToCartById(e.target.closest('.product-card').dataset.id);
    });
});

// ====== FILTRO ======
document.querySelectorAll('#categoryFilters button').forEach(btn=>{
    btn.addEventListener('click',()=>{
        document.querySelectorAll('#categoryFilters button').forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
        const cat=btn.dataset.category;
        document.querySelectorAll('.product-wrapper').forEach(col=>{
            const card=col.querySelector('.product-card');
            col.style.display=(cat==='all'||card.dataset.category===cat)?'none':'none';
            if(cat==='all'||card.dataset.category===cat) col.style.display='';
        });
    });
});

// ====== CARRINHO ======
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
    document.getElementById('subtotal').innerText='R$ '+subtotal.toFixed(2).replace('.',',');
    document.getElementById('total').innerText='R$ '+subtotal.toFixed(2).replace('.',',');
}

// Remover / alterar qtd
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

// Fechar conta
document.getElementById('btn-close').addEventListener('click',()=>{
    if(!currentTableId||tables[currentTableId].order.length===0){ alert('Nenhum item!'); return; }
    alert(`Conta de ${tables[currentTableId].name} fechada.\nTotal: ${document.getElementById('total').innerText}`);
    tables[currentTableId].order=[];
    renderOrder();
});
</script>
</body>
</html>
