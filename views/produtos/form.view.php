<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><?= isset($produto) ? 'Editar Produto' : 'Novo Produto' ?></h4>
    </div>
    <div class="card-body">
        <form action="admin.php?p=produtos/salvar<?= isset($produto) ? '&id=' . $produto['id'] : '' ?>" 
              method="POST" 
              enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Produto</label>
                        <input type="text" name="nome" id="nome" class="form-control" 
                               value="<?= $produto['nome'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="referencia" class="form-label">Referência</label>
                        <input type="text" name="referencia" id="referencia" class="form-control" 
                            value="<?= $produto['referencia'] ?? '' ?>" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea name="descricao" id="descricao" class="form-control" rows="3"><?= $produto['descricao'] ?? '' ?></textarea>
            </div>
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem do Produto</label>
                <input type="file" name="imagem" id="imagem" class="form-control" <?= isset($produto) ? '' : 'required' ?>>
                <?php if (isset($produto) && $produto['imagem']): ?>
                    <div class="mt-2">
                        <small class="text-muted">Imagem atual:</small><br>
                        <img src="uploads/<?= $produto['imagem'] ?>" width="100" class="img-thumbnail">
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="admin.php?p=produtos/index" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar Produto</button>
            </div>
        </form>
    </div>
</div>