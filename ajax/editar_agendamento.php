<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Agendamento.php';
require_once __DIR__ . '/../includes/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['loggedin'])) {
    http_response_code(403);
    exit('Acesso negado.');
}

$id = intval($_GET['id'] ?? 0);
$agendamento = new Agendamento($conn);
$dados = $agendamento->buscarPorId($id);

if (!$dados) {
    echo '<div class="modal-body text-danger text-center">Agendamento não encontrado.</div>';
    exit;
}
?>

<div class="modal-header">
    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Editar Agendamento</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
</div>

<form id="formEditarAgendamento">
    <div class="modal-body">
        <input type="hidden" name="id" value="<?= $dados['id'] ?>">

        <div class="mb-3">
            <label>Nome:</label>
            <input type="text" name="nome" class="form-control" value="<?= sanitizarTexto($dados['nome_cliente']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="<?= sanitizarTexto($dados['email_cliente']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Telefone:</label>
            <input type="text" name="telefone" class="form-control" value="<?= sanitizarTexto($dados['telefone_cliente']) ?>">
        </div>

        <div class="mb-3">
            <label>Data:</label>
            <input type="date" name="data_consulta" class="form-control" value="<?= $dados['data_consulta'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Hora:</label>
            <input type="time" name="hora_consulta" class="form-control" value="<?= $dados['hora_consulta'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Status:</label>
            <select name="status" class="form-select" required>
                <option value="Pendente" <?= $dados['status'] === 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                <option value="Confirmado" <?= $dados['status'] === 'Confirmado' ? 'selected' : '' ?>>Confirmado</option>
                <option value="Cancelado" <?= $dados['status'] === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
            </select>
        </div>

        <div id="mensagemErro" class="alert alert-danger d-none text-center"></div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Atualizar
        </button>
    </div>
</form>

<script>
    (() => {
        const form = document.getElementById("formEditarAgendamento");
        form.addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const baseUrl = `${window.location.origin}/Agendador-de-consultas`;

            fetch(`${baseUrl}/controllers/AgendamentoController.php?acao=atualizar`, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                })
                .then(resp => resp.text())
                .then(texto => {
                    if (texto.trim() === "ok") {
                        const modal = bootstrap.Modal.getInstance(document.getElementById("modalEditar"));
                        modal.hide();

                        const toast = document.createElement('div');
                        toast.className = "position-fixed top-0 start-50 translate-middle-x bg-white border-start border-5 border-success shadow-lg rounded-3 p-3 mt-4 animate__animated animate__fadeInDown";
                        toast.style.zIndex = 1056;
                        toast.style.minWidth = '320px';
                        toast.innerHTML = `
                            <div class="d-flex align-items-center">
                                <div class="me-3 fs-3 text-success">✅</div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-success">Agendamento atualizado com sucesso!</div>
                                </div>
                                <button type="button" class="btn-close ms-3" data-bs-dismiss="toast" aria-label="Fechar"></button>
                            </div>
                        `;
                        document.body.appendChild(toast);

                        setTimeout(() => {
                            toast.classList.replace("animate__fadeInDown", "animate__fadeOutUp");
                            setTimeout(() => toast.remove(), 800);
                        }, 2000);

                        setTimeout(() => location.reload(), 1500);
                    } else {
                        const msg = document.getElementById("mensagemErro");
                        msg.classList.remove("d-none");
                        msg.innerText = texto;
                    }
                })
                .catch(() => {
                    const msg = document.getElementById("mensagemErro");
                    msg.classList.remove("d-none");
                    msg.innerText = "Erro ao atualizar o agendamento.";
                });
        });
    })();
</script>