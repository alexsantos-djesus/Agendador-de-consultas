<?php
require_once __DIR__ . '/../includes/functions.php';
session_start();
?>

<div class="modal-header">
    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Novo Agendamento</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
</div>

<form id="formNovoAgendamento">
    <div class="modal-body">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" name="telefone" class="form-control">
        </div>

        <div class="mb-3">
            <label for="data_consulta" class="form-label">Data:</label>
            <input type="date" name="data_consulta" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="hora_consulta" class="form-label">Hora:</label>
            <input type="time" name="hora_consulta" class="form-control" required>
        </div>

        <div id="mensagemErro" class="alert alert-danger d-none text-center"></div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Agendar
        </button>
    </div>
</form>

<script>
    document.getElementById("formNovoAgendamento").addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const baseUrl = `${window.location.origin}/Agendador-de-consultas`;

        fetch(`${baseUrl}/controllers/AgendamentoController.php?acao=salvar`, {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(res => res.text())
            .then(texto => {
                if (texto.trim() === "ok") {
                    const modal = bootstrap.Modal.getInstance(document.getElementById("modalNovo"));
                    modal.hide();

                    const toast = document.createElement('div');
                    toast.className = "position-fixed top-50 start-50 translate-middle bg-white border-start border-5 border-success shadow-lg rounded-3 p-3 animate__animated animate__fadeInDown";
                    toast.style.zIndex = 1056;
                    toast.style.minWidth = '320px';
                    toast.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="me-3 fs-3 text-success">✅</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-success">Agendamento criado com sucesso!</div>
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
                msg.innerText = "Erro ao agendar.";
            });
    });
</script>