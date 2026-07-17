<?php

require 'functions.php';

$id = $_GET['id'];

$pergunta =
    (int)$_GET['pergunta'];

$arquivo =
    "../dados/simulados/$id.json";

$perguntas =
    json_decode(
        file_get_contents($arquivo),
        true
    );

foreach ($perguntas as $k => $p)
{
    if ($p['id'] == $pergunta)
    {
        unset($perguntas[$k]);
    }
}

$perguntas =
    array_values($perguntas);

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