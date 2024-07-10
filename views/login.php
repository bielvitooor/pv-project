<?php
session_start();

// Verificar se o usuário já está logado
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: add_product.php");
    exit();
}

// Processar o formulário de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Verificar credenciais (substitua isso pela verificação no banco de dados)
    if ($login === 'admin' && $password === 'admin') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: add_product.php");
        exit();
    } else {
        $error = "Login ou senha incorretos.";
    }
}
?>

<?php include('../partials/header.php'); ?>
<main>
    <h1>Login do Administrador</h1>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form action="login.php" method="POST">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required><br>
        
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br>
        
        <input type="submit" value="Entrar">
    </form>
</main>
<?php include('../partials/footer.php'); ?>
