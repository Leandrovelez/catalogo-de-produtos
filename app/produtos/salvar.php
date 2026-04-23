<?php
// app/produtos/salvar.php
require_once 'models/Produto.php';
$model = new Produto($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ref = $_POST['referencia'];
    $targetDir = "uploads/{$ref}/";

    // Cria a pasta se não existir
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $productId = $model->store([
        'nome' => $_POST['nome'],
        'referencia' => $ref,
        'descricao' => $_POST['descricao']
    ]);

    if (!empty($_FILES['imagens']['name'][0])) {
        $files = $_FILES['imagens'];
        for ($i = 0; $i < min(count($files['name']), 5); $i++) {
            if ($files['error'][$i] === 0) {
                $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                $fileName = uniqid() . "." . $ext;
                if (move_uploaded_file($files['tmp_name'][$i], $targetDir . $fileName)) {
                    $model->syncImages($productId, $fileName);
                }
            }
        }
    }

    $_SESSION['mensagem'] = "Produto cadastrado com sucesso!";
    $_SESSION['tipo_mensagem'] = "success";
    header('Location: admin.php?p=produtos/index');
    exit;
}

include 'views/components/header.php';
include 'views/produtos/form.view.php';
include 'views/components/footer.php';