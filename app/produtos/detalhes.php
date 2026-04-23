<?php
// app/produtos/detalhes.php
require_once 'models/Produto.php';
$model = new Produto($pdo);

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

// Busca o produto e as imagens
$produto = $model->show($id);
$imagens = $model->getImages($id);

// SE O PRODUTO NÃO EXISTIR NO BANCO:
if (!$produto) {
    echo "<h2>Erro: Produto não encontrado.</h2>";
    echo "<a href='index.php'>Voltar para a vitrine</a>";
    exit; // Para a execução aqui para não dar erro na View
}

// Se chegou aqui, $produto existe e a View vai funcionar
include 'views/components/header.php';
include 'views/produtos/detalhes.view.php';
include 'views/components/footer.php';