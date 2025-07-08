<?php
require_once __DIR__ . '/../../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Agendar Consulta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 e estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="max-width: 600px; width: 100%;">
        <h2 class="text-center mb-4">Agendar Nova Consulta</h2>

        <form action="/Agendador-de-consultas/controllers/PublicoController.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="text" name="telefone" id="telefone" class="form-control">
            </div>

            <div class="mb-3">
                <label for="data_consulta" class="form-label">Data:</label>
                <input type="date" name="data_consulta" id="data_consulta" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="hora_consulta" class="form-label">Hora:</label>
                <input type="time" name="hora_consulta" id="hora_consulta" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Agendar</button>

            <div class="text-center mt-3">
                <a href="/Agendador-de-consultas/controllers/PublicoController.php?acao=listar" class="btn btn-secondary">Ver Lista de Consultas</a>
            </div>
        </form>
    </div>

    <!-- Toast de erro -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div id="toastErro" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="mensagemToast">Erro genérico</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const erro = <?php echo json_encode($_SESSION['error'] ?? ''); ?>;
            if (erro !== "") {
                const toastEl = document.getElementById('toastErro');
                document.getElementById('mensagemToast').textContent = erro;
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
                <?php unset($_SESSION['error']); ?>
            }
        });
    </script>
</body>

</html>