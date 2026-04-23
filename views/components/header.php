<?php 
if (session_status() === PHP_SESSION_NONE) session_start(); 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Catálogo</a>
    
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <?php if (isset($_SESSION['usuario_nivel']) && $_SESSION['usuario_nivel'] === 'admin'): ?>
                <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
            <?php endif; ?>
        </ul>

        <div class="d-flex align-items-center">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <span class="text-light me-3">Olá, <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong></span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">Sair</a>
            <?php else: ?>
                <form action="auth.php" method="POST" class="d-flex gap-2">
                    <input type="email" name="email" class="form-control form-control-sm" placeholder="E-mail" required>
                    <input type="password" name="senha" class="form-control form-control-sm" placeholder="Senha" required>
                    <button type="submit" class="btn btn-primary btn-sm">Entrar</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
  </div>
</nav>
<div class="container">