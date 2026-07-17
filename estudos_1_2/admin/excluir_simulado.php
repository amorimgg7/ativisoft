<?php
require 'functions.php';

$id = $_GET['id'];

$simulados = carregarSimulados();

foreach ($simulados as $k => $s)
{
    if ($s['id'] == $id)
    {
        unset($simulados[$k]);
    }
}

salvarSimulados(
    array_values($simulados)
);

$arquivo =
    "../dados/simulados/$id.json";

if (file_exists($arquivo))
{
    unlink($arquivo);
}

header(
    'Location: simulados.php'
);