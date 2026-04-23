<div class="row">
    <div class="col-md-6"><img src="uploads/<?= $p['imagem'] ?>" class="img-fluid"></div>
    <div class="col-md-6">
        <h1><?= htmlspecialchars($p['nome']) ?></h1>
        <p>Referência: <?= htmlspecialchars($p['referencia']) ?></p>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
</div>