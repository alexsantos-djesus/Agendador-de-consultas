<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../public/login.php');
    exit;
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../models/Agendamento.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/mailer.php';

$agendamento = new Agendamento($conn);

$acao = $_GET['acao'] ?? 'listar';

switch ($acao) {
    case 'salvar':
        $nome = sanitizarTexto($_POST['nome'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $telefone = sanitizarTexto($_POST['telefone'] ?? '');
        $data = $_POST['data_consulta'] ?? '';
        $hora = $_POST['hora_consulta'] ?? '';

        if (empty($nome) || empty($email) || empty($data) || empty($hora)) {
            retornarErro("Todos os campos obrigatórios devem ser preenchidos.");
        }

        $ok = $agendamento->salvar($nome, $email, $telefone, $data, $hora);

        if ($ok) {
            enviarEmailConfirmacao($email, $nome, formatarData($data), formatarHora($hora));
            retornarSucesso('Agendamento criado com sucesso!');
        } else {
            retornarErro("Erro ao salvar o agendamento.");
        }
        break;

    case 'calendario':
        include __DIR__ . '/../views/agendamentos/calendario.php';
        break;


    case 'listar':
    default:
        $agendamentos = $agendamento->listarTodos();
        include __DIR__ . '/../views/agendamentos/listar.php';
        break;

    case 'atualizar':
        $id = intval($_POST['id'] ?? 0);
        $nome = sanitizarTexto($_POST['nome'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $telefone = sanitizarTexto($_POST['telefone'] ?? '');
        $data = $_POST['data_consulta'] ?? '';
        $hora = $_POST['hora_consulta'] ?? '';
        $status = sanitizarTexto($_POST['status'] ?? '');


        if ($id <= 0 || empty($nome) || empty($email) || empty($data) || empty($hora) || empty($status)) {
            echo "Todos os campos são obrigatórios.";
            exit;
        }

        $ok = $agendamento->atualizar($id, $nome, $email, $telefone, $data, $hora, $status);

        if ($ok) {
            echo "ok";
        } else {
            echo "Erro ao atualizar agendamento.";
        }
        exit;


    case 'excluir':
        $id = intval($_GET['id'] ?? 0);

        if ($id > 0) {
            $ok = $agendamento->excluir($id);
            if ($ok) {
                $_SESSION['success'] = 'Agendamento excluído com sucesso!';
            } else {
                $_SESSION['error'] = 'Erro ao excluir agendamento.';
            }
        } else {
            $_SESSION['error'] = 'ID inválido para exclusão.';
        }

        header("Location: ../public/dashboard.php");
        exit;
}

// Funções auxiliares

function isAjaxRequest()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

function retornarErro($mensagem)
{
    if (isAjaxRequest()) {
        echo $mensagem;
        exit;
    }
    $_SESSION['error'] = $mensagem;
    header("Location: ../public/dashboard.php");
    exit;
}

function retornarSucesso($mensagem, $viaAjax = false)
{
    if ($viaAjax || isAjaxRequest()) {
        echo "ok";
        exit;
    }
    $_SESSION['success'] = $mensagem;
    header("Location: ../public/dashboard.php");
    exit;
}
