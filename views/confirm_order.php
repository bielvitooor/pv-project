<?php
require_once("../banco/Connection.php");
require_once("../dao/ProductDao.php");
require_once("../dao/PaymentDao.php");

use config\banco\Connection as Connection;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantities = $_POST['quantities'];

    try {
        $conn = Connection::getConnection();
        $productDao = new ProductDao($conn);
        $products = [];
        foreach ($quantities as $id => $quantity) {
            if ($quantity > 0) {
                $product = $productDao->getProductById($id);
                if ($product) {
                    $product['selected_quantity'] = $quantity;
                    $products[] = $product;
                }
            }
        }
        $paymentDao = new PaymentDao($conn);
        $payments = $paymentDao->getAllPayments();
    } catch (\PDOException $error) {
        die("Erro ao buscar produtos: " . $error->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
<?php include('../partials/header.php'); ?>
<main>
    <?php if (!empty($products)) { ?>
    <h1>Confirmação do Pedido</h1>

    <form id="confirm-form" method="POST">
        <section class="produtos">
            <?php foreach ($products as $product): ?>
                <div class="produto" data-id="<?= $product['idproduct'] ?>">
                    <h2><?= $product['name_product'] ?></h2>
                    <p>R$ <span class="price"><?= $product['price'] ?></span></p>
                    <div class="quantidade">
                        <button type="button" class="decrement" data-id="<?= $product['idproduct'] ?>">-</button>
                        <input type="text" id="quantity-<?= $product['idproduct'] ?>" class="counter" name="quantities[<?= $product['idproduct']?>]" value="<?= $product['selected_quantity'] ?>" readonly>
                        <button type="button" class="increment" data-id="<?= $product['idproduct'] ?>">+</button>
                    </div>
                    <button type="button" class="remove" data-id="<?= $product['idproduct'] ?>">Excluir</button>
                </div>
            <?php endforeach; ?>
        </section>

        <div class="total">
            <?php
            $total = 0.0;
            foreach ($products as $product) {
                $total += $product['price'] * $product['selected_quantity'];
            }
            ?>
            <p>Total: R$ <strong id="subtotal"><?= number_format($total, 2) ?></strong></p>
        </div>
    </form>
    <button id="confirmar-pedido">Confirmar Pedido</button>

    <dialog id="modal-confirmacao" open>
        <h2>Confirme seus Dados</h2>
        <form id="review-order" action="../controllers/GuestController.php" method="POST">
            
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>
            
            <div id="name-section" >
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name">
            </div>

            <label for="payment">Forma de Pagamento:</label>
            <select id="payment" name="payment">
                <?php foreach ($payments as $payment):?>
                    <option value="<?=$payment['idpayment']?>"><?=$payment['tipo'] ?></option>
                    
                <?php endforeach; ?>
            </select>

            <?php foreach ($products as $product): ?>
                <input type="hidden" name="quantities[<?= $product['idproduct'] ?>]" value="<?= $product['selected_quantity'] ?>">
            <?php endforeach; ?>

            <button type="submit">Confirmar Pedido</button>
            <button type="button" id="fechar-modal">Fechar</button>
        </form>
    </dialog>
    <?php } else { header("Location: ../index.php"); } ?>
</main>

<?php include('../partials/footer.php'); ?>

<script src="../scripts/main.js"></script>
