<?php
session_start();


date_default_timezone_set('America/Sao_Paulo');

header('Content-Type: text/html; charset=UTF-8');

// Caminho base seguindo a mesma lógica do nfse.php

$cd_empresa = preg_replace('/[^0-9]/', '', $_SESSION['cd_empresa']);

// Caminho físico
$baseDir =
    __DIR__ .
    '/../../fiscal/' .
    $cd_empresa;

    
$xmlDir = $baseDir . DIRECTORY_SEPARATOR . 'fiscal' . DIRECTORY_SEPARATOR . 'nfse' . DIRECTORY_SEPARATOR . 'xml';

echo '<pre>';
echo 'Diretório base: ' . $baseDir;
echo '</pre>';

/*
|--------------------------------------------------------------------------
| AÇÃO: VISUALIZAR E IMPRIMIR UMA NOTA ESPECÍFICA (TÉRMICA 80MM)
|--------------------------------------------------------------------------
*/
if (isset($_GET['arquivo'])) {
    // Segurança: basename impede navegação de diretórios
    $arquivoNome = basename($_GET['arquivo']);
    $caminhoCompleto = $xmlDir . DIRECTORY_SEPARATOR . $arquivoNome;

    if (!file_exists($caminhoCompleto) || pathinfo($caminhoCompleto, PATHINFO_EXTENSION) !== 'xml') {
        die("<h3>Arquivo XML não encontrado ou inválido.</h3><a href='listar_nfse.php'>Voltar</a>");
    }

    // Carrega o XML
    libxml_use_internal_errors(true);
    $xmlData = simplexml_load_file($caminhoCompleto);

    if ($xmlData === false) {
        die("<h3>Erro ao ler o XML.</h3><a href='listar_nfse.php'>Voltar</a>");
    }

    // Função auxiliar para buscar tags
    $buscarTag = function ($tag) use ($xmlData) {
        $resultado = $xmlData->xpath("//*[local-name()='{$tag}']");
        return (!empty($resultado)) ? (string)$resultado[0] : 'N/A';
    };

    // Extrair dados básicos
    $numeroNFSe  = $buscarTag('nNFSe') !== 'N/A' ? $buscarTag('nNFSe') : $buscarTag('numero');
    $chaveAcesso = $buscarTag('chNFSe') !== 'N/A' ? $buscarTag('chNFSe') : $buscarTag('chaveAcesso');
    $dataEmissao = $buscarTag('dhEmi') !== 'N/A' ? $buscarTag('dhEmi') : $buscarTag('dataEmissao');
    
    if ($dataEmissao !== 'N/A') {
        $dataEmissao = date('d/m/Y H:i:s', strtotime($dataEmissao));
    }

    $cnpjPrestador  = $buscarTag('CNPJ');
    $cpfTomador     = $buscarTag('CPF');
    $descricaoServ  = $buscarTag('descricao');
    $valorServicos  = $buscarTag('valorServicos');

    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cupom NFS-e - <?php echo htmlspecialchars($numeroNFSe); ?></title>
        <style>
            /* Estilos base para a tela (simulando o cupom) */
            body { 
                font-family: 'Courier New', Courier, monospace; /* Fonte ideal para térmica */
                background: #e0e0e0; 
                padding: 10px; 
                margin: 0;
            }
            .recibo { 
                background: #fff; 
                width: 100%; 
                max-width: 350px; /* Largura aproximada de bobina na tela */
                margin: 0 auto; 
                padding: 15px; 
                box-shadow: 0 0 10px rgba(0,0,0,0.2); 
                color: #000;
            }
            h2 { 
                text-align: center; 
                font-size: 1.2em; 
                margin: 0 0 10px 0; 
            }
            .info-group { 
                margin-bottom: 8px; 
                font-size: 0.9em; 
                word-wrap: break-word; /* Evita que chaves de acesso quebrem o layout */
            }
            .info-group strong { 
                display: block; /* Joga o valor para a linha de baixo para caber na térmica */
                margin-bottom: 2px;
            }
            hr { 
                border: none; 
                border-top: 1px dashed #000; /* Tracejado típico de cupom */
                margin: 10px 0; 
            }
            .valor { 
                font-size: 1.2em; 
                font-weight: bold; 
                text-align: right; 
                margin-top: 10px; 
            }
            
            /* Botões (apenas visíveis na tela) */
            .acoes { margin-top: 20px; text-align: center; }
            .btn-imprimir { 
                display: inline-block; width: 100%; padding: 12px; margin-bottom: 10px;
                background: #000; color: #fff; border: none; font-weight: bold; 
                font-size: 1em; cursor: pointer; border-radius: 4px;
            }
            .btn-voltar { 
                display: inline-block; text-decoration: underline; color: #333; 
                padding: 10px;
            }

            /* Configurações EXCLUSIVAS para quando o comando de Imprimir for acionado */
            @media print {
                @page { 
                    margin: 0; /* Remove margens do navegador para aproveitar a bobina */
                }
                body { 
                    background: #fff; 
                    padding: 0; 
                    margin: 0; 
                }
                .recibo { 
                    width: 80mm; /* Força os exatos 80mm da bobina térmica */
                    max-width: 80mm; 
                    padding: 2mm; /* Respiro mínimo interno */
                    margin: 0; 
                    box-shadow: none; 
                    border: none; 
                }
                .acoes { 
                    display: none !important; /* Esconde botões na impressão */
                }
            }
        </style>
    </head>
    <body>
        <div class="recibo">
            <h2>NFS-e</h2>
            <div class="info-group"><strong>Nº da Nota:</strong> <?php echo htmlspecialchars($numeroNFSe); ?></div>
            <div class="info-group"><strong>Chave de Acesso:</strong> <?php echo htmlspecialchars($chaveAcesso); ?></div>
            <div class="info-group"><strong>Emissão:</strong> <?php echo htmlspecialchars($dataEmissao); ?></div>
            <hr>
            <div class="info-group"><strong>CNPJ Prestador:</strong> <?php echo htmlspecialchars($cnpjPrestador); ?></div>
            <div class="info-group"><strong>CPF/CNPJ Tomador:</strong> <?php echo htmlspecialchars($cpfTomador); ?></div>
            <hr>
            <div class="info-group"><strong>Descrição do Serviço:</strong> <?php echo nl2br(htmlspecialchars($descricaoServ)); ?></div>
            <hr>
            <div class="info-group valor">Total: R$ <?php echo htmlspecialchars($valorServicos); ?></div>
            
            <div class="acoes">
                <button class="btn-imprimir" onclick="window.print();">🖨️ IMPRIMIR</button>
                <a href="listar_nfse.php" class="btn-voltar">Voltar para a lista</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

/*
|--------------------------------------------------------------------------
| AÇÃO PADRÃO: LISTAR ARQUIVOS
|--------------------------------------------------------------------------
*/
$arquivosXML = [];
if (is_dir($xmlDir)) {
    $arquivosXML = glob($xmlDir . DIRECTORY_SEPARATOR . '*.xml');
    if (!empty($arquivosXML)) {
        array_multisort(array_map('filemtime', $arquivosXML), SORT_DESC, $arquivosXML);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade -->
    <title>Gerenciador de NFS-e</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f9f9f9; 
            padding: 10px; /* Reduzido para mobile */
            margin: 0;
        }
        .container { 
            max-width: 900px; 
            margin: 0 auto; 
            background: #fff; 
            padding: 15px; 
            border-radius: 5px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
        }
        h2 { 
            border-bottom: 1px solid #eee; 
            padding-bottom: 10px; 
            color: #333; 
            font-size: 1.3em;
        }
        
        /* Envolve a tabela para permitir scroll lateral no celular */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
            min-width: 500px; /* Força scroll lateral em telas menores que isso */
        }
        th, td { 
            padding: 10px; 
            border-bottom: 1px solid #ddd; 
            text-align: left; 
            font-size: 0.9em;
        }
        th { background-color: #f4f4f4; }
        tr:hover { background-color: #f1f1f1; }
        
        .btn-ver { 
            display: inline-block;
            background: #28a745; 
            color: white; 
            padding: 8px 12px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 0.85em;
            text-align: center;
            white-space: nowrap;
        }
        .btn-ver:hover { background: #218838; }
        .empty-msg { text-align: center; color: #777; padding: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📄 Notas Fiscais (XML)</h2>
        
        <?php if (empty($arquivosXML)): ?>
            <p class="empty-msg">Nenhuma nota fiscal encontrada.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Arquivo</th>
                            <th>Data</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($arquivosXML as $arquivo): 
                            $nomeArquivo = basename($arquivo);
                            $dataModificacao = date("d/m/Y H:i", filemtime($arquivo));
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($nomeArquivo); ?></td>
                                <td><?php echo $dataModificacao; ?></td>
                                <td>
                                    <a href="listar_nfse.php?arquivo=<?php echo urlencode($nomeArquivo); ?>" class="btn-ver">Imprimir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>