<?php

require_once 'config/database.php';

$p = $_GET['p'] ?? 'index'; 

$file = "app/produtos/{$p}.php";

if (file_exists($file)) {
    require_once $file;
} else {
    die("Erro: O arquivo de lógica '$file' não existe.");
}