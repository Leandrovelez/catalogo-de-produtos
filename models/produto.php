<?php
class Produto {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function index() { 
        return $this->pdo->query("SELECT * FROM produtos ORDER BY created_at DESC")->fetchAll();
    }

    public function show($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function store($d) {
        $stmt = $this->pdo->prepare("INSERT INTO produtos (nome, referencia, imagem) VALUES (?, ?, ?)");
        return $stmt->execute([$d['nome'], $d['referencia'], $d['imagem']]);
    }

    public function update($d) {
        $sql = "UPDATE produtos SET nome = ?, referencia = ?" . (isset($d['imagem']) ? ", imagem = ?" : "") . " WHERE id = ?";
        $params = isset($d['imagem']) ? [$d['nome'], $d['referencia'], $d['imagem'], $d['id']] : [$d['nome'], $d['referencia'], $d['id']];
        return $this->pdo->prepare($sql)->execute($params);
    }

    public function destroy($id) {
        return $this->pdo->prepare("DELETE FROM produtos WHERE id = ?")->execute([$id]);
    }
}