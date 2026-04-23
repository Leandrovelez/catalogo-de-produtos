<?php
// app/produtos/excluir.php
require_once 'models/Produto.php';
$model = new Produto($pdo);

$id = $_GET['id'] ?? null;

if ($id) {
    if ($model->destroy($id)) {
        $_SESSION['mensagem'] = "Produto removido com sucesso!";
        $_SESSION['tipo_mensagem'] = "success";
    } else {
        $_SESSION['mensagem'] = "Erro ao remover produto.";
        $_SESSION['tipo_mensagem'] = "danger";
    }
}

header('Location: admin.php?p=produtos/index');
exit;