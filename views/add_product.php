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
    <h2>Adicionar Novo Produto</h2>
    <form action="../scripts/add_product.php" method="POST">
        <label for="name">Nome do Produto:</label>
        <input type="text" id="name" name="name_product" required><br>
        
        <label for="price">Preço:</label>
        <input type="text" id="price" name="price" required><br>
        
        <label for="quantity">Quantidade:</label>
        <input type="text" id="quantity" name="quantity" required><br>
        
        <input type="submit" value="Adicionar Produto">
    </form>
</main>
<?php include('../partials/footer.php'); ?>
