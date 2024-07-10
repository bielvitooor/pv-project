<?php include('../partials/header.php'); ?>
<main>
    <h1>Pedidos</h1>
    <?php
    session_start();
    if (isset($_SESSION['orders']) && count($_SESSION['orders']) > 0) {
        ?>
        <form action="../scripts/update_orders.php" method="POST">
            <ul>
                <?php
                foreach ($_SESSION['orders'] as $order) {
                    echo '<li>';
                    echo '<label>' . $order . '</label>';
                    echo '<select name="order_status[]">';
                    echo '<option value="feito">Feito</option>';
                    echo '<option value="pendente" selected>Pendente</option>';
                    echo '<option value="concluido">Concluído</option>';
                    echo '</select>';
                    echo '</li>';
                }
                ?>
            </ul>
            <input type="submit" value="Atualizar Pedidos">
        </form>
        <form action="../scripts/clear_orders.php" method="POST">
            <input type="submit" value="Limpar Pedidos">
        </form>
        <?php
        if (isset($_SESSION['order_update_message'])) {
            echo '<p>' . $_SESSION['order_update_message'] . '</p>';
            unset($_SESSION['order_update_message']);
        }
        if (isset($_SESSION['order_clear_message'])) {
            echo '<p>' . $_SESSION['order_clear_message'] . '</p>';
            unset($_SESSION['order_clear_message']);
        }
    } else {
        echo '<p>Nenhum pedido foi feito.</p>';
    }
    ?>
</main>
<?php include('../partials/footer.php'); ?>
