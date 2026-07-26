<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$usuario = "root";
$senha = "";
$nome = "marcial_1_0"; // <-- seu novo banco

try {
    $pdo = new PDO("mysql:host=$host;dbname=$nome;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Configs globais
$_SESSION['dominio'] = 'http://localhost/ativisoft_1_0/marcial_1_0/';
date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: text/html; charset=UTF-8'); 
?>