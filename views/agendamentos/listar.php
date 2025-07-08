<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="/Agendador-de-consultas/css/styles.css">
</head>

<body class="bg-light py-5">
    <div class="container">
        <div class="card shadow-sm p-4">
            <h2 class="text-center mb-4">Painel Administrativo</h2>

            <div class="mb-3 text-end">
                <button class="btn btn-success" id="btnNovoAgendamento" data-bs-toggle="modal" data-bs-target="#modalNovo">
                    <i class="bi bi-plus-circle"></i> Novo Agendamento
                </button>
            </div>

            <?php if (empty($agendamentos)) : ?>
                <div class="alert alert-info text-center">Nenhum agendamento encontrado.</div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Data</th>
                                <th>Hora</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($agendamentos as $agendamento) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($agendamento['nome_cliente']) ?></td>
                                    <td><?= htmlspecialchars($agendamento['email_cliente']) ?></td>
                                    <td><?= formatarData($agendamento['data_consulta']) ?></td>
                                    <td><?= formatarHora($agendamento['hora_consulta']) ?></td>
                                    <td>
                                        <?php
                                        $status = strtolower($agendamento['status']);
                                        $badgeClass = match ($status) {
                                            'pendente' => 'warning',
                                            'confirmado' => 'success',
                                            'cancelado' => 'danger',
                                            default => 'secondary'
                                        };
                                        ?>
                                        <span class="badge bg-<?= $badgeClass ?>">
                                            <?= ucfirst($status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary btn-editar" data-id="<?= $agendamento['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalEditar">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button class="btn btn-sm btn-danger btn-excluir" data-id="<?= $agendamento['id'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <div class="text-center mt-4">
                <a href="../public/logout.php" class="btn btn-outline-secondary">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </a>
            </div>
        </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="conteudoModalEditar">
                <div class="modal-body text-center p-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3">Carregando formulário...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Novo Agendamento -->
    <div class="modal fade" id="modalNovo" tabindex="-1" aria-labelledby="modalNovoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="conteudoModalNovo">
                <div class="modal-body text-center p-5">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="mt-3">Carregando formulário...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast custom -->
    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999">
        <div id="toastAlert" class="toast toast-custom d-none" role="alert" aria-live="assertive" aria-atomic="true">
            <i class="bi bi-exclamation-circle"></i>
            <div id="toastMessage">Mensagem de erro</div>
            <button type="button" class="close-btn" onclick="document.getElementById('toastAlert').classList.add('d-none')">&times;</button>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="modalConfirmarExclusao" tabindex="-1" aria-labelledby="confirmarExclusaoLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top: 80px; justify-content: center;">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este agendamento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarExclusao">Confirmar</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        const showToast = (msg) => {
            const toast = document.getElementById("toastAlert");
            const msgContainer = document.getElementById("toastMessage");
            msgContainer.textContent = msg;
            toast.classList.remove("d-none");
            toast.classList.add("show");

            setTimeout(() => {
                toast.classList.remove("show");
                toast.classList.add("d-none");
            }, 4000);
        };

        // Modal Editar
        document.querySelectorAll('.btn-editar').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const url = `${window.location.origin}/Agendador-de-consultas/ajax/editar_agendamento.php?id=${id}`;
                const conteudo = document.getElementById('conteudoModalEditar');

                fetch(url)
                    .then(res => res.text())
                    .then(html => {
                        conteudo.innerHTML = html;
                        conteudo.querySelectorAll("script").forEach(oldScript => {
                            const newScript = document.createElement("script");
                            if (oldScript.src) {
                                newScript.src = oldScript.src;
                            } else {
                                newScript.textContent = oldScript.textContent;
                            }
                            document.body.appendChild(newScript);
                        });
                    })
                    .catch(() => {
                        showToast("Erro ao carregar formulário de edição.");
                    });
            });
        });

        // Modal Novo
        document.getElementById("btnNovoAgendamento").addEventListener("click", () => {
            const url = `${window.location.origin}/Agendador-de-consultas/ajax/novo_agendamento.php`;
            const conteudo = document.getElementById("conteudoModalNovo");

            fetch(url)
                .then(res => res.text())
                .then(html => {
                    conteudo.innerHTML = html;
                    conteudo.querySelectorAll("script").forEach(oldScript => {
                        const newScript = document.createElement("script");
                        if (oldScript.src) {
                            newScript.src = oldScript.src;
                        } else {
                            newScript.textContent = oldScript.textContent;
                        }
                        document.body.appendChild(newScript);
                    });
                })
                .catch(() => {
                    showToast("Erro ao carregar formulário de novo agendamento.");
                });
        });

        // Excluir com AJAX
        let idParaExcluir = null;

        // Abre o modal de confirmação
        document.querySelectorAll('.btn-excluir').forEach(button => {
            button.addEventListener('click', function() {
                idParaExcluir = this.dataset.id;
                const modal = new bootstrap.Modal(document.getElementById('modalConfirmarExclusao'));
                modal.show();
            });
        });

        // Confirma exclusão com AJAX
        document.getElementById('btnConfirmarExclusao').addEventListener('click', () => {
            if (!idParaExcluir) return;

            fetch('/Agendador-de-consultas/ajax/excluir_agendamento.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${idParaExcluir}`
                })
                .then(res => res.json())
                .then(data => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmarExclusao'));
                    modal.hide();
                    if (data.success) {
                        showToast("Agendamento excluído com sucesso!",);
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast(data.mensagem || 'Erro ao excluir agendamento.');
                    }
                })
                .catch(() => {
                    showToast('Erro ao processar requisição.');
                });
        });
    </script>
</body>

</html>