<div class="card shadow-sm mt-4">
    <div class="card-header bg-dark text-white">
        <h4><?= isset($produto['id']) ? 'Editar Produto' : 'Novo Produto' ?></h4>
    </div>
    <div class="card-body">
        <?php 
            $id = $produto['id'] ?? null;
            $destino = $id ? "admin.php?p=produtos/atualizar&id={$id}" : "admin.php?p=produtos/salvar";
            // Em edição, imagens ficam na pasta da referência já salva no banco ($referenciaAntiga em atualizar.php),
            // não no valor digitado no campo (ex.: referência duplicada inválida antes de salvar).
            $refPastaImagens = (isset($referenciaAntiga) && $referenciaAntiga !== '')
                ? $referenciaAntiga
                : ($produto['referencia'] ?? '');
        ?>
        
        <form id="productForm" action="<?= $destino ?>" method="POST" enctype="multipart/form-data">
            <?php if ($id): ?>
                <input type="hidden" name="id" value="<?= (int) $id ?>">
            <?php endif; ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Nome do Produto</label>
                        <input type="text" name="nome" class="form-control" 
                            value="<?= htmlspecialchars($produto['nome'] ?? $_POST['nome'] ?? '') ?>">
                        <div class="input-error-line" aria-hidden="true"></div>
                        <div class="error-message text-danger small mt-1" id="error-nome"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Referência</label>
                        <input type="text" name="referencia" class="form-control" 
                            value="<?= htmlspecialchars($produto['referencia'] ?? $_POST['referencia'] ?? '') ?>">
                        <div class="input-error-line" aria-hidden="true"></div>
                        <div class="error-message text-danger small mt-1" id="error-referencia"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="5"><?= htmlspecialchars($produto['descricao'] ?? $_POST['descricao'] ?? '') ?></textarea>
                        <div class="input-error-line" aria-hidden="true"></div>
                        <div class="error-message text-danger small mt-1" id="error-descricao"></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <h5>Imagens (Máx. 5)</h5>
                    <div id="container-imagens" class="border p-3 bg-light rounded">
                        
                        <?php if (isset($imagens) && count($imagens) > 0): ?>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <?php foreach ($imagens as $img): ?>
                                    <div class="position-relative border p-1 bg-white shadow-sm text-center">
                                        <img src="uploads/<?= htmlspecialchars($refPastaImagens) ?>/<?= htmlspecialchars($img['caminho']) ?>" 
                                             width="80" height="80" style="object-fit: cover;" class="d-block">
                                        
                                        <div class="mt-1 d-flex justify-content-center gap-2">
                                            <a href="uploads/<?= htmlspecialchars($refPastaImagens) ?>/<?= htmlspecialchars($img['caminho']) ?>" 
                                               target="_blank" class="btn btn-sm btn-warning text-white py-0 px-1">
                                            <i data-feather="eye"></i>
                                            </a>
                                            
                                            <?php
                                                $urlPreviewImg = "uploads/{$refPastaImagens}/{$img['caminho']}";
                                                $urlExcluirImg = 'admin.php?p=produtos/atualizar&id=' . (int) $id . '&delete_img=' . (int) $img['id'];
                                            ?>
                                            <button type="button"
                                                class="btn btn-sm btn-danger text-white py-0 px-1 js-excluir-imagem"
                                                data-url="<?= htmlspecialchars($urlExcluirImg) ?>"
                                                data-preview="<?= htmlspecialchars($urlPreviewImg) ?>"
                                                title="Excluir imagem">
                                                <i data-feather="trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php 
                        $totalAtual = isset($imagens) ? count($imagens) : 0;
                        $restante = 5 - $totalAtual;
                        ?>

                        <?php if ($restante > 0): ?>
                            <div class="alert alert-info py-2 small">
                                Você pode adicionar mais <strong><?= $restante ?></strong> imagem(ns).
                            </div>
                            <input type="file" name="imagens[]" class="form-control" multiple 
                                   <?= !$id ? 'required' : '' ?> id="input-imagens">
                        <?php else: ?>
                            <div class="alert alert-warning py-2 small m-0 text-center">
                                <strong>Limite de 5 imagens atingido.</strong><br>Exclua uma para subir outra.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex justify-content-end gap-2">
                <a href="admin.php?p=produtos/index" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">
                    <?= $id ? 'Salvar Alterações' : 'Cadastrar Produto' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalExcluirImagem" tabindex="-1" aria-labelledby="modalExcluirImagemLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalExcluirImagemLabel">Confirmar exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mb-3">Deseja realmente excluir esta imagem? Esta ação não pode ser desfeita.</p>
                <img id="modalExcluirImagemPreview" src="" alt="Prévia da imagem a excluir" class="img-fluid rounded border bg-light" style="max-height: 280px; object-fit: contain;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="modalExcluirImagemConfirmar" class="btn btn-danger" href="#">Excluir</a>
            </div>
        </div>
    </div>
</div>

<style>
    #productForm .input-error-line {
        height: 2px;
        margin-top: 2px;
        border-radius: 1px;
        background: transparent;
        transition: background 0.15s ease;
    }
    #productForm .is-invalid + .input-error-line,
    #productForm textarea.is-invalid + .input-error-line {
        background: #dc3545;
    }
</style>
<script>
// Validação básica no front para não deixar selecionar mais que o permitido
const inputImagens = document.getElementById('input-imagens');
if(inputImagens) {
    inputImagens.addEventListener('change', function() {
        const limite = <?= (int) $restante ?>;
        if (this.files.length > limite) {
            alert(`Atenção! Você só pode escolher mais ${limite} imagem(ns).`);
            this.value = "";
        }
    });
}

const productForm = document.getElementById('productForm');
if (productForm) {
    productForm.addEventListener('submit', function(e) {
        this.querySelectorAll('.error-message').forEach(function(el) { el.textContent = ''; });
        this.querySelectorAll('.form-control').forEach(function(el) { el.classList.remove('is-invalid'); });

        let temErro = false;

        const nome = this.querySelector('input[name="nome"]');
        const ref = this.querySelector('input[name="referencia"]');
        const desc = this.querySelector('textarea[name="descricao"]');

        const setErro = function(el, msg) {
            if (!el) return;
            el.classList.add('is-invalid');
            const box = document.getElementById('error-' + el.name);
            if (box) box.textContent = msg;
            temErro = true;
        };

        const nomeVal = nome.value.trim();
        if (nomeVal.length < 3) setErro(nome, "O nome deve ter pelo menos 3 caracteres.");
        else if (nomeVal.length > 255) setErro(nome, "O nome não pode exceder 255 caracteres.");

        const refVal = ref.value.trim();
        const refRegex = /^[a-zA-Z0-9-_]+$/;
        if (refVal.length < 2) setErro(ref, "A referência deve ter pelo menos 2 caracteres.");
        else if (refVal.length > 100) setErro(ref, "A referência não pode exceder 100 caracteres.");
        else if (!refRegex.test(refVal)) setErro(ref, "Use apenas letras, números, hífens ou underlines.");

        if (desc.value.length > 2000) setErro(desc, "A descrição é muito longa (máximo 2000 caracteres).");

        if (temErro) {
            e.preventDefault();
            const primeiroErro = this.querySelector('.is-invalid');
            if (primeiroErro) primeiroErro.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
}

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.js-excluir-imagem');
    if (!btn) return;
    e.preventDefault();
    const url = btn.getAttribute('data-url');
    const preview = btn.getAttribute('data-preview');
    const modalEl = document.getElementById('modalExcluirImagem');
    const imgEl = document.getElementById('modalExcluirImagemPreview');
    const confirmar = document.getElementById('modalExcluirImagemConfirmar');
    if (!modalEl || !imgEl || !confirmar || !url) return;
    imgEl.src = preview || '';
    confirmar.setAttribute('href', url);
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
});
</script>