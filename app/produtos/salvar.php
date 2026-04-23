<?php
require_once 'models/Produto.php';
$model = new Produto($pdo);
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = ['nome' => $_POST['nome'], 'referencia' => $_POST['referencia'], 'id' => $id];
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeImg = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['imagem']['tmp_name'], 'uploads/' . $nomeImg);
        $dados['imagem'] = $nomeImg;
    }
    $id ? $model->update($dados) : $model->store($dados);
    $_SESSION['mensagem'] = "Salvo!"; $_SESSION['tipo_mensagem'] = "success";
    header('Location: admin.php?p=produtos/index'); exit;
}
$produto = $id ? $model->show($id) : null;
include 'views/components/header.php';
include 'views/produtos/form.view.php';
include 'views/components/footer.php';