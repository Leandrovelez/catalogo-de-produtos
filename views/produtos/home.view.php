<div id="homeBannerCarousel" class="carousel slide home-banner-bleed home-banner-carousel mb-4" data-bs-ride="carousel" data-bs-interval="6000" aria-label="Destaques">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#homeBannerCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#homeBannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <picture>
                <source media="(max-width: 767px)" srcset="assets/banner/bloco-mobile.jpg">
                <img src="assets/banner/bloco-desktop.jpg" class="d-block w-100" alt="Destaque Bloco">
            </picture>
        </div>
        <div class="carousel-item">
            <picture>
                <source media="(max-width: 767px)" srcset="assets/banner/copa-mobile.jpg">
                <img src="assets/banner/copa-desktop.jpg" class="d-block w-100" alt="Destaque Copa">
            </picture>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="prev" aria-label="Anterior">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="next" aria-label="Próximo">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>

<?php if (isset($busca) && $busca !== ''): ?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <p class="text-muted small mb-0">Resultados para "<?= htmlspecialchars($busca) ?>" — <?= count($produtos) ?> produto(s).</p>
    <a href="index.php" class="btn btn-sm btn-outline-secondary">Ver todos</a>
</div>
<?php endif; ?>

<div class="row">
    <?php if (count($produtos) === 0): ?>
    <div class="col-12 text-center py-4">
        <img src="assets/no_results.jpg"
             alt="Ilustração: nenhum resultado"
             class="d-block mx-auto home-no-results-img">
        <p class="fw-bold mt-3 mb-0">
            <?= (isset($busca) && $busca !== '') ? 'Nenhum produto encontrado para esta busca.' : 'Nenhum produto cadastrado.' ?>
        </p>
    </div>
    <?php else: ?>
    <?php foreach ($produtos as $p): ?>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-4">
        <div class="card h-100">
            <img src="uploads/<?= $p['referencia'] ?>/<?= $p['caminho'] ?>" 
                class="card-img-top" 
                style="height: 250px; object-fit: cover;" 
                alt="<?= htmlspecialchars($p['nome']) ?>">
            <div class="card-body">
                <h5><?= htmlspecialchars($p['nome']) ?></h5>
                <a href="index.php?p=detalhes&id=<?= $p['id'] ?>" class="btn btn-primary w-100">Ver Detalhes</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
