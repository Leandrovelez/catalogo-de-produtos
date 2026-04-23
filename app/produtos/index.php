<?php
require_once 'models/Produto.php';
$model = new Produto($pdo);
$produtos = $model->index();

include 'views/components/header.php';

$view = strpos($_SERVER['PHP_SELF'], 'admin.php') !== false ? 'listagem' : 'home';
include "views/produtos/{$view}.view.php";
include 'views/components/footer.php';