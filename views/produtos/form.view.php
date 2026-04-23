<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        <h4><?= isset($produto['id']) ? 'Editar Produto' : 'Novo Produto' ?></h4>
    </div>
    <div class="card-body">
        <?php 
            $id = $produto['id'] ?? null;
            $destino = $id ? "admin.php?p=produtos/atualizar&id={$id}" : "admin.php?p=produtos/salvar"; 
        ?>
        
        <form action="<?= $destino ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Nome do Produto</label>
                        <input type="text" name="nome" class="form-control" 
                               value="<?= htmlspecialchars($produto['nome'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Referência (Única)</label>
                        <input type="text" name="referencia" class="form-control" 
                            value="<?= htmlspecialchars($produto['referencia'] ?? '') ?>" required>
                        <small class="text-muted">Atenção: Mudar a referência renomeará a pasta de arquivos no servidor.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="5"><?= htmlspecialchars($produto['descricao'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <h5>Imagens (Máx. 5)</h5>
                    <div id="container-imagens" class="border p-3 bg-light rounded">
                        
                        <?php if (isset($imagens) && count($imagens) > 0): ?>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <?php foreach ($imagens as $img): ?>
                                    <div class="position-relative border p-1 bg-white shadow-sm text-center">
                                        <img src="uploads/<?= $produto['referencia'] ?>/<?= $img['caminho'] ?>" 
                                             width="80" height="80" style="object-fit: cover;" class="d-block">
                                        
                                        <div class="mt-1 d-flex justify-content-center gap-2">
                                            <a href="uploads/<?= $produto['referencia'] ?>/<?= $img['caminho'] ?>" 
                                               target="_blank" class="btn btn-sm btn-warning text-white py-0 px-1">
                                            <i data-feather="eye"></i>
                                            </a>
                                            
                                            <a href="admin.php?p=produtos/atualizar&id=<?= $id ?>&delete_img=<?= $img['id'] ?>" 
                                               class="btn btn-sm btn-danger text-white py-0 px-1" 
                                               onclick="return confirm('Deletar esta imagem?')">
                                               <i data-feather="trash"></i>
                                            </a>
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

<script>
// Validação básica no front para não deixar selecionar mais que o permitido
const inputImagens = document.getElementById('input-imagens');
if(inputImagens) {
    inputImagens.addEventListener('change', function() {
        const limite = <?= $restante ?>;
        if (this.files.length > limite) {
            alert(`Atenção! Você só pode escolher mais ${limite} imagem(ns).`);
            this.value = "";
        }
    });
}
</script>