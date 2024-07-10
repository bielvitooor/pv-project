<?php include('../partials/header.php'); ?>
    <main>
        <h1>Resumo do Pedido</h1>
        <ul>
            <?php
            if (isset($_POST['products'])) {
                foreach ($_POST['products'] as $product) {
                    echo "<li>$product</li>";
                }
            } else {
                echo "<li>Nenhum produto selecionado.</li>";
            }
            ?>
        </ul>
        <a href="products.php">Voltar para Produtos</a>
    </main>
<?php include('../partials/footer.php'); ?>
