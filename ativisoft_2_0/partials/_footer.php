<script>

  if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
        console.log("Histórico de formulário limpo, evitando duplicidade de informações.");
      }


  window.addEventListener('load', function () {
    document.getElementById('load').style.display = 'none';
  });

  // Garantia extra: esconde após 10 segundos no máximo
  setTimeout(function () {
    document.getElementById('load').style.display = 'none';
  }, 10000); // 10 segundos

</script>
<footer class="footer" <?php echo $_SESSION['c_card'];?>>
  <div class="d-sm-flex justify-content-center justify-content-sm-between"<?php echo $_SESSION['c_card'];?>> 
    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block" <?php echo $_SESSION['c_card'];?>>AtiviSoft © sistema.ativisoft.com.br 2025</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center" <?php echo $_SESSION['c_card'];?>>Version 2.0 | Release: 0.00 | <?php echo $_SESSION['nome_cliente']  ;?> <br><p><?php echo "PHP:".phpversion();?></p><h3>B E T A</h3></span>
  </div>
</footer>
