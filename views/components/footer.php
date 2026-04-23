</div> 
<footer class="text-center mt-5 py-3 bg-light">
    <p>&copy; 2026 - Teste Técnico PHP</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Configurações globais do Toastr (opcional)
    toastr.options = {
        "closeButton": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
    }
</script>

<?php
// Lógica para disparar o Toastr baseado na sessão
if (isset($_SESSION['mensagem'])): ?>
    <script>
        toastr["<?= $_SESSION['tipo_mensagem'] ?>"]("<?= $_SESSION['mensagem'] ?>");
    </script>
    <?php 
    // Limpa a mensagem para não exibir de novo no refresh
    unset($_SESSION['mensagem']); 
    unset($_SESSION['tipo_mensagem']); 
endif; ?>
</body>
</html>