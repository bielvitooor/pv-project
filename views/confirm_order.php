<?php
require_once ("../banco/Connection.php");
require_once ("../dao/ProductDao.php");
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
    } catch (\PDOException $error) {
        die("Erro ao buscar produtos: " . $error->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
<?php include ('../partials/header.php'); ?>
<main>
    <?php if(!empty($products)){
        ?>
    <h1>Confirmação do Pedido</h1>

    <form >
        <section class="produtos">
            <?php foreach ($products as $product): ?>
                <div class="produto">
                    <h2><?= $product['name_product'] ?></h2>
                    <p>R$ <?= $product['price'] ?></p>
                    <p>Quantidade: <?= $product['selected_quantity'] ?></p>
                    <input type="hidden" name="products[<?= $product['idproduct'] ?>]"
                        value="<?= $product['selected_quantity'] ?>">
                </div>
            <?php endforeach; ?>
        </section>

        <div class="total">
            <!-- Calcular o total aqui -->
            <?php
            $total = 0.0;
            foreach ($products as $product) {
                $total += $product['price'] * $product['selected_quantity'];
            }
            ?>
            <p>Total: R$ <?= number_format($total, 2) ?></p>
        </div>
    </form>
    <button>Confirmar Pedido</button>
    <dialog open>
        <h2>Confirme seus Dados</h2>
        <form id="review-order" action="#" method="POST">
            <section id="confirm-product"></section>
            <div class="total">
                <p>Total: R$<strong id="confirm-subtotal">0.00</strong></p>
            </div>
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>
            <div></div>
            <button type="submit">Confirmar Pedido</button>
        </form>
    </dialog>
</main>
<?php } else {
    header("Location: ../index.php");
} ?>
    
<?php //include('../partials/footer.php'); ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cpfInput = document.getElementById("cpf");
        const nameSection = document.getElementById("name-section");

        cpfInput.addEventListener("blur", function () {
            const cpf = cpfInput.value;
            fetch(`verifica_cpf.php?cpf=${cpf}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        nameSection.style.display = "none";
                    } else {
                        nameSection.style.display = "block";
                    }
                });
        });
    });
</script>