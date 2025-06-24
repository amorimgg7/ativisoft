<?php
    
    if(!isset($_SESSION['dominio']))
    {
      session_start();
      require_once('classes/conn.php');
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ativisoft - Sistema de Gestão</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

  <header class="bg-primary text-white text-center py-5">
    <div class="container">

        <a 
      href="<?php echo $_SESSION['dominio']?>/pages/samples/login.php"  
      class="btn btn-light position-absolute top-0 end-0 m-3"
      style="z-index: 10;"
    >
      Entrar
    </a>

    
      <!--<h1 class="mt-3">. . .</h1>-->
      <p class="lead">Simplifique sua gestão com nosso sistema inteligente</p>
    </div>
  </header>

  <main class="container my-5">
    <section class="text-center mb-5">
      <h2>Conheça o Sistema</h2>
      <img 
        src="https://sistema.ativisoft.com.br/marketing/images/Logo_2.png" 
        alt="Logo Ativisoft" 
        class="mx-auto d-block img-fluid" 
        style="max-width: 150px;"
      />
      <p>Com o Ativisoft, você gerencia clientes, orçamentos, vendas e relatórios de forma simples, ágil e segura.</p>
    </section>

    <section class="bg-light p-4 rounded mb-5">
        <h2 class="text-center mb-4">Funcionalidades</h2>
        <div id="carouselFuncionalidades" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">
          <div class="carousel-inner text-center">
            <div class="carousel-item active">
              <h5 class="text-primary">Cadastro e histórico de clientes</h5>
              <p>Visualize e gerencie todas as interações com seus clientes em um só lugar.</p>
            </div>
            <div class="carousel-item">
              <h5 class="text-primary">Emissão de orçamentos e controle de vendas</h5>
              <p>Gere orçamentos profissionais com agilidade e acompanhe cada venda.</p>
            </div>
            <div class="carousel-item">
              <h5 class="text-primary">Relatórios automáticos e exportação para PDF</h5>
              <p>Tenha relatórios claros e rápidos em PDF com apenas um clique.</p>
            </div>
            <div class="carousel-item">
              <h5 class="text-primary">Acesso via computador e celular</h5>
              <p>Use o sistema de onde estiver, com acesso adaptado para qualquer tela.</p>
            </div>
          </div>
        </div>
      </section>
      

    <section class="text-center">
      <h2>Comece a Usar Agora</h2>
      <p>Cadastre-se gratuitamente e use o sistema por 7 dias sem compromisso.</p>
      <a href="https://sistema.ativisoft.com.br/pages/samples/register.php" class="btn btn-primary btn-lg mx-2 mb-3">Criar Conta Grátis</a>
      <p>Ou fale conosco pelo WhatsApp:</p>
      <a 
        href="https://api.whatsapp.com/send?phone=5521960150200&text=Ol%C3%A1%2C+quero+testar+o+sistema+Ativisoft%21" 
        class="btn btn-success btn-lg mx-2"
      >
        Falar pelo WhatsApp
      </a>
    </section>
  </main>

  <footer class="bg-dark text-light text-center py-3 mt-5">
    <div class="container">
      <p class="mb-1">&copy; 2025 Ativisoft. Todos os direitos reservados.</p>
      <p class="mb-0">Contato: suporte@ativisoft.com.br</p>
    </div>
  </footer>

  <!-- Bootstrap JS Bundle CDN (Popper + JS) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
