<div class="row">
    <?php foreach($produtos as $p): ?>
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            <img src="uploads/<?= $p['imagem'] ?>" class="card-img-top" style="height:200px; object-fit:cover;">
            <div class="card-body">
                <h5><?= htmlspecialchars($p['nome']) ?></h5>
                <a href="index.php?p=detalhes&id=<?= $p['id'] ?>" class="btn btn-primary w-100">Ver Detalhes</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>