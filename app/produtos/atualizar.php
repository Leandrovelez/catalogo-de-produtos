<?php
// app/produtos/atualizar.php
require_once 'models/Produto.php';
$model = new Produto($pdo);

$id = $_GET['id'] ?? die('ID inválido');
$produto = $model->show($id);

if (!$produto) {
    die('Produto não encontrado');
}

// Guardamos a referência antiga para comparar e mover a pasta se necessário
$referenciaAntiga = $produto['referencia'];

// Ação de deletar imagem individual
if (isset($_GET['delete_img'])) {
    $model->deleteImages($_GET['delete_img'], $referenciaAntiga);
    $_SESSION['mensagem'] = "Imagem removida!";
    $_SESSION['tipo_mensagem'] = "info";
    header("Location: admin.php?p=produtos/atualizar&id=$id");
    exit;
}

// Ação de salvar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novaReferencia = $_POST['referencia'];

    // 1. Lógica de Renomear Pasta Física
    if ($novaReferencia !== $referenciaAntiga) {
        $oldPath = "uploads/{$referenciaAntiga}";
        $newPath = "uploads/{$novaReferencia}";

        if (is_dir($oldPath)) {
            // Renomeia a pasta no Windows/Linux
            if (!rename($oldPath, $newPath)) {
                die("Erro ao renomear pasta de imagens. Verifique as permissões.");
            }
        } else {
            // Se a pasta antiga não existia por algum motivo, cria a nova
            if (!is_dir($newPath)) {
                mkdir($newPath, 0777, true);
            }
        }
    }

    // 2. Atualiza os dados no banco
    $model->update([
        'nome' => $_POST['nome'],
        'referencia' => $novaReferencia,
        'descricao' => $_POST['descricao'],
        'id' => $id
    ]);

    // 3. Upload de novas imagens (já na pasta nova)
    if (!empty($_FILES['imagens']['name'][0])) {
        $targetDir = "uploads/{$novaReferencia}/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $currentImgs = $model->getImages($id);
        $vagas = 5 - count($currentImgs);
        $files = $_FILES['imagens'];

        for ($i = 0; $i < min(count($files['name']), $vagas); $i++) {
            if ($files['error'][$i] === 0) {
                $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                $fileName = uniqid() . "_rev." . $ext;
                if (move_uploaded_file($files['tmp_name'][$i], $targetDir . $fileName)) {
                    $model->syncImages($id, $fileName);
                }
            }
        }
    }

    $_SESSION['mensagem'] = "Produto atualizado com sucesso!";
    $_SESSION['tipo_mensagem'] = "success";
    header('Location: admin.php?p=produtos/index');
    exit;
}

$imagens = $model->getImages($id);

include 'views/components/header.php';
include 'views/produtos/form.view.php';
include 'views/components/footer.php';