<div class="d-flex justify-content-between align-items-center mb-4 mt-4">
    <h3>Gerenciamento de Produtos</h3>
    <a href="admin.php?p=produtos/salvar" class="btn btn-success d-flex align-items-center gap-2">
        <i data-feather="plus-circle"></i> Novo Produto
    </a>
</div>

<table class="table table-hover bg-white shadow-sm rounded">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Referência</th>
            <th class="text-center">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($produtos as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['nome']) ?></td>
            <td><?= htmlspecialchars($p['referencia']) ?></td>
            <td class="text-center">
                <a href="admin.php?p=produtos/atualizar&id=<?= $p['id'] ?>" class="btn btn-sm btn-info text-white">
                    <i data-feather="edit"></i>
                </a>
                
                <button type="button" 
                        class="btn btn-sm btn-danger btn-excluir" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalExcluir"
                        data-id="<?= $p['id'] ?>"
                        data-nome="<?= htmlspecialchars($p['nome']) ?>"
                        data-ref="<?= htmlspecialchars($p['referencia']) ?>">
                    <i data-feather="trash"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="modalExcluir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Você está prestes a excluir o seguinte produto:</p>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item"><strong>Nome:</strong> <span id="modal-nome"></span></li>
                    <li class="list-group-item"><strong>Ref:</strong> <span id="modal-ref"></span></li>
                </ul>
                <p class="text-danger small"><strong>Atenção:</strong> Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="btn-confirmar-exclusao" class="btn btn-danger">Sim, Excluir</a>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-excluir').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const nome = this.getAttribute('data-nome');
        const ref = this.getAttribute('data-ref');

        // Preenche os dados no Modal
        document.getElementById('modal-nome').textContent = nome;
        document.getElementById('modal-ref').textContent = ref;

        // Ajusta o link do botão de confirmação
        document.getElementById('btn-confirmar-exclusao').href = `admin.php?p=produtos/excluir&id=${id}`;
    });
});
</script>