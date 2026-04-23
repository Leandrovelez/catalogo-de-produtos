</div> 
<footer class="footer mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            <span>© 2026 Leandro Velez - Todos os direitos reservados.</span>
        </div>
    </footer>
</body>
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

<script src="https://unpkg.com/feather-icons"></script>
<script>
  feather.replace();
</script>

<?php
if (isset($_SESSION['mensagem'])):
    $tipoToast = $_SESSION['tipo_mensagem'] ?? 'info';
    $mapTipo = ['danger' => 'error', 'primary' => 'info', 'secondary' => 'info'];
    if (isset($mapTipo[$tipoToast])) {
        $tipoToast = $mapTipo[$tipoToast];
    }
    if (!in_array($tipoToast, ['success', 'error', 'info', 'warning'], true)) {
        $tipoToast = 'info';
    }
    $msgJson = json_encode((string) $_SESSION['mensagem'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
    ?>
    <script>
        toastr[<?= json_encode($tipoToast) ?>](<?= $msgJson ?>);
    </script>
    <?php
    unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']);
endif; ?>
</html>