<?php
require_once 'models/Produto.php';
$id = $_GET['id'] ?? die('ID faltando');
$p = (new Produto($pdo))->show($id);

include 'views/components/header.php';
include 'views/produtos/detalhes.view.php';
include 'views/components/footer.php';