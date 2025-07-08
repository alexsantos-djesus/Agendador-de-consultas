<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

// Carrega variáveis do .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function enviarEmailConfirmacao($destinatario, $nome, $data, $hora)
{
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP com variáveis do .env
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $mail->Port       = $_ENV['MAIL_PORT'];

        // Remetente e destinatário
        $mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($destinatario, $nome);

        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = 'Confirmação de Agendamento';
        $mail->Body = "
            <h3>Olá, {$nome}</h3>
            <p>Seu agendamento foi confirmado com sucesso para o dia <strong>{$data}</strong> às <strong>{$hora}</strong>.</p>
            <p>Se precisar reagendar, entre em contato conosco.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log do erro (opcional)
        file_put_contents(__DIR__ . '/../logs/mail_error.log', $mail->ErrorInfo . PHP_EOL, FILE_APPEND);
        return false;
    }
}

function enviarEmailSimples($destinatario, $assunto, $html)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = getenv('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = getenv('MAIL_USERNAME');
        $mail->Password = getenv('MAIL_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = getenv('MAIL_PORT');

        $mail->setFrom(getenv('MAIL_USERNAME'), 'Agendamento');
        $mail->addAddress($destinatario);

        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body = $html;

        $mail->send();
    } catch (Exception $e) {
        // log de erro, se quiser
    }
}