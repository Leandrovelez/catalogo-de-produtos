<?php

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_nivel'] !== 'admin') {
    
    $_SESSION['mensagem'] = "Acesso negado. Você precisa ser admin.";
    $_SESSION['tipo_mensagem'] = "error";
    
    header('Location: index.php');
    exit;
}