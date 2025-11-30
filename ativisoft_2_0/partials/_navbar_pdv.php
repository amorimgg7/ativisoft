 <div id="load" class="" style="z-index: 1050; dosplay:none;">
    <?php include("../../partials/load.html");?>
  </div>
<style>
section {
    display: none;
    padding: 1rem;
    border: 1px solid #ccc;
    margin-top: 1rem;
    border-radius: 6px;
    background: #f9f9f9;
}
section.active {
    display: block;
}
button {
    margin-right: 0.5rem;
    padding: 0.5rem 1rem;
}
</style>
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top  flex-row" style="background-color: #ddd;" <?php echo $_SESSION['c_navbar']?>>
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" >
      
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="m-0">PDV - Ativisoft</h3>
    
</div></div>
<div class="navbar-menu-wrapper d-flex align-items-center justify-content-end"  >
    <div class="d-flex gap-2">
        <button class="btn btn-danger" id="btn-reset"><i class="bi bi-cart-x"></i></button>
        <!--<button class="btn btn-primary" id="btn-finalizar">Finalizar Venda</button>-->
        <button class="btn btn-info top-btn" id="btn-principal" style="display:none;" onclick="showSection('principal')"><i class="bi bi-shop"></i></button>
        <button class="btn btn-info top-btn" id="btn-historico" onclick="showSection('historico')"><i class="bi bi-clock-history"></i></button>
        <button class="btn btn-info top-btn" id="btn-integracao" onclick="showSection('integracao')"><i class="bi bi-nut"></i></button>
    </div>
      </div>
  </nav>
<div style="height:70px;"></div>
<script>
function showSection(id) {
    // Esconde todas as seções
    document.querySelectorAll('section').forEach(sec => sec.classList.remove('active'));
    // Mostra a seção desejada
    document.getElementById(id).classList.add('active');

    // Resetar todos os botões (voltar a mostrar)
    document.querySelectorAll('.top-btn').forEach(btn => btn.style.display = 'inline-block');

    // Se for histórico, esconda o botão
    
        document.getElementById("btn-"+id).style.display = 'none';
    
}

</script>

