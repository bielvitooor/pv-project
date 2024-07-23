<?php
// Verificar se há um parâmetro de erro na URL
$error = isset($_GET['error']) ? $_GET['error'] : null;
?>

<?php include('../partials/header.php'); ?>
<main>
    <h1>Login do Administrador</h1>

    <div id="error-message" style="color: red;"></div>

    <form id="login-form" action="../Controller/AdminController.php" method="POST">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required><br>
        
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br>
        
        <input type="submit" value="Entrar">
    </form>
</main>
<script>
    //jogar em arquivo js só--------------------------------------------
    // Função para obter parâmetros da URL
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Exibir mensagem de erro se houver
    document.addEventListener('DOMContentLoaded', function() {
        var error = getUrlParameter('error');
        var errorMessage = '';

        switch (error) {
            case '1':
                errorMessage = "Usuário ou senha incorretos. Tente novamente.";
                break;
            case '2':
                errorMessage = "Sua conta está desativada. Entre em contato com o suporte.";
                break;
            default:
                errorMessage = "Ocorreu um erro durante o login.";
                break;
        }

        if (errorMessage) {
            document.getElementById('error-message').textContent = errorMessage;
        }
    });
</script>

<?php include('../partials/footer.php'); ?>
