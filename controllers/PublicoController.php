<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/Agendamento.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();

$agendamento = new Agendamento($conn);

// Rota de salvar consulta pública
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = sanitizarTexto($_POST['nome'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $telefone = sanitizarTexto($_POST['telefone'] ?? '');
    $data = $_POST['data_consulta'] ?? '';
    $hora = $_POST['hora_consulta'] ?? '';

    if (empty($nome) || empty($email) || empty($data) || empty($hora)) {
        $_SESSION['error'] = "Por favor, preencha todos os campos obrigatórios.";
        header("Location: PublicoController.php?acao=form");
        exit;
    }

    $ok = $agendamento->salvar($nome, $email, $telefone, $data, $hora);

    if ($ok) {
        header("Location: PublicoController.php?acao=listar");
        exit;
    } else {
        $_SESSION['error'] = "Erro ao agendar consulta.";
        header("Location: PublicoController.php?acao=form");
        exit;
    }
}

// Exibir o formulário ou listagem
$acao = $_GET['acao'] ?? 'form';

if ($acao === 'form') {
    include __DIR__ . '/../views/publico/form_agendar.php';
} else {
    $agendamentos = $agendamento->listarTodos();
    include __DIR__ . '/../views/publico/listar.php';
}
