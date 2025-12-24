<?php
session_start();

if (!isset($_SESSION['ultima_venda'])) {
    header('Location: index.php');
    exit;
}

$cd_venda = $_SESSION['ultima_venda'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Confirmar impressão</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- MODAL -->
<div class="modal fade" id="modalImpressao" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Imprimir comprovante?</h5>
      </div>

      <div class="modal-body text-center">
        Deseja imprimir o comprovante desta venda?
      </div>

      <div class="modal-footer justify-content-center">
        <a href="0_comprovante.php?cd_venda=<?= $cd_venda ?>"
           class="btn btn-secondary">
          Não
        </a>

        <a href="0_comprovante.php?print=1&cd_venda=<?= $cd_venda ?>"
           class="btn btn-success">
          Sim, imprimir
        </a>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const modal = new bootstrap.Modal(document.getElementById('modalImpressao'));
  modal.show();
</script>

</body>
</html>
