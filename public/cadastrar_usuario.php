<?php

require_once '../includes/db.php';

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $senha = $_POST['password'];

    if (empty($username) || empty($senha)) {
        $erro = "Preencha todos os campos.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $erro = "Este usuário já existe.";
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hash);
            if ($stmt->execute()) {
                $mensagem = "Usuário cadastrado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .toast-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
        }

        .toast-custom {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .toast-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border-left: 5px solid #198754;
        }

        .toast-error {
            background-color: #f8d7da;
            color: #842029;
            border-left: 5px solid #dc3545;
        }

        .close-btn {
            margin-left: auto;
            background: none;
            border: none;
            color: inherit;
            font-size: 1.2rem;
        }

        .card {
            border-radius: 1rem;
        }
    </style>
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <!-- Toasts -->
    <div class="toast-container">
        <?php if ($erro): ?>
            <div class="toast-custom toast-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span><?= htmlspecialchars($erro) ?></span>
                <button class="close-btn" onclick="$(this).parent().fadeOut();">&times;</button>
            </div>
        <?php elseif ($mensagem): ?>
            <div class="toast-custom toast-success">
                <i class="bi bi-check-circle-fill"></i>
                <span><?= htmlspecialchars($mensagem) ?></span>
                <button class="close-btn" onclick="$(this).parent().fadeOut();">&times;</button>
            </div>
        <?php endif; ?>
    </div>

    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Cadastrar Usuário</h2>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Usuário:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Cadastrar</button>

            <div class="text-center mt-3">
                <a href="login.php" class="text-decoration-none">Voltar ao login</a>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('.toast-custom').fadeOut();
            }, 5000);
        });
    </script>
</body>

</html>