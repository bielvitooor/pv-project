<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<?php include('../partials/header.php'); ?>
<main>
    <h1>Painel Administrativo</h1>
    <ul>
        <li><a href="add_product.php">Adicionar Produto</a></li>
    </ul>
</main>
<?php include('../partials/footer.php'); ?>
