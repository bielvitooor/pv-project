<?php
session_start();

// Verificar se o usuário está logado e é um administrador
if (!isset($_SESSION['admin'])) {
    header("Location: ../views/login.php?error=2");
    exit();
}

require_once("../banco/Connection.php");
require_once("../dao/OrderDAO.php");
use config\banco\Connection as Connection;

try {
    $conn = Connection::getConnection();
    $orderDAO = new OrderDAO($conn);

    // Buscar todos os pedidos do banco de dados
    $orders = $orderDAO->getAllOrders();
} catch (\PDOException $error) {
    die("Erro ao buscar pedidos: " . $error->getMessage());
}
?>

<?php include('../partials/header.php'); ?>
<main>
    <h1>Pedidos</h1>
    <?php
    if (!empty($orders)) {
        ?>
        <form action="../scripts/update_orders.php" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>ID do Pedido</th>
                        <th>Cliente</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Preço Total do Produto</th>
                        <th>Método de Pagamento</th>
                        <th>Valor Total do Pedido</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($orders as $order) {
                        echo '<tr>';
                        echo '<td>' . $order['order_id'] . '</td>';
                        echo '<td>' . $order['guest_name'] . '</td>';
                        echo '<td>' . $order['product_name'] . '</td>';
                        echo '<td>' . $order['quantity'] . '</td>';
                        echo '<td>' . $order['unit_price'] . '</td>';
                        echo '<td>' . $order['total_product_price'] . '</td>';
                        echo '<td>' . $order['payment_method'] . '</td>';
                        echo '<td>' . $order['totalvalue'] . '</td>';
                        echo '<td>';
                        echo '<select name="order_status[' . $order['order_id'] . ']">';
                        echo '<option value="1"' . ($order['status'] == 'Pendente' ? ' selected' : '') . '>Pendente</option>';
                        echo '<option value="2"' . ($order['status'] == 'Feito' ? ' selected' : '') . '>Feito</option>';
                        echo '<option value="3"' . ($order['status'] == 'Concluído' ? ' selected' : '') . '>Concluído</option>';
                        echo '</select>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
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
