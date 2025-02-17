<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sucesso</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success text-center" role="alert">
            <?php
            // Exibe a mensagem de sucesso passada via GET
            if (isset($_GET['message'])) {
                echo htmlspecialchars($_GET['message']);
            } else {
                echo "Operação realizada com sucesso!";
            }
            ?>
        </div>
        <div class="text-center">
            <a href="../index.php" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</body>
</html>