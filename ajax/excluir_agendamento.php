<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/Agendamento.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
    echo json_encode(['success' => false, 'mensagem' => 'Requisição inválida.']);
    exit;
}

$id = intval($_POST['id']);
$agendamento = new Agendamento($conn);

if ($agendamento->excluir($id)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'mensagem' => 'Erro ao excluir.']);
}
