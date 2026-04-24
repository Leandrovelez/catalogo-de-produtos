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
<body class="d-flex flex-column h-100">
<?php $ehPainelAdmin = strpos($_SERVER['PHP_SELF'], 'admin.php') !== false; ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">Catálogo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <?php if (isset($_SESSION['usuario_nivel']) && $_SESSION['usuario_nivel'] === 'admin'): ?>
                <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
            <?php endif; ?>
        </ul>

        <?php if (!$ehPainelAdmin): ?>
        <form class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-1 gap-sm-2 my-2 my-lg-0 ms-lg-2 flex-grow-1 flex-lg-grow-0" style="max-width: 28rem;" role="search" method="get" action="index.php">
            <input type="search" name="q" class="form-control form-control-sm" placeholder="Buscar produtos…" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" aria-label="Buscar produtos" autocomplete="off">
            <div class="d-flex gap-1">
                <button class="btn btn-outline-light btn-sm flex-grow-1 flex-sm-grow-0" type="submit">Buscar</button>
                <?php if (trim($_GET['q'] ?? '') !== ''): ?>
                <a class="btn btn-outline-secondary btn-sm text-nowrap" href="index.php">Limpar</a>
                <?php endif; ?>
            </div>
        </form>
        <?php endif; ?>

        <div class="d-flex align-items-center ms-lg-auto">
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

<style>
    .btn i.feather, 
    .btn svg.feather {
        width: 16px;
        height: 16px;
        vertical-align: middle;
    }
    
    .btn-sm i.feather,
    .btn-xs i.feather {
        width: 14px;
        height: 14px;
    }
</style>