<?php
session_start();
include '../includes/db.php';

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $senha_fornecida = $_POST['password'];

    if (empty($username) || empty($senha_fornecida)) {
        $_SESSION['error'] = "Por favor, preencha todos os campos.";
        header('Location: login.php');
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    if (!$stmt) {
        $_SESSION['error'] = "Erro ao acessar o banco de dados.";
        header('Location: login.php');
        exit;
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        if (password_verify($senha_fornecida, $usuario['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $usuario['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $_SESSION['error'] = "Senha incorreta.";
            header('Location: login.php');
            exit;
        }
    } else {
        $_SESSION['error'] = "Usuário não encontrado.";
        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - Agendador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <!-- Toast moderno -->
    <div class="toast-container">
        <div id="toastErro" class="toast-custom d-none">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span id="mensagemToast"></span>
            <button class="close-btn" onclick="$('#toastErro').fadeOut();">&times;</button>
        </div>
    </div>

    <!-- Login Form -->
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Login</h2>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="username" class="form-label">Usuário:</label>
                <input type="text" id="username" name="username" class="form-control form-control-lg" required>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Senha:</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg" required>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">Entrar</button>

            <div class="text-center mt-3">
                <a href="cadastrar_usuario.php" class="text-decoration-none">Cadastrar novo usuário</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap e Toast JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script>
        $(document).ready(function() {
            const erro = <?= json_encode($error) ?>;
            if (erro !== "") {
                $("#mensagemToast").text(erro);
                $("#toastErro").removeClass("d-none").hide().fadeIn();

                setTimeout(() => {
                    $("#toastErro").fadeOut();
                }, 6000);
            }
        });
    </script>
</body>

</html>