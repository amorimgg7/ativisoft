<?php

require 'functions.php';

$id = $_POST['simulado'];

$arquivo =
    "../dados/simulados/$id.json";

$perguntas =
    json_decode(
        file_get_contents($arquivo),
        true
    );

$novoId = count($perguntas) + 1;

$perguntas[] = [
    'id' => $novoId,
    'categoria' =>
        $_POST['categoria'],
    'pergunta' =>
        $_POST['pergunta'],
    'opcoes' => [
        $_POST['a'],
        $_POST['b'],
        $_POST['c'],
        $_POST['d']
    ],
    'correta' =>
        (int)$_POST['correta'],
    'explicacao' =>
        $_POST['explicacao']
];

file_put_contents(
    $arquivo,
    json_encode(
        $perguntas,
        JSON_PRETTY_PRINT |
        JSON_UNESCAPED_UNICODE
    )
);

atualizarQuantidadePerguntas($id);

header(
    "Location: perguntas.php?id=$id"
);