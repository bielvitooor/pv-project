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
<?php include('partials/header.php'); ?>

<main>
    <h1>Bem-vindo ao Posto de Vendas do Campus Ceres</h1>
    <form action="/pv-project/views/confirm_order.php" method="POST" id="product-selected">
        <section class="produtos">
            <?php foreach($products as $product): ?>
            <div class="produto">
                <img src="/pv-project/assets/images/<?=$product['name_product']?>.jpg" alt="<?=$product['name_product'] ?>">
                <h2><?= $product['name_product'] ?></h2>
                <p id="price-<?= $product['idproduct']?>">R$ <?= $product['price'] ?></p>
                <p id="avaliable-<?= $product['idproduct'] ?>"><?=$product['quantity'] ?> restantes</p>
                <div class="quantidade">
                    <button type="button" class="decrement" data-id="<?= $product['idproduct'] ?>">-</button>
                    <input type="text" id="quantity-<?= $product['idproduct'] ?>" class="counter" name="quantities[<?= $product['idproduct']?>]" value="0" readonly>
                    <button type="button" class="increment" data-id="<?= $product['idproduct'] ?>">+</button>
                </div>
            </div>
            <?php endforeach; ?>  
        </section>

        <div class="total">
            <p>Total: R$<strong id="subtotal">0.00</strong></p>
        </div>
        <button type="submit" class="comprar">Comprar</button>
    </form>
</main>

<?php include('partials/footer.php'); ?>
<script src="scripts/main.js"></script>