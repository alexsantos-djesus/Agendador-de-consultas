<?php
require_once __DIR__ . '/../../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Consultas Agendadas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Horários Agendados</h1>

        <div class="mb-4 text-center">
            <a href="/Agendador-de-consultas/controllers/PublicoController.php?acao=form" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Agendar Nova Consulta
            </a>
        </div>

        <?php if (!empty($agendamentos)) : ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agendamentos as $agendamento) : ?>
                            <?php
                            $status = strtolower($agendamento['status'] ?? 'pendente');
                            $badgeClass = match ($status) {
                                'pendente' => 'warning',
                                'confirmado' => 'success',
                                'cancelado' => 'danger',
                                default => 'secondary'
                            };
                            ?>
                            <tr>
                                <td><?= formatarData($agendamento['data_consulta']) ?></td>
                                <td><?= formatarHora($agendamento['hora_consulta']) ?></td>
                                <td><span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($status) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="alert alert-warning text-center">Nenhuma consulta agendada no momento.</div>
        <?php endif; ?>
    </div>
</body>

</html>