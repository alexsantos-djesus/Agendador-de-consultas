<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/Agendamento.php';

$agendamento = new Agendamento($conn);
$dados = $agendamento->listarTodos();

$eventos = [];

foreach ($dados as $item) {
    $eventos[] = [
        'title' => $item['nome_cliente'],
        'start' => $item['data_consulta'] . 'T' . $item['hora_consulta'],
        'color' => match (strtolower($item['status'])) {
            'confirmado' => '#198754',
            'cancelado' => '#dc3545',
            default => '#ffc107'
        }
    ];
}

header('Content-Type: application/json');
echo json_encode($eventos);
