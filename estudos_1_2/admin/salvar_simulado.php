<?php
require 'functions.php';

$simulados = carregarSimulados();

$id = $_POST['id'];

$simulados[] = [
    'id' => $id,
    'titulo' => $_POST['titulo'],
    'arquivo' => $id.'.json',
    'total_perguntas' =>
        (int)$_POST['total_perguntas'],
    'tempo_minutos' =>
        (int)$_POST['tempo'],
    'total_perguntas' => 0,
    'ativo' => true
];

salvarSimulados($simulados);

$arquivo =
    "../dados/simulados/$id.json";

file_put_contents($arquivo, '[]');

header(
    "Location: perguntas.php?id=$id"
);