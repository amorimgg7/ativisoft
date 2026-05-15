<?php
session_start();

require_once '../../classes/conn.php';
include("../../classes/functions.php");

$u = new Usuario;

if (!isset($_SESSION['ultima_venda'])) {
    header('Location: pdv_balcao.php');
    exit;
}

$venda = $_SESSION['ultima_venda'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Comprovante</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* ===== LAYOUT TÉRMICO 80MM ===== */
body {
    font-family: monospace;
    background: #fff;
}

.comprovante {
    width: 80mm;
    margin: auto;
    font-size: 12px;
}

.center { text-align: center; }
.right  { text-align: right; }

hr {
    border: none;
    border-top: 1px dashed #000;
    margin: 6px 0;
}

.linha {
    display: flex;
    justify-content: space-between;
}

@media print {
    body * { visibility: hidden; }
    .comprovante, .comprovante * {
        visibility: visible;
    }
    .comprovante {
        position: absolute;
        left: 0;
        top: 0;
    }
    .modal { display: none !important; }
}
</style>
</head>
<body>

<div class="comprovante">

    <div class="center">
        <strong>*** COMPROVANTE ***</strong><br>
        Data: <?= $venda['data'] ?>
    </div>

    <hr>

    <?php foreach ($venda['itens'] as $item): ?>
        <div>
            <?= $item['qtd_orcamento'] ?>x <?= $item['name'] ?>
        </div>
        <div class="linha">
            <span></span>
            <span>R$ <?= number_format($item['price'] * $item['qtd_orcamento'], 2, '.', '.') ?></span>
        </div>
        
    <?php endforeach; ?>

    <hr>

    <div class="linha">
        <span>Subtotal</span>
        <span>R$ <?= number_format($venda['subtotal'],2,'.','.') ?></span>
    </div>
    <div class="linha">
        <span>Desconto</span>
        <span>R$ <?= number_format($venda['desconto'],2,'.','.') ?></span>
    </div>
    <div class="linha">
        <strong>Total</strong>
        <strong>R$ <?= number_format($venda['total'],2,'.','.') ?></strong>
    </div>

    <hr>

    <div class="center">
        Obrigado pela preferência!
    </div>

</div>

<!-- MODAL -->
<div class="modal fade" id="modalPergunta" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
        <?php
            $ultima_venda = $_SESSION['ultima_venda'] ?? null;

            // JSON_PRETTY_PRINT e JSON_UNESCAPED_UNICODE continuam funcionando normalmente no 8.3
            $json = json_encode($ultima_venda, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            if ($json === false) {
                echo '<pre id="jsonAcesso">Erro ao gerar JSON: ' . json_last_error_msg() . '</pre>';
            } else {

                //echo '<pre id="jsonAcesso">' . $json . '</pre>';

                // 🔽 Converte JSON para array PHP
                $dados = json_decode($json, true);

                if ($dados !== null && isset($dados['cd_venda'])) {
                    $cd_venda_impressao = $dados['cd_venda'];
                } else {
                    echo "Erro ao ler cd_venda do JSON";
                }
            }

            $result_impressao   = $u->impressao1($_SESSION['tipo_impressao'], 'PDV', $_SESSION['cd_empresa'], $cd_venda_impressao);
            //echo $result_impressao['partial_impressao'];
        ?>
      <div class="modal-header">
        <h6 class="modal-title">Imprimir comprovante?</h6>
      </div>
        
      <div class="modal-footer d-flex gap-2">
        <button id="btnNao" class="btn btn-secondary w-100">Não</button>
        <!--<button id="btnSim" class="btn btn-success w-100">Sim</button>-->
        <?php            echo $result_impressao['partial_impressao'];        ?>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
    /*
document.addEventListener("DOMContentLoaded", function () {

    const modal = new bootstrap.Modal(document.getElementById('modalPergunta'), {
        backdrop: 'static',
        keyboard: false
    });

    modal.show();

    // NÃO IMPRIMIR
    document.getElementById('btnNao').onclick = () => {
        window.location.href = 'pdv_balcao.php';
    };

    // IMPRIMIR
    document.getElementById('btnSim').onclick = () => {
        modal.hide();
        setTimeout(() => window.print(), 300);
    };

    // APÓS FECHAR A IMPRESSÃO
    window.addEventListener('afterprint', () => {
        window.location.href = 'pdv_balcao.php';
    });

});
*/
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {

    const modalEl = document.getElementById('modalPergunta');

    // ❗ SE NÃO EXISTE, NÃO INICIALIZA
    if (!modalEl) return;

    const modal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false
    });

    modal.show();

    document.getElementById('btnNao').onclick = () => {
        window.location.href = 'pdv_balcao.php';
    };

    document.getElementById('btnSim').onclick = () => {
        modal.hide();
        setTimeout(() => window.print(), 300);
    };

    window.addEventListener('afterprint', () => {
        window.location.href = 'pdv_balcao.php';
    });

});
</script>



</body>
</html>
