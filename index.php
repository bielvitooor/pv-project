<?php
require_once("banco/Connection.php");
require_once("dao/ProductDao.php");
require_once("models/Product.php");
use config\banco\Connection as Connection;

try {
    $conn = Connection::getConnection();
    $productDao = new ProductDao($conn);
    $products = $productDao->showAllProducts();
} catch (\PDOException $error) {
    die("Erro ao buscar produtos: " . $error->getMessage());
}
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posto de Vendas do Campus Ceres</title>
    <!-- Bootstrap CSS via CDN -->

</head>
<body>
    <?php include('partials/header.php'); ?>

    <main class="container mt-4">
        <h1 class="mb-4">Bem-vindo ao Posto de Vendas do Campus Ceres</h1>
        <form action="/pv-project/views/confirm_order.php" method="POST" id="product-selected">
            <section class="produtos row">
                <?php foreach($products as $product): ?>
                <div class="produto col-md-4 mb-4">
                    <div class="card">
                        <img src="/pv-project/assets/images/<?=$product['name_product']?>.jpg" class="card-img-top" alt="<?=$product['name_product'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name_product'] ?></h5>
                            <p class="card-text" id="price-<?= $product['idproduct']?>">R$ <?= $product['price'] ?></p>
                            <p class="card-text" id="avaliable-<?= $product['idproduct'] ?>"><?=$product['quantity'] ?> restantes</p>
                            <div class="quantidade form-inline">
                                <button type="button" class="btn btn-secondary mr-2 decrement" data-id="<?= $product['idproduct'] ?>">-</button>
                                <input type="text" id="quantity-<?= $product['idproduct'] ?>" class="form-control mr-2 counter" name="quantities[<?= $product['idproduct']?>]" value="0" readonly>
                                <button type="button" class="btn btn-secondary increment" data-id="<?= $product['idproduct'] ?>">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>  
            </section>

            <div class="total mt-4">
                <p>Total: R$<strong id="subtotal">0.00</strong></p>
            </div>
            <button type="submit" class="btn btn-success">Comprar</button>
        </form>
    </main>

    <?php include('partials/footer.php'); ?>

    <!-- jQuery, Popper.js, and Bootstrap JS via CDN -->

    <script src="/pv-project/assets/js/main.js"></script>
</body>
</html>
