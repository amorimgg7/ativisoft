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
    <title>Comece Já</title>
    <link rel="stylesheet" href="./marketing/vendors/animate.css/animate.min.css">
    <link rel="stylesheet" href="./marketing/vendors/slick-carousel/slick.css">
    <link rel="stylesheet" href="./marketing/vendors/slick-carousel/slick-theme.css">
    <link rel="stylesheet" href="marketing/css/style.css">
    <script src="marketing/vendors/jquery/jquery.min.js"></script>
    <script src="marketing/js/loader.js"></script>
    <style>
        .button {
            background-color: white;
            color: black;
            border: 2px solid #555555;
            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .button5:hover {
            background-color: #555555;
            color: white;
        }
    </style>
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="captar.php">O sistema<span class="sr-only"></span></a>
                    </li>
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
        <!--
        <section>
            <div class="container wow fadeIn">
                <div id="oleezLandingCarousel" class="oleez-landing-carousel carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img src="https://lh3.googleusercontent.com/pw/AP1GczN2mbTyUzjM7pgHYvsRu-MMNZFQRvbYaEbVoR4kAr7v6iJGX-Oqq-FL8RQOFmflI8ynM4nrzVcG436EHexgCkHtsSDx-kDJwcgI-sbvNcc6pJRLE673AWAzA2iZtC_Fv0iYJZ-xmtGke8UvpbLJ-qXsnQ=w1379-h919-s-no-gm?authuser=0" alt="First slide" class="w-100">
                            <img src="marketing/images/Banner_1@2x.jpg" alt="First slide" class="w-100">
                            <div class="carousel-caption">
                                <h2 data-animation="animated fadeInRight"><span>Maior</span></h2>
                                <h2 data-animation="animated fadeInRight"><span>Agilidade</span></h2>
                                <a href="#!" class="carousel-item-link" data-animation="animated fadeInRight">EXPLORE PROJECT</a>
                            </div>
                        </div>
                        <div class="carousel-item">
                        <img src="https://lh3.googleusercontent.com/pw/AP1GczPd2WMYyPLmKmCZ6ePBPe-OLXOeOFrW9TVGs5yqffKK8cOWWltQ0NHvi1wH4MHFWLnYG-0-4VtmbE9I_HBIKGqdsuAEuHW3pZFmdo1N9HLRj3BAp27n_DKJVzTZ4irS8IuwCRP-IiUkdbnMHcqo3eL4Iw=w1379-h919-s-no-gm?authuser=0" alt="Second slide" class="w-100">
                            <img src="marketing/images/Banner_2@2x.jpg" alt="Second slide" class="w-100">
                            <div class="carousel-caption">
                                <h2 data-animation="animated fadeInRight"><span>Maior</span></h2>
                                <h2 data-animation="animated fadeInRight"><span>Transparência</span></h2>
                                <a href="#!" class="carousel-item-link" data-animation="animated fadeInRight">EXPLORE PROJECT</a>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://lh3.googleusercontent.com/pw/AP1GczMbn1qJ2zROHAU5utQK7bM7-Y92qrhfD14BvRDUPPLcVBS64GPvMAKTi_1c2eB7DWH_wo1WLH96bauUKxahUVAee4KIev2mNGbHjI779bZLmB8CeCs8I_MRQTeF72fxVt4X5-58xmsjkkMVlJqo3NnvOw=w1379-h919-s-no-gm?authuser=0" alt="Third slide" class="w-100">
                            <img src="marketing/images/Banner_3@2x.jpg" alt="Third slide" class="w-100">
                            <div class="carousel-caption">
                                <h2 data-animation="animated fadeInRight"><span>Menor</span></h2>
                                <h2 data-animation="animated fadeInRight"><span>Desorganização</span></h2>
                                <a href="#!" class="carousel-item-link" data-animation="animated fadeInRight">EXPLORE PROJECT</a>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="https://lh3.googleusercontent.com/pw/AP1GczPtaGK7sfROjPSWedE610rWfJp-w2j6NhdedjbRN9v0HUQ8mkbCIwJWEKDBHwLaly4sxDFiqNVpE08lm_A3oK7Fa1WqGuxw_L9bOyGnqgUaQG5kOyBnj-11Jjzyo66F3dORCPh-IhLgLUd0vT2CT0r48A=w500-h500-s-no-gm?authuser=0" alt="Fourth slide" class="w-100">
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
        </section>-->

        <section class="oleez-landing-section oleez-landing-section-about">
            <div class="container">
                <div class="oleez-landing-section-content">
                    <div class="oleez-landing-section-verticals wow fadeIn">
                        <!--<span class="number">01</span> <img src="assets/images/Logo_2.svg" alt="ollez" height="12px">-->
                    </div>
                    <div class="row landing-about-content wow fadeInUp">
                        <div class="col-md-6">
                            <h2>Nossa missão é:</h2>
                            <p>Oferecer organização e potencializar sua produção.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 landing-about-feature wow fadeInUp">
                            <img src="marketing/images/icon_1.svg" alt="document" class="about-feature-icon">
                            <h5 class="about-feature-title">Organização</h5>
                            <p class="about-feature-description">Tenha em mente e na palma da sua mão todos os serviços e informações dos seus clientes.</p>
                        </div>
                        <div class="col-md-4 landing-about-feature wow fadeInUp">
                            <img src="marketing/images/icon_2.svg" alt="document" class="about-feature-icon">
                            <h5 class="about-feature-title">Transparência</h5>
                            <p class="about-feature-description">Permita ao seu cliente acompanhar o status da sua ordem de serviço.</p>
                        </div>
                        <div class="col-md-4 landing-about-feature wow fadeInUp">
                            <img src="marketing/images/icon_3.svg" alt="document" class="about-feature-icon">
                            <h5 class="about-feature-title">Modernidade</h5>
                            <p class="about-feature-description">Prezando a transparencia e a qualidade do contato com o cliente.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="oleez-landing-section oleez-landing-section-news">
            <div class="container">
                <div class="oleez-landing-section-content">
                    <div class="oleez-landing-section-verticals wow fadeIn">
                        <!--<span class="number">05</span> <img src="assets/images/Logo_2.svg" alt="ollez" height="12px">-->
                    </div>
                    <h2 class="section-title wow fadeInUp">Comece já</h2>
                    <p class="news-section-subtitle wow fadeInUp">Solicite agora a criação da sua base e comece a usar o sistema sem compromisso.</p>
                    <div class="row">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="news-card news-card-1 wow fadeInUp">
                                <div class="card-body">
                                    <div class="author-info media">
                                        <div class="media-body">
                                            <h6 class="author-name">Teste grátis</h6>
                                        </div>
                                    </div>
                                    <div class="post-meta">
                                        <h5 class="post-title">Informe seus dados e organize já a sua empresa</h5>
                                    </div>
                                    <a href="marketing/cadastraCliente.php" class="button button5">Clique Aqui</a>
                                </div>
                            </div>
                        </div>
                        <!--
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
                    -->
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="oleez-footer wow fadeInUp">
        <div class="container">
            <div class="footer-content">
                <div class="row">
                    <div class="col-md-6">
                        <img src="marketing/images/Logo_3.png" alt="AtiviSoft" class="footer-logo" width="100px" height="100px">
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
        <form action="index.php" method="get" class="oleez-overlay-search-form">
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