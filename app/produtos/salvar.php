<?php
// app/produtos/salvar.php
require_once 'models/Produto.php';
$model = new Produto($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $ref  = trim($_POST['referencia'] ?? '');
    $desc = $_POST['descricao'] ?? '';
    
    $erros = [];

    if ($nome === '' || strlen($nome) < 3 || strlen($nome) > 255) {
        $erros[] = 'Nome inválido (obrigatório, entre 3 e 255 caracteres).';
    }

    if ($ref === '' || strlen($ref) < 2 || strlen($ref) > 100 || !preg_match('/^[a-zA-Z0-9_-]+$/', $ref)) {
        $erros[] = 'Referência inválida (2 a 100 caracteres; apenas letras, números, hífen ou underline).';
    }

    if (strlen($desc) > 2000) {
        $erros[] = 'Descrição muito longa (máximo 2000 caracteres).';
    }

    if ($ref !== '' && $model->referenciaExiste($ref)) {
        $erros[] = 'Esta referência já está cadastrada para outro produto.';
    }

    if (!empty($erros)) {
        $_SESSION['mensagem'] = implode(' ', $erros);
        $_SESSION['tipo_mensagem'] = 'danger';

        $produto = [
            'nome' => $_POST['nome'] ?? '',
            'referencia' => $_POST['referencia'] ?? '',
            'descricao' => $_POST['descricao'] ?? '',
        ];
        $id = null;
        $imagens = [];

        include 'views/components/header.php';
        include 'views/produtos/form.view.php';
        include 'views/components/footer.php';
        exit;
    }

    $ref = trim($_POST['referencia']);
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