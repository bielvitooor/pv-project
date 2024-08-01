<?php
// Verificar se há um parâmetro de erro na URL
$error = isset($_GET['error']) ? $_GET['error'] : null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Administrador</title>
</head>
<body>
    <?php include('../partials/header.php'); ?>

    <main class="container mt-5">
        <h1 class="mb-4">Login do Administrador</h1>

        <div id="error-message" class="alert alert-danger d-none"></div>

        <form id="login-form" action="../controllers/AdminController.php" method="POST">
            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </main>

    <!-- Seu JavaScript personalizado -->
    <script src="/pv-project/assets/js/login.js"></script>
    
    <?php include('../partials/footer.php'); ?>
</body>
</html>
