<?php
require_once 'config/adminVerification.php';
require_once 'config/database.php';

$p = $_GET['p'] ?? 'produtos/index'; 

$file = "app/{$p}.php";

if (file_exists($file)) {
    require_once $file;
} else {
    die("Erro: O arquivo de lógica não foi encontrado em: $file");
}