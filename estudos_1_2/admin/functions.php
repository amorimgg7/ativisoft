<?php

function carregarSimulados()
{
    $arquivo = '../dados/simulados.json';

    if (!file_exists($arquivo)) {
        file_put_contents($arquivo, '[]');
    }

    return json_decode(
        file_get_contents($arquivo),
        true
    );
}

function salvarSimulados($dados)
{
    file_put_contents(
        '../dados/simulados.json',
        json_encode(
            $dados,
            JSON_PRETTY_PRINT |
            JSON_UNESCAPED_UNICODE
        )
    );
}

function atualizarQuantidadePerguntas($id)
{
    $arquivo =
        "../dados/simulados/$id.json";

    if (!file_exists($arquivo)) {
        return;
    }

    $perguntas = json_decode(
        file_get_contents($arquivo),
        true
    );

    $simulados = carregarSimulados();

    foreach ($simulados as &$s) {
        if ($s['id'] == $id) {
            $s['total_perguntas'] =
                count($perguntas);
            break;
        }
    }

    salvarSimulados($simulados);
}