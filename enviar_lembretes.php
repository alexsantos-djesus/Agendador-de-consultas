<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/mailer.php';
require_once __DIR__ . '/models/Agendamento.php';

$agendamento = new Agendamento($conn);

$amanha = date('Y-m-d', strtotime('+1 day'));
$lembretes = $conn->query("SELECT * FROM agendamentos WHERE data_consulta = '$amanha' AND status = 'confirmado'");

while ($row = $lembretes->fetch_assoc()) {
    $nome = $row['nome_cliente'];
    $email = $row['email_cliente'];
    $data = formatarData($row['data_consulta']);
    $hora = formatarHora($row['hora_consulta']);

    $assunto = "Lembrete de Consulta - Amanhã";
    $mensagem = "
        <h3>Olá, {$nome}</h3>
        <p>Este é um lembrete da sua consulta marcada para <strong>{$data}</strong> às <strong>{$hora}</strong>.</p>
        <p>Se não puder comparecer, por favor, entre em contato conosco com antecedência.</p>
    ";

    enviarEmailSimples($email, $assunto, $mensagem);
}
