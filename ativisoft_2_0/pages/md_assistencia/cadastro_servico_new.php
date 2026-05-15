<?php
// Exemplo de array de serviços (depois você substitui pelo SELECT do banco)
$servicos = [
    ["id" => 1, "titulo" => "Instalação de Impressora", "cliente" => "Padaria Pão Quente", "status" => "pendente"],
    ["id" => 2, "titulo" => "Manutenção no Servidor", "cliente" => "Loja do João", "status" => "concluido"],
    ["id" => 3, "titulo" => "Visita Técnica", "cliente" => "Mercado Ideal", "status" => "em_andamento"],
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Serviços</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f4f4;
        }
        .status-pendente { color: #b30000; font-weight: bold; }
        .status-em_andamento { color: #cc8800; font-weight: bold; }
        .status-concluido { color: #008000; font-weight: bold; }
        .card-servico { transition: .2s; }
        .card-servico:hover { transform: scale(1.02); }
    </style>
</head>
<body>

<div class="container py-4">

    <div class="d-flex justify-content-between mb-3">
        <h3 class="fw-bold">Gestão de Serviços</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalServico">+ Novo Serviço</button>
    </div>

    <!-- Barra de busca + filtro -->
    <div class="row mb-3">
        <div class="col-8 col-md-9">
            <input type="text" id="buscar" placeholder="Buscar serviço ou cliente..." class="form-control">
        </div>
        <div class="col-4 col-md-3">
            <select id="filtroStatus" class="form-select">
                <option value="">Todos</option>
                <option value="pendente">Pendente</option>
                <option value="em_andamento">Em andamento</option>
                <option value="concluido">Concluído</option>
            </select>
        </div>
    </div>

    <!-- Lista de serviços -->
    <div id="listaServicos">
        <?php foreach($servicos as $s): ?>
        <div class="card card-servico mb-3 servico-item" 
             data-status="<?= $s['status'] ?>"
             data-texto="<?= strtolower($s['titulo'] . ' ' . $s['cliente']) ?>">

            <div class="card-body">
                <h5 class="card-title"><?= $s["titulo"] ?></h5>
                <p class="card-text mb-1">Cliente: <?= $s["cliente"] ?></p>
                <p class="status-<?= $s['status'] ?>">Status: <?= ucfirst(str_replace('_',' ', $s['status'])) ?></p>

                <button class="btn btn-sm btn-outline-primary">Editar</button>
                <button class="btn btn-sm btn-outline-danger">Excluir</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>

<!-- Modal para criar/editar serviço -->
<div class="modal fade" id="modalServico" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Novo Serviço</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="formServico">
            <div class="mb-3">
                <label>Título do Serviço</label>
                <input type="text" class="form-control" name="titulo">
            </div>

            <div class="mb-3">
                <label>Cliente</label>
                <input type="text" class="form-control" name="cliente">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="pendente">Pendente</option>
                    <option value="em_andamento">Em andamento</option>
                    <option value="concluido">Concluído</option>
                </select>
            </div>

            <button class="btn btn-primary w-100">Salvar</button>
        </form>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Filtro de texto
document.getElementById('buscar').addEventListener('input', function() {
    let texto = this.value.toLowerCase();
    document.querySelectorAll('.servico-item').forEach(card => {
        let conteudo = card.dataset.texto;
        card.style.display = conteudo.includes(texto) ? '' : 'none';
    });
});

// Filtro por status
document.getElementById('filtroStatus').addEventListener('change', function() {
    let status = this.value;
    document.querySelectorAll('.servico-item').forEach(card => {
        card.style.display =
            status === "" || card.dataset.status === status ? '' : 'none';
    });
});
</script>

</body>
</html>
