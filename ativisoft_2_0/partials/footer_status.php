    
<?php

// ========================================
// API DE STATUS DO ATIVISOFT
// ========================================


// ========================================
// RESPOSTA JSON
// ========================================

header(
    'Content-Type: application/json; charset=utf-8'
);


// ========================================
// EVITA QUE WARNINGS QUEBREM O JSON
// ========================================

ini_set(
    'display_errors',
    '0'
);

error_reporting(0);


// ========================================
// DIRETÓRIO RAIZ DO SISTEMA
// ========================================
//
// footer_status.php está em:
//
// partials/
//
// Portanto:
//
// dirname(__DIR__)
//
// aponta para a raiz do sistema.
//

$raiz =
    dirname(__DIR__);


// ========================================
// PASTAS MONITORADAS
// ========================================

$pastas = [

    $raiz . '/classes',

    $raiz . '/assets',

    $raiz . '/css',

    $raiz . '/js',

    $raiz . '/partials',

    $raiz . '/pages'

];


// ========================================
// EXTENSÕES MONITORADAS
// ========================================

$extensoesPermitidas = [

    'php',
    'js',
    'css',
    'html',
    'json'

];


// ========================================
// VARIÁVEIS
// ========================================

$ultimaAlteracao = 0;

$ultimoArquivo = '';


// ========================================
// PROCURA O ARQUIVO MAIS RECENTE
// ========================================

foreach (
    $pastas as $pasta
) {


    // ========================================
    // PASTA NÃO EXISTE
    // ========================================

    if (
        !is_dir($pasta)
    ) {

        continue;

    }


    try {


        // ========================================
        // ITERADOR
        // ========================================

        $iterator =
            new RecursiveIteratorIterator(

                new RecursiveDirectoryIterator(

                    $pasta,

                    FilesystemIterator::SKIP_DOTS

                )

            );


        // ========================================
        // ARQUIVOS
        // ========================================

        foreach (
            $iterator as $arquivo
        ) {


            // ========================================
            // SOMENTE ARQUIVOS
            // ========================================

            if (
                !$arquivo->isFile()
            ) {

                continue;

            }


            // ========================================
            // EXTENSÃO
            // ========================================

            $extensao =
                strtolower(
                    $arquivo->getExtension()
                );


            // ========================================
            // FILTRO
            // ========================================

            if (
                !in_array(
                    $extensao,
                    $extensoesPermitidas,
                    true
                )
            ) {

                continue;

            }


            // ========================================
            // DATA DE MODIFICAÇÃO
            // ========================================

            $modificado =
                $arquivo->getMTime();


            // ========================================
            // VERIFICA SE É O MAIS RECENTE
            // ========================================

            if (
                $modificado >
                $ultimaAlteracao
            ) {


                $ultimaAlteracao =
                    $modificado;


                // ========================================
                // CAMINHO COMPLETO
                // ========================================

                $caminhoCompleto =
                    $arquivo->getPathname();


                // ========================================
                // TRANSFORMA EM CAMINHO RELATIVO
                // ========================================

                $ultimoArquivo =
                    str_replace(

                        $raiz .
                        DIRECTORY_SEPARATOR,

                        '',

                        $caminhoCompleto

                    );


                // ========================================
                // PADRONIZA BARRAS
                // ========================================

                $ultimoArquivo =
                    str_replace(
                        '\\',
                        '/',
                        $ultimoArquivo
                    );

            }

        }

    }

    catch (
        Exception $e
    ) {

        // ========================================
        // IGNORA ERRO DE LEITURA
        // ========================================

        continue;

    }

}


// ========================================
// HORA ATUAL
// ========================================

$agora =
    time();


// ========================================
// TEMPO DESDE A ALTERAÇÃO
// ========================================

$segundos = 0;


if (
    $ultimaAlteracao > 0
) {

    $segundos =
        max(
            0,
            $agora -
            $ultimaAlteracao
        );

}


// ========================================
// STATUS
// ========================================
//
// Menos de 60 segundos:
// ATUALIZANDO
//
// Mais de 60 segundos:
// ONLINE
//

if (

    $ultimaAlteracao > 0 &&

    $segundos < 60

) {

    $status =
        'atualizando';

}

else {

    $status =
        'online';

}


// ========================================
// DATA FORMATADA
// ========================================

$data = '';


if (
    $ultimaAlteracao > 0
) {

    $data =
        date(
            'd/m/Y H:i:s',
            $ultimaAlteracao
        );

}


// ========================================
// RESPOSTA
// ========================================

$resposta = [

    'status' =>
        $status,

    'arquivo' =>
        $ultimoArquivo,

    'timestamp' =>
        $ultimaAlteracao,

    'data' =>
        $data,

    'segundos' =>
        $segundos

];


// ========================================
// ENVIA JSON
// ========================================

echo json_encode(

    $resposta,

    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES

);

exit;

