<nav class="navbar fixed-top p-3 align-items-center" >
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" <?php echo $_SESSION['c_navbar']?>>
    <a class=" navbar-brand brand-logo" href="<?php $_SESSION['dominio'];?>"><img src="<?php $_SESSION['dominio'];?>images/logo-mini.svg" alt="logo"/></a>
    <a class="navbar-brand brand-logo-mini" href="<?php $_SESSION['dominio'];?>"><img src="<?php $_SESSION['dominio'];?>images/logo-mini.svg" alt="logo"/></a>
  </div>
  <div class="navbar-menu-wrapper ">
    <script>
      function updateContent2() {
        fetch('../../partials/p3.php')
        .then(response => response.text())
        .then(data => {
          document.getElementById('content2').innerHTML = data;
        })
        .catch(error => console.error('Erro:', error));
      }
      setInterval(updateContent2, 1000);
      window.onload = updateContent2;
    </script>
    <div style="width:100" id="content2"><h1>Carregando #1...</h1></div>
  </div>
</nav>