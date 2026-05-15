<?php
$baseDir = 'arquivos/';
$categoria = $_GET['cat'] ?? '';
$fabricante = $_GET['fab'] ?? '';

$currentPath = $baseDir;
if ($categoria) $currentPath .= $categoria . '/';
if ($fabricante) $currentPath .= $fabricante . '/';

// Lê itens locais (pastas vazias que espelham os servidores)
$itens = is_dir($currentPath) ? array_diff(scandir($currentPath), array('.', '..', 'README.md')) : [];

$readmeContent = "";
if (file_exists($currentPath . "README.md")) {
    $readmeContent = file_get_contents($currentPath . "README.md");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Driver Portal - Automático</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-slate-800 text-white p-6 shadow-lg">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold italic text-blue-400">ATIVISOFT</h1>
            <nav class="text-xs mt-2 text-gray-400 uppercase">
                <a href="index.php">Início</a> 
                <?php if($categoria) echo " > $categoria"; ?>
                <?php if($fabricante) echo " > $fabricante"; ?>
            </nav>
        </div>
    </header>

    <main class="container mx-auto my-10 px-4">
        <?php if ($readmeContent): ?>
            <div class="bg-white border-l-4 border-blue-500 p-4 mb-6 shadow-sm italic text-gray-600">
                <?php echo nl2br(htmlspecialchars($readmeContent)); ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
<?php foreach ($itens as $item): 

    /* esconder readme da listagem */
    if(preg_match('/^readme(\..+)?$/i', $item))
        continue;

    $fullPath = $currentPath . $item;
    $isDir = is_dir($fullPath);
    $relPath = str_replace('arquivos/', '', $fullPath);

    /* ---------------- LER README DA PASTA ---------------- */
    $descricao = "";

    if($isDir){
        $possibleReadmes = [
            $fullPath."/README.md",
            $fullPath."/readme.md",
            $fullPath."/Readme.md",
            $fullPath."/README.txt"
        ];

        foreach($possibleReadmes as $r){
            if(file_exists($r)){
                $conteudo = file_get_contents($r);

                // pega só os primeiros 300 caracteres
                $descricao = substr(trim($conteudo),0,300);
                if(strlen($conteudo) > 300)
                    $descricao .= "...";

                break;
            }
        }
    }
?>
    <div class="bg-white p-4 rounded shadow-sm border-b-2 border-blue-400 hover:shadow-md transition flex flex-col justify-between">

        <div>
            <!-- Nome -->
            <h3 class="font-bold truncate text-gray-800 text-lg"><?php echo htmlspecialchars($item); ?></h3>

            <!-- Descrição do README -->
            <?php if($descricao): ?>
                <p class="text-xs text-gray-500 mt-2 italic leading-relaxed">
                    <?php echo nl2br(htmlspecialchars($descricao)); ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if ($isDir): ?>

            <a href="index.php?<?php echo !$categoria ? "cat=$item" : "cat=$categoria&fab=$item"; ?>" 
               class="mt-4 block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded text-sm font-semibold">
               Abrir
            </a>

        <?php else: ?>

            <a href="download.php?file=<?php echo base64_encode($relPath); ?>" 
               class="mt-4 block text-center bg-green-600 hover:bg-green-700 text-white py-2 rounded text-sm font-bold italic">
               DOWNLOAD
            </a>

        <?php endif; ?>

    </div>
<?php endforeach; ?>
</div>



    </main>
</body>
</html>