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
<footer class="footer" >
  <div class="d-sm-flex justify-content-center justify-content-sm-between"> 
    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">AtiviSoft © sistema.ativisoft.com.br 2025</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Version 2.0 | Release: 0.00 | <br><p><?php echo "PHP:".phpversion();?></p><h3>B E T A</h3></span>
  </div>
</footer>
