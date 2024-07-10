<?php include('../partials/header.php'); ?>
    <main>
        <h1>Produtos Disponíveis</h1>
        <form action="process_order.php" method="POST">
            <ul>
                <li>
                    <input type="checkbox" id="product1" name="products[]" value="Produto 1 - R$ 10.00 - Quantidade: 5">
                    <label for="product1">Produto 1 - R$ 10.00 - Quantidade: 5</label>
                </li>
                <li>
                    <input type="checkbox" id="product2" name="products[]" value="Produto 2 - R$ 20.00 - Quantidade: 3">
                    <label for="product2">Produto 2 - R$ 20.00 - Quantidade: 3</label>
                </li>
                <li>
                    <input type="checkbox" id="product3" name="products[]" value="Produto 3 - R$ 30.00 - Quantidade: 7">
                    <label for="product3">Produto 3 - R$ 30.00 - Quantidade: 7</label>
                </li>
            </ul>
            <input type="submit" value="Realizar Pedido">
        </form>
    </main>
<?php include('../partials/footer.php'); ?>
