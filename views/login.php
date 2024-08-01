<?php
// Verificar se há um parâmetro de erro na URL
$error = isset($_GET['error']) ? $_GET['error'] : null;
?>

<?php include('../partials/header.php'); ?>
<main>
    <h1>Login do Administrador</h1>

    <div id="error-message" style="color: red;"></div>

    <form id="login-form" action="../controllers/AdminController.php" method="POST">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required><br>
        
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br>
        
        <input type="submit" value="Entrar">
    </form>
</main>

<script src="/pv-project/assets/js/login.js"></script>

<?php include('../partials/footer.php'); ?>
