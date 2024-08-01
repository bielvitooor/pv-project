<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
</head>
<body>
    <?php include('../partials/header.php'); ?>

    <main class="container mt-5">
        <h1 class="mb-4">Painel Administrativo</h1>
        <h2 class="mb-4">Adicionar Novo Produto</h2>
        <form action="../scripts/add_product.php" method="POST">
            <div class="form-group">
                <label for="name">Nome do Produto:</label>
                <input type="text" id="name" name="name_product" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="price">Preço:</label>
                <input type="text" id="price" name="price" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="quantity">Quantidade:</label>
                <input type="text" id="quantity" name="quantity" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Adicionar Produto</button>
        </form>
    </main>
    
    <?php include('../partials/footer.php'); ?>
</body>
</html>
