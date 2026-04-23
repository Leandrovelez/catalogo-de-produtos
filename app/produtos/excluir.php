<?php
// app/produtos/excluir.php
require_once 'models/Produto.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $model = new Produto($pdo);
    if ($model->destroy($id)) {
        $_SESSION['mensagem'] = "O produto foi removido com sucesso.";
        $_SESSION['tipo_mensagem'] = "success";
    } else {
        $_SESSION['mensagem'] = "Erro ao tentar remover o produto.";
        $_SESSION['tipo_mensagem'] = "error";
    }
}

header('Location: admin.php?p=produtos/index');
exit;