<?php
    session_start();

    
    if(isset($_SESSION['cd_colab']))
    {
        //header("location: http://amorimgg77.lovestoblog.com/pages/samples/login.php");
        //echo '<script>location.href="'.$_SESSION['dominio'].'pages/samples/login.php";</script>';
        echo '<script>location.href="'.$_SESSION['dominio'].'pages/dashboard/index.php";</script>';   
        //echo '<script>location.href="'.$_SESSION['dominio'].'pages/samples/login.php";</script>';    
        exit;
    }else{
        //echo '<script>location.href="'.$_SESSION['dominio'].'pages/dashboard/index.php";</script>';    
        //exit;
    }
    //require_once 'classes/conn.php';
    
    //include("classes/functions.php");
    //conectar($_SESSION['cnpj_empresa']);

    //$u = new Usuario;
    
    
?><!--Validar sessão aberta, se usuário está logado.-->



<!DOCTYPE html>
<html lang="pf-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AtiviSoft</title>
    <link rel="stylesheet" href="./marketing/vendors/animate.css/animate.min.css">
    <link rel="stylesheet" href="./marketing/vendors/slick-carousel/slick.css">
    <link rel="stylesheet" href="./marketing/vendors/slick-carousel/slick-theme.css">
    <link rel="stylesheet" href="marketing/css/style.css">
    <script src="marketing/vendors/jquery/jquery.min.js"></script>
    <script src="marketing/js/loader.js"></script>
</head>

<body>
    <div class="oleez-loader"></div>
    <header class="oleez-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="index.php"><img src="marketing/images/Logo_2.png" alt="AtiviSoft" width="300px" height="100px"></a>
            <ul class="nav nav-actions d-lg-none ml-auto">
                
                <li class="nav-item">
                    <a class="nav-link" href="#!" data-toggle="offCanvasMenu">
                        <img src="marketing/images/social icon@2x.svg" alt="social-nav-toggle">
                    </a>
                </li>
            </ul>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#oleezMainNav"
                aria-controls="oleezMainNav" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="oleezMainNav">
                <ul class="navbar-nav mx-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <!--
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#!" id="portfolioDropdown" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Personas</a>
                        <div class="dropdown-menu" aria-labelledby="portfolioDropdown">
                            <a class="dropdown-item" href="portfolio/portfolio-profissional.html">Profissionais</a>
                            <a class="dropdown-item" href="portfolio/portfolio-contratante.html">Empregadores</a>
                            <a class="dropdown-item" href="portfolio/portfolio-patrocinio.html">Patrocinio / Fianciamento</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#!" id="blogDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Fórum</a>
                        <div class="dropdown-menu" aria-labelledby="blogDropdown">
                            <a class="dropdown-item" href="forum/pontospositivos.html">Pontos positivos</a>
                            <a class="dropdown-item" href="forum/pontosnegativos.html">Pontos Negatívos</a>
                            <a class="dropdown-item" href="forum/financiamento.html">Financiamento</a>
                        </div>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link" href="pages/samples/login.php">Acessar <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <ul class="navbar-nav d-none d-lg-flex">
                    <li class="nav-item ml-5">
                        <a class="nav-link pr-0 nav-link-btn" href="#!" data-toggle="offCanvasMenu">
                            <img src="marketing/images/social icon@2x.svg" alt="social-nav-toggle">
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        
        <section>
            <div class="container wow fadeIn">
                <div id="oleezLandingCarousel" class="oleez-landing-carousel carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img src="marketing/images/Banner_1@2x.jpg" alt="First slide" class="w-100">
                            <div class="carousel-caption">
                                <h2 data-animation="animated fadeInRight"><span>Maior</span></h2>
                                <h2 data-animation="animated fadeInRight"><span>Agilidade</span></h2>
                                <a href="#!" class="carousel-item-link" data-animation="animated fadeInRight">EXPLORE PROJECT</a>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="marketing/images/Banner_2@2x.jpg" alt="Second slide" class="w-100">
                            <div class="carousel-caption">
                                <h2 data-animation="animated fadeInRight"><span>Maior</span></h2>
                                <h2 data-animation="animated fadeInRight"><span>Transparência</span></h2>
                                <a href="#!" class="carousel-item-link" data-animation="animated fadeInRight">EXPLORE PROJECT</a>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="marketing/images/Banner_3@2x.jpg" alt="Third slide" class="w-100">
                            <div class="carousel-caption">
                                <h2 data-animation="animated fadeInRight"><span>Menor</span></h2>
                                <h2 data-animation="animated fadeInRight"><span>Desorganização</span></h2>
                                <a href="#!" class="carousel-item-link" data-animation="animated fadeInRight">EXPLORE PROJECT</a>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="marketing/images/Banner_4@2x.jpg" alt="Fourth slide" class="w-100">
                            <div class="carousel-caption">
                                <h2 data-animation="animated fadeInRight"><span>Atividade em</span></h2>
                                <h2 data-animation="animated fadeInRight"><span>Software</span></h2>
                                <a href="#!" class="carousel-item-link" data-animation="animated fadeInRight">EXPLORE PROJECT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<!--
        <section class="oleez-landing-section oleez-landing-section-about">
            <div class="container">
                <div class="oleez-landing-section-content">
                    <div class="oleez-landing-section-verticals wow fadeIn">
                        <span class="number">01</span> <img src="assets/images/Logo_2.svg" alt="ollez" height="12px">
                    </div>
                    <div class="row landing-about-content wow fadeInUp">
                        <div class="col-md-6">
                            <h2>Nossa missão e valores são.</h2>
                        </div>
                        <div class="col-md-6">
                            <p>Oferecer moradia dígna em troca da mão de obra de forma justa.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 landing-about-feature wow fadeInUp">
                            <img src="marketing/images/icon_1.svg" alt="document" class="about-feature-icon">
                            <h5 class="about-feature-title">Movimentar Renda</h5>
                            <p class="about-feature-description">Fomentar o mercado imobiliário e prestação de serviço.</p>
                        </div>
                        <div class="col-md-4 landing-about-feature wow fadeInUp">
                            <img src="marketing/images/icon_2.svg" alt="document" class="about-feature-icon">
                            <h5 class="about-feature-title">Ação Social</h5>
                            <p class="about-feature-description">Estimular o bem comum da sociedade com o próximo, acolhendo, incentivando e capacitando ao correto desenvolvimento da mão de obra.</p>
                        </div>
                        <div class="col-md-4 landing-about-feature wow fadeInUp">
                            <img src="marketing/images/icon_3.svg" alt="document" class="about-feature-icon">
                            <h5 class="about-feature-title">Utilidade Pública</h5>
                            <p class="about-feature-description">Com toda a nossa campanha desejamos alcançar a redução na taxa de suicídio e moradia indígna da população carente que necessita de amparo e estímulos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="oleez-landing-section oleez-landing-section-projects">
            <div class="container">
                <div class="oleez-landing-section-content">
                    <div class="oleez-landing-section-verticals wow fadeIn">
                        <span class="number">02</span> <img src="assets/images/Logo_2.svg" alt="oleez" height="12px">
                    </div>
                    <h2 class="section-title wow fadeInUp">Personas <a href="#!" class="all-projects-link">View All</a></h2>
                    <h6 class="project-category">Vale ressaltar que as personas apresentadas são pessoas reais em situação de rua ou moradia precária mas cheias de folego e ânimo para vencer na vida fazendo aquilo que sabem fazer de melhor, dê uma nova chance para o crescimento e não se arrependerá.</h6>
                    <div class="landing-projects-carousel wow fadeIn">
                        <div class="card landing-project-card">
                            <img src="marketing/images/Project_1@2x.jpg" class="card-img" alt="Project 1">
                            <div class="card-img-overlay">
                                <h6 class="project-category">Ana Silva</h6>
                                <h5 class="project-title">32 anos, recepcionista e camareira.</h5>
                            </div>
                        </div>
                        <div class="card landing-project-card">
                            <img src="marketing/images/Project_2@2x.jpg" class="card-img" alt="Project 1">
                            <div class="card-img-overlay">
                                <h6 class="project-category">Karla Moreira</h6>
                                <h5 class="project-title">28 anos, produtora de eventos.</h5>
                            </div>
                        </div>
                        <div class="card landing-project-card">
                            <img src="marketing/images/Project_3@2x.jpg" class="card-img" alt="Project 1">
                            <div class="card-img-overlay">
                                <h6 class="project-category">Carlos Santos</h6>
                                <h5 class="project-title">42 anos, motorista particular.</h5>
                            </div>
                        </div>
                        <div class="card landing-project-card">
                            <img src="marketing/images/Project_4@2x.jpg" class="card-img" alt="Project 1">
                            <div class="card-img-overlay">
                                <h6 class="project-category">Judite Moraes</h6>
                                <h5 class="project-title">54 anos, cozinheira e cuidadora de criança.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="slick-navbtn-wrapper"></div>
                </div>
            </div>
        </section>

        <section class="oleez-landing-section oleez-landing-section-team">
            <div class="container">
                <div class="oleez-landing-section-content">
                    <div class="oleez-landing-section-verticals wow fadeIn">
                        <span class="number">03</span> <img src="assets/images/Logo_2.svg" alt="ollez" height="12px">
                    </div>
                    <div class="row landing-team-content wow fadeInUp">
                        <div class="col-md-6">
                            <h2 class="section-title">Histórias de sucesso <br> verdadeiras superações</h2>
                        </div>
                        <div class="col-md-6">
                            <p>Pessoas que foram de encontro a natureza da sua antiga situação e deram um passo a frente com o pé direito.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-5 mb-md-0 landing-team-card wow flipInY">
                            <img src="marketing/images/Team_3@2x.jpg" alt="Team Member" class="team-card-img">
                            <h5 class="team-card-name">Jorge Medina</h5>
                            <p class="team-card-job">Mestre de Obras</p>
                            <nav class="team-card-social-links">
                                <a href="#!">Fb</a>
                                <a href="#!">Tw</a>
                                <a href="#!">In</a>
                            </nav>
                        </div>
                        <div class="col-md-4 mb-5 mb-md-0 landing-team-card wow flipInY">
                                <img src="marketing/images/Team_2@2x.jpg" alt="Team Member" class="team-card-img">
                                <h5 class="team-card-name">Raquel Antunes</h5>
                                <p class="team-card-job">Motorista, categoria <bold>E</bold> (veículos pesados)</p>
                                <nav class="team-card-social-links">
                                    <a href="#!">Fb</a>
                                    <a href="#!">Tw</a>
                                    <a href="#!">In</a>
                                </nav>
                        </div>
                        <div class="col-md-4 mb-5 mb-md-0 landing-team-card wow flipInY">
                                <img src="marketing/images/Team_1@2x.jpg" alt="Team Member" class="team-card-img">
                                <h5 class="team-card-name">Thiago Braz</h5>
                                <p class="team-card-job">Estoquista experiente</p>
                                <nav class="team-card-social-links">
                                    <a href="#!">Fb</a>
                                    <a href="#!">Tw</a>
                                    <a href="#!">In</a>
                                </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="oleez-landing-section oleez-landing-section-client">
            <div class="container">
                <div class="oleez-landing-section-content">
                    <div class="oleez-landing-section-verticals wow fadeIn">
                        <span class="number">04</span> <img src="assets/images/Logo_2.svg" alt="ollez" height="12px">
                    </div>
                    <h2 class="section-title mb-1 wow fadeInUp">Parceiros & Patrocinadores</h2>
                    <p class="client-section-subtitle">Empresas e pessoas que nos ajudam a escrever todas estas histórias de sucesso!</p>
                    <div class="row">
                        <div class="col-md-4 client-logo-wrapper wow flipInX">
                            <div class="client-logo">
                                <img src="marketing/images/client_4.png" alt="client" height="50px">
                            </div>
                        </div>
                        <div class="col-md-4 client-logo-wrapper wow flipInX">
                            <div class="client-logo">
                                <img src="marketing/images/client_2.png" alt="client" height="50px">
                            </div>
                        </div>
                        <div class="col-md-4 client-logo-wrapper wow flipInX">
                            <div class="client-logo">
                                <img src="marketing/images/client_1.png" alt="client" height="50px">
                            </div>
                        </div>
                        <div class="col-md-4 client-logo-wrapper wow flipInX">
                            <div class="client-logo">
                                <img src="marketing/images/client_6.png" alt="client" height="50px">
                            </div>
                        </div>
                        <div class="col-md-4 client-logo-wrapper wow flipInX">
                            <div class="client-logo">
                                <img src="marketing/images/client_3.png" alt="client" height="50px">
                            </div>
                        </div>
                        <div class="col-md-4 client-logo-wrapper wow flipInX">
                            <div class="client-logo">
                                <img src="marketing/images/client_5.png" alt="client" height="50px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="oleez-landing-section oleez-landing-section-news">
            <div class="container">
                <div class="oleez-landing-section-content">
                    <div class="oleez-landing-section-verticals wow fadeIn">
                        <span class="number">05</span> <img src="assets/images/Logo_2.svg" alt="ollez" height="12px">
                    </div>
                    <h2 class="section-title wow fadeInUp">Atualizações de sucesso!.</h2>
                    <p class="news-section-subtitle wow fadeInUp">Espaço dedicado ao alavanque de nossos melhores colaboradores e suas postagens. Seu reconhecimento diário.</p>
                    <div class="row">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="news-card news-card-1 wow fadeInUp">
                                <div class="card-body">
                                    <div class="author-info media">
                                        <img src="marketing/images/Team_1_Copy_2@2x.jpg" alt="author" class="author-avatar">
                                        <div class="media-body">
                                            <h6 class="author-name">Postado por Juliana</h6>
                                            <p class="news-post-date">5 de Julho, 2023</p>
                                        </div>
                                    </div>
                                    <div class="post-meta">
                                        <span class="post-category">Profissional: </span>Cheff de cozinha
                                    </div>
                                    <h5 class="post-title">Trabalhei muito... .</h5>
                                    <a href="#!" class="post-permalink">Histórico de postagens</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="news-card news-card-2 wow fadeInUp">
                                <div class="card-body">
                                    <div class="author-info media">
                                        <img src="marketing/images/Team_2_Copy_2@2x.jpg" alt="author" class="author-avatar">
                                        <div class="media-body">
                                            <h6 class="author-name">Postado por Luiz</h6>
                                            <p class="news-post-date">5 de agosto, 2023</p>
                                        </div>
                                    </div>
                                    <div class="post-meta">
                                        <span class="post-category">Empregador(a): </span> Aposentado, ex servidor público
                                    </div>
                                    <h5 class="post-title">Hoje tive o prazer de receber o Sr. Antonio em minha casa, um senhor muito engraçado, espero que tenha sucesso.</h5>
                                    <a href="#!" class="post-permalink">Histórico de postagens</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="news-card news-card-3 wow fadeInUp">
                                <div class="card-body">
                                    <div class="author-info media">
                                        <img src="marketing/images/Team_3_Copy_2@2x.jpg" alt="author" class="author-avatar">
                                        <div class="media-body">
                                            <h6 class="author-name">Posted by Angela</h6>
                                            <p class="news-post-date">9 de Setembro, 2023</p>
                                        </div>
                                    </div>
                                    <div class="post-meta">
                                        <span class="post-category">Empregador(a): </span> Dona de hotéis
                                    </div>
                                    <h5 class="post-title">Tive aumento na qualidade dos serviços de toda minha rede de hotéis, excelentes colaboradores e ótimo suporte prestado pela plataforma. Grata!</h5>
                                    <a href="#!" class="post-permalink">Histórico de postagens</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="oleez-landing-section oleez-landing-section-testimonials">
            <div class="container">
                <div class="oleez-landing-section-content">
                    <div class="oleez-landing-section-verticals wow fadeIn">
                        <span class="number">05</span> <img src="assets/images/Logo_2.svg" alt="ollez" height="12px">
                    </div>
                    <div class="d-md-flex justify-content-between wow fadeInUp">
                        <div class="testimonial-section-content">
                            <h2 class="section-title">What our clients say</h2>
                            <p class="section-subtitle">Share your stories and news with everyone.</p>
                        </div>
                        <div class="testimonial-carousel-navbtn-wrapper"></div>
                    </div>
                    <div class="landing-testimonial-carousel wow fadeInUp">
                        <div class="landing-testimonial-card">
                            <div class="media">
                                <img src="marketing/images/Client_1@2x.jpg" alt="client" class="testimonial-card-img">
                                <div class="media-body">
                                    <p class="testimonial-card-content">
                                        The revulsion in our feelings was therefore all the greater when the car suddenly escaped from this height of desolation, and a magnificent prospect burst upon our view.
                                    </p>
                                    <h6 class="testimonial-card-name">Winnie Warner</h6>
                                    <p class="testimonial-card-company">Creative Company</p>
                                </div>
                            </div>
                        </div>
                        <div class="landing-testimonial-card">
                            <div class="media">
                                <img src="marketing/images/Client_2@2x.jpg" alt="client" class="testimonial-card-img">
                                <div class="media-body">
                                    <p class="testimonial-card-content">
                                        The revulsion in our feelings was therefore all the greater when the car suddenly escaped from this height of desolation, and a magnificent prospect burst upon our view.
                                    </p>
                                    <h6 class="testimonial-card-name">Wesley Ford</h6>
                                    <p class="testimonial-card-company">Creative Company</p>
                                </div>
                            </div>
                        </div>
                        <div class="landing-testimonial-card">
                            <div class="media">
                                <img src="marketing/images/Client_3@2x.jpg" alt="client" class="testimonial-card-img">
                                <div class="media-body">
                                    <p class="testimonial-card-content">
                                        The revulsion in our feelings was therefore all the greater when the car suddenly escaped from this height of desolation, and a magnificent prospect burst upon our view.
                                    </p>
                                    <h6 class="testimonial-card-name">Winnie Warner</h6>
                                    <p class="testimonial-card-company">Creative Company</p>
                                </div>
                            </div>
                        </div>
                        <div class="landing-testimonial-card">
                            <div class="media">
                                <img src="marketing/images/Client_4@2x.jpg" alt="client" class="testimonial-card-img">
                                <div class="media-body">
                                    <p class="testimonial-card-content">
                                        The revulsion in our feelings was therefore all the greater when the car suddenly escaped from this height of desolation, and a magnificent prospect burst upon our view.
                                    </p>
                                    <h6 class="testimonial-card-name">Wesley Ford</h6>
                                    <p class="testimonial-card-company">Creative Company</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>-->

    </main>

    <footer class="oleez-footer wow fadeInUp">
        <div class="container">
            <div class="footer-content">
                <div class="row">
                    <div class="col-md-6">
                        <img src="marketing/images/Logo_3.png" alt="AtiviSoft" class="footer-logo" width="100px" height="100px">
                        <p class="footer-intro-text">Frase de efeito</p>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6 footer-widget-text">
                                <h6 class="widget-title">TELEFONE</h6>
                                <p class="widget-content">+55 (21) 9 6015 0200</p>
                            </div>
                            <!--
                            <div class="col-md-6 footer-widget-text">
                                <h6 class="widget-title">E-MAIL</h6>
                                <p class="widget-content">homework@business.com</p>
                            </div>-->
                            
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-text">
                <p class="mb-md-0">©  2023, AtiviSoft.</p>
            </div>
        </div>
    </footer>

    <!-- Modals -->
    <!-- Off canvas social menu -->
    <nav id="offCanvasMenu" class="off-canvas-menu">
        <button type="button" class="close" aria-label="Close" data-dismiss="offCanvasMenu">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul class="oleez-social-menu">
            <li>
                <a href="pages/samples/login.php" class="oleez-social-menu-link">Acessar</a>
            </li>
            <!--
                <li>
                <a href="#!" class="oleez-social-menu-link">Instagram</a>
            </li>
            <li>
                <a href="#!" class="oleez-social-menu-link">Behance</a>
            </li>
            <li>
                <a href="#!" class="oleez-social-menu-link">Dribbble</a>
            </li>
            <li>
                <a href="#!" class="oleez-social-menu-link">Email</a>
            </li>-->
        </ul>
    </nav>
    <!-- Full screen search box -->
    <div id="searchModal" class="search-modal">
        <button type="button" class="close" aria-label="Close" data-dismiss="searchModal">
            <span aria-hidden="true">&times;</span>
        </button>
        <form action="index.html" method="get" class="oleez-overlay-search-form">
            <label for="search" class="sr-only">Search</label>
            <input type="search" class="oleez-overlay-search-input" id="search" name="search" placeholder="Search here">
        </form>
    </div>
    <script src="marketing/vendors/popper.js/popper.min.js"></script>
    <script src="marketing/vendors/wowjs/wow.min.js"></script>
    <script src="marketing/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="marketing/vendors/slick-carousel/slick.min.js"></script>
    <script src="marketing/js/main.js"></script>
    <script src="marketing/js/landing.js"></script>
    <script>
        new WOW({mobile: false}).init();
    </script>
</body>


</html>