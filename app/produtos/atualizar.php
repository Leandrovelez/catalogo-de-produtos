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
    $id = (int) $produto['id'];
    $erros = [];
    if ((int) ($_POST['id'] ?? 0) !== $id) {
        $erros[] = 'Confirmação do produto falhou. Recarregue a página e tente novamente.';
    }

    $nome = trim($_POST['nome'] ?? '');
    $ref  = trim($_POST['referencia'] ?? '');
    $desc = $_POST['descricao'] ?? '';

    if ($nome === '' || strlen($nome) < 3 || strlen($nome) > 255) {
        $erros[] = 'Nome inválido (obrigatório, entre 3 e 255 caracteres).';
    }

    if ($ref === '' || strlen($ref) < 2 || strlen($ref) > 100 || !preg_match('/^[a-zA-Z0-9_-]+$/', $ref)) {
        $erros[] = 'Referência inválida (2 a 100 caracteres; apenas letras, números, hífen ou underline).';
    }

    if (strlen($desc) > 2000) {
        $erros[] = 'Descrição muito longa (máximo 2000 caracteres).';
    }

    if ($id > 0 && $ref !== '' && $model->referenciaExiste($ref, $id)) {
        $erros[] = 'Esta referência já pertence a outro produto.';
    }

    if (!empty($erros)) {
        $_SESSION['mensagem'] = implode(' ', $erros);
        $_SESSION['tipo_mensagem'] = 'danger';
        $produto = array_merge($produto, [
            'nome' => $_POST['nome'] ?? $produto['nome'],
            'referencia' => $_POST['referencia'] ?? $produto['referencia'],
            'descricao' => $_POST['descricao'] ?? $produto['descricao'],
        ]);
        $imagens = $model->getImages($id);

        include 'views/components/header.php';
        include 'views/produtos/form.view.php';
        include 'views/components/footer.php';
        exit;
    }

    $novaReferencia = trim($_POST['referencia']);

    // 1. Lógica de Renomear Pasta Física
    if ($novaReferencia !== $referenciaAntiga) {
        $oldPath = "uploads/{$referenciaAntiga}";
        $newPath = "uploads/{$novaReferencia}";

        if (is_dir($oldPath)) {
            if (!rename($oldPath, $newPath)) {
                die("Erro ao renomear pasta de imagens. Verifique as permissões.");
            }
        } else {
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