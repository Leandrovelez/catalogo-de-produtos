<?php
require_once 'models/Produto.php';
$model = new Produto($pdo);

$ehPainelAdmin = strpos($_SERVER['PHP_SELF'], 'admin.php') !== false;
$busca = $ehPainelAdmin ? '' : trim($_GET['q'] ?? '');
$produtos = $model->index($busca);

include 'views/components/header.php';

$view = strpos($_SERVER['PHP_SELF'], 'admin.php') !== false ? 'listagem' : 'home';
include "views/produtos/{$view}.view.php";
include 'views/components/footer.php';