<?php
session_start();
if(isset($_SESSION['cd_colab'])) {
    echo '<script>location.href="'.$_SESSION['dominio'].'pages/dashboard/index.php";</script>';   
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AtiviSoft - Drivers e Suporte comercial</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3996853854538676" crossorigin="anonymous"></script>

    <style>
        .gradient-bg { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="index.php">
                <img src="marketing/images/Logo_2.png" alt="AtiviSoft" class="h-12 w-auto">
            </a>
            <nav class="hidden md:flex space-x-6 font-medium">
                <a href="index.php" class="hover:text-blue-600 transition">Home</a>
                <!--<a href="captar.php" class="hover:text-blue-600 transition">O Sistema</a>-->
                <a href="drivers/index.php" class="text-blue-600 border-b-2 border-blue-600">Repositório</a>
                <a href="https://sistema.ativisoft.com.br/pages/samples/login.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Acessar</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="gradient-bg text-white py-16">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-4xl md:text-5xl font-black mb-4">Drivers e Ferramentas Úteis</h1>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto mb-8">
                    Encontre os drivers necessários para sua automação comercial e industrial com total transparência e rapidez.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="drivers/index.php" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105">
                        IR PARA DOWNLOADS
                    </a>
                    <a href="https://sistema.ativisoft.com.br/pages/md_xml/" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105">
                        IR PARA FERRAMENTAS FISCAIS
                    </a>
                </div>
            </div>
        </section>
        <!--<div class="container mx-auto px-4 py-8 text-center">
            <span class="text-[10px] text-gray-400 uppercase block mb-2">Publicidade</span>
            <div class="bg-white border-2 border-dashed border-gray-200 p-4 inline-block w-full max-w-[728px] min-h-[90px]">
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-3996853854538676" data-ad-slot="SEU_SLOT_AQUI" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
            </div>
        </div>-->

        <section class="py-12 bg-white">
            <div class="container mx-auto px-4 grid md:grid-cols-3 gap-8">
                <div class="p-6 border rounded-xl hover:shadow-md transition">
                    <div class="text-blue-600 text-3xl mb-4">🚀</div>
                    <h3 class="text-xl font-bold mb-2">Agilidade</h3>
                    <p class="text-gray-600 text-sm">Download direto, sem burocracia para seus drivers de automação.</p>
                </div>
                <div class="p-6 border rounded-xl hover:shadow-md transition">
                    <div class="text-blue-600 text-3xl mb-4">🔍</div>
                    <h3 class="text-xl font-bold mb-2">Transparência</h3>
                    <p class="text-gray-600 text-sm">Arquivos verificados e organizados por categoria e fabricante.</p>
                </div>
                <div class="p-6 border rounded-xl hover:shadow-md transition">
                    <div class="text-blue-600 text-3xl mb-4">🛠️</div>
                    <h3 class="text-xl font-bold mb-2">Suporte</h3>
                    <p class="text-gray-600 text-sm">Nossa equipe está pronta para auxiliar na sua instalação.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-slate-900 text-white py-12 mt-12">
        <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-center md:text-left">
                <img src="marketing/images/Logo_3.png" alt="AtiviSoft" class="h-16 mx-auto md:mx-0 mb-4">
                <p class="text-gray-400 text-sm">"As oportunidades multiplicam-se à medida que são agarradas!"</p>
            </div>
            <div class="text-center md:text-right text-sm">
                <h6 class="font-bold mb-2">CONTATO</h6>
                <p>+55 (21) 9 6554 3094</p>
                <p class="mt-4 text-gray-500">© 2026 AtiviSoft. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

</body>
</html>