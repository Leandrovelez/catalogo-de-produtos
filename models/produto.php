<?php
// models/Produto.php

class Produto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index($busca = '') {
        $busca = trim((string) $busca);
        $sqlBase = "SELECT p.*, (SELECT caminho FROM imagens WHERE produto_id = p.id LIMIT 1) AS caminho 
                FROM produtos p ";

        if ($busca === '') {
            $sql = $sqlBase . "ORDER BY p.id DESC";
            return $this->pdo->query($sql)->fetchAll();
        }

        $like = '%' . addcslashes($busca, '%_\\') . '%';
        $sql = $sqlBase . "WHERE p.nome LIKE ? OR p.referencia LIKE ? OR COALESCE(p.descricao, '') LIKE ? 
                ORDER BY p.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$like, $like, $like]);
        return $stmt->fetchAll();
    }

    public function show($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function store($data) {
        $stmt = $this->pdo->prepare("INSERT INTO produtos (nome, referencia, descricao) VALUES (?, ?, ?)");
        $stmt->execute([
            $data['nome'],
            $data['referencia'],
            $data['descricao']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function update($data) {
        $stmt = $this->pdo->prepare("UPDATE produtos SET nome = ?, referencia = ?, descricao = ? WHERE id = ?");
        return $stmt->execute([
            $data['nome'], 
            $data['referencia'], 
            $data['descricao'], 
            $data['id']
        ]);
    }

    public function syncImages($productId, $path) {
        $stmt = $this->pdo->prepare("INSERT INTO imagens (produto_id, caminho) VALUES (?, ?)");
        return $stmt->execute([$productId, $path]);
    }

    public function getImages($productId) {
        $stmt = $this->pdo->prepare("SELECT * FROM imagens WHERE produto_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    public function deleteImages($imageId, $ref) {
        $stmt = $this->pdo->prepare("SELECT caminho FROM imagens WHERE id = ?");
        $stmt->execute([$imageId]);
        $img = $stmt->fetch();

        if ($img) {
            $path = "uploads/{$ref}/" . $img['caminho'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $stmt = $this->pdo->prepare("DELETE FROM imagens WHERE id = ?");
        return $stmt->execute([$imageId]);
    }

    public function destroy($id) {
        $produto = $this->show($id);
        if (!$produto) return false;

        $ref = $produto['referencia'];
        $imgs = $this->getImages($id);

        foreach ($imgs as $img) {
            $path = "uploads/{$ref}/" . $img['caminho'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $dir = "uploads/{$ref}";
        if (is_dir($dir)) {
            // Remove arquivos residuais e a pasta
            array_map('unlink', glob("$dir/*.*"));
            rmdir($dir);
        }

        $stmt = $this->pdo->prepare("DELETE FROM produtos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function referenciaExiste($referencia, $idExcluido = null) {
        $sql = "SELECT id FROM produtos WHERE referencia = ?";
        $params = [$referencia];
    
        // Se estivermos editando, ignoramos o próprio ID do produto atual
        if ($idExcluido) {
            $sql .= " AND id != ?";
            $params[] = $idExcluido;
        }
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }
}