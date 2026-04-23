<?php
require_once 'config/database.php';
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    session_start();
    $_SESSION['mensagem'] = "Até logo!";
    $_SESSION['tipo_mensagem'] = "info";
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $u = $stmt->fetch();

    if ($u && password_verify($senha, $u['senha'])) {
        $_SESSION['usuario_id'] = $u['id'];
        $_SESSION['usuario_nome'] = $u['nome'];
        $_SESSION['usuario_nivel'] = $u['nivel'];
        $_SESSION['mensagem'] = "Logado com sucesso!";
        $_SESSION['tipo_mensagem'] = "success";
    } else {
        $_SESSION['mensagem'] = "Dados incorretos.";
        $_SESSION['tipo_mensagem'] = "error";
    }
}
header('Location: ' . $_SERVER['HTTP_REFERER']);