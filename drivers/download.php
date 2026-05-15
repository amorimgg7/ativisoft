<?php
// 1. Pega e decodifica o arquivo
$fileEncoded = $_GET['file'] ?? '';
$relativePath = base64_decode($fileEncoded);

// Segurança: Remove tentativas de navegação de diretório (../)
$relativePath = str_replace(['../', '..\\'], '', $relativePath);

// Define o caminho final (ajuste conforme a estrutura do seu SV)
$baseDir = "arquivos/"; 
$fullPath = $baseDir . $relativePath;

// 2. Validação de existência
if (empty($relativePath) || !file_exists($fullPath) || is_dir($fullPath)) {
    die("<h3>Erro: Arquivo não encontrado ou link expirado.</h3><a href='https://ativisoft.com.br'>Voltar ao site</a>");
}

// 3. Busca o README.md para descrição
// Procuramos o README na mesma pasta onde o arquivo está
$dirPath = dirname($fullPath);
$readmePath = $dirPath . "/README.md";
$description = "";

if (file_exists($readmePath)) {
    $description = file_get_contents($readmePath);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download: <?php echo htmlspecialchars(basename($fullPath)); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://quge5.com/88/tag.min.js" data-zone="210463" async data-cfasync="false"></script>
    <style>
        /* Estilização para o conteúdo do README ficar bonito */
        .readme-text { font-family: 'Inter', sans-serif; line-height: 1.6; }
    </style>
</head>
<body class="bg-slate-900 text-white min-h-screen flex flex-col items-center justify-center p-4">

    <div class="max-w-4xl w-full bg-slate-800 rounded-2xl shadow-2xl overflow-hidden border border-slate-700">
        
        <div class="p-6 bg-slate-700/50 border-b border-slate-600 flex justify-between items-center">
            <h1 class="text-xl font-bold">Arquivo: <span class="text-blue-400"><?php echo htmlspecialchars(basename($fullPath)); ?></span></h1>
            <span class="text-xs bg-slate-600 px-3 py-1 rounded-full text-gray-300">Servidor Ativo</span>
        </div>

        <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="flex flex-col">
                <h2 class="text-xs font-bold text-blue-500 uppercase mb-4 tracking-widest italic">Informações do Driver</h2>
                <div class="bg-slate-900/50 p-5 rounded-xl border border-slate-700 text-gray-300 text-sm overflow-y-auto max-h-[300px] readme-text">
                    <?php if ($description): ?>
                        <?php echo nl2br(htmlspecialchars($description)); ?>
                    <?php else: ?>
                        <p class="text-gray-500 italic">Nenhuma descrição detalhada encontrada para este item.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex flex-col items-center justify-center bg-slate-700/20 p-6 rounded-2xl border border-dashed border-slate-500">
                <div class="text-[10px] text-gray-500 mb-3 uppercase tracking-widest">Publicidade</div>
                
                <div class="w-full h-[250px] bg-black/40 rounded-lg mb-6 flex items-center justify-center border border-slate-700">
                    <span class="text-gray-600 italic text-xs">[ SEU ANÚNCIO AQUI ]</span>
                </div>

                <div id="counter-box" class="text-center w-full">
                    <p class="text-gray-400 text-sm mb-2">Preparando link seguro...</p>
                    <div class="text-3xl font-black text-blue-500 mb-2"><span id="timer">10</span>s</div>
                    <div class="w-full bg-slate-700 h-1.5 rounded-full overflow-hidden">
                        <div id="progress-bar" class="bg-blue-600 h-full transition-all duration-1000" style="width: 0%"></div>
                    </div>
                </div>

                <a id="downloadBtn" href="<?php echo $fullPath; ?>" download 
                   class="hidden w-full text-center bg-green-600 hover:bg-green-500 text-white font-black py-5 rounded-xl text-xl shadow-[0_0_20px_rgba(22,163,74,0.4)] transition-all transform hover:scale-105 active:scale-95">
                    BAIXAR AGORA
                </a>
            </div>
        </div>

        <div class="p-4 bg-slate-900/80 text-center text-[10px] text-gray-500 uppercase tracking-widest">
            Ativisoft &copy; <?php echo date('Y'); ?> - Sistema de Distribuição de Drivers
        </div>
    </div>

    <script>
        let timeLeft = 10;
        let totalTime = 10;
        const timerDisplay = document.getElementById('timer');
        const progressBar = document.getElementById('progress-bar');
        const btn = document.getElementById('downloadBtn');
        const counterBox = document.getElementById('counter-box');

        const countdown = setInterval(() => {
            timeLeft--;
            
            // Atualiza Timer
            timerDisplay.innerText = timeLeft;
            
            // Atualiza Barra de Progresso
            let percentage = ((totalTime - timeLeft) / totalTime) * 100;
            progressBar.style.width = percentage + "%";

            if (timeLeft <= 0) {
                clearInterval(countdown);
                counterBox.classList.add('hidden');
                btn.classList.remove('hidden');
            }
        }, 1000);
    </script>
</body>
</html>