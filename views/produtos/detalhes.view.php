<style>
    /* Define a borda de destaque para a miniatura selecionada */
    .thumb-img {
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid transparent; /* Reserva o espaço da borda */
        object-fit: cover;
        width: 80px;
        height: 80px;
    }

    .thumb-img:hover {
        opacity: 0.8;
    }

    .thumb-active {
        border-color: #0d6efd !important; /* Cor azul do Bootstrap */
        box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
    }
</style>

<div class="container mt-5">
    <div class="row bg-white p-4 shadow-sm rounded border">
        <div class="col-md-6 text-center">
            <?php if (!empty($imagens)): ?>
                <img src="uploads/<?= $produto['referencia'] ?>/<?= $imagens[0]['caminho'] ?>" 
                     id="mainImg" class="img-fluid rounded border shadow-sm mb-3" 
                     style="max-height: 500px; width: 100%; object-fit: contain; background: #f8f9fa;">
                
                <div class="d-flex gap-2 justify-content-center overflow-auto pb-2" id="galleryThumbs">
                    <?php foreach ($imagens as $index => $img): ?>
                        <img src="uploads/<?= $produto['referencia'] ?>/<?= $img['caminho'] ?>" 
                             class="img-thumbnail thumb-img <?= $index === 0 ? 'thumb-active' : '' ?>" 
                             onclick="changeImage(this, '<?= 'uploads/' . $produto['referencia'] . '/' . $img['caminho'] ?>')">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="index.php">Catálogo</a></li>
                    <li class="breadcrumb-item active"><?= htmlspecialchars($produto['nome'] ?? '') ?></li>
                </ol>
            </nav>

            <h1 class="h2 fw-bold text-dark mb-1"><?= htmlspecialchars($produto['nome'] ?? '') ?></h1>
            <div class="d-flex align-items-center gap-2 mb-4 text-muted">
                <i data-feather="tag" style="width: 16px;"></i>
                <span>REF: <strong><?= htmlspecialchars($produto['referencia'] ?? '') ?></strong></span>
            </div>

            <h6 class="text-uppercase fw-bold text-secondary small">Descrição do Produto</h6>
            <p class="text-muted" style="white-space: pre-line; line-height: 1.6;">
                <?= htmlspecialchars($produto['descricao'] ?? '') ?>
            </p>

            <div class="mt-5 border-top pt-4">
                <a href="index.php" class="btn btn-dark btn-lg px-4 d-inline-flex align-items-center gap-2">
                    <i data-feather="arrow-left" style="width: 20px;"></i> Voltar ao Catálogo
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function changeImage(element, src) {
    // 1. Troca a imagem principal
    document.getElementById('mainImg').src = src;

    // 2. Remove a classe 'thumb-active' de todas as miniaturas
    const thumbs = document.querySelectorAll('.thumb-img');
    thumbs.forEach(thumb => thumb.classList.remove('thumb-active'));

    // 3. Adiciona a classe apenas na miniatura clicada
    element.classList.add('thumb-active');
}
</script>