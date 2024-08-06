<?php
require_once("../banco/Connection.php");
require_once("../dao/OrderDao.php");
session_start();
use config\banco\Connection as Connection;

// Verificar se o usuário está logado e é um administrador
if (!isset($_SESSION['admin'])) {
    header("Location: ../views/login.php?error=2");
    exit();
}

try {
    $conn = Connection::getConnection();
    $orderDAO = new OrderDAO($conn);

    // Buscar todos os pedidos do banco de dados
    $orders = $orderDAO->getAllOrders();
} catch (\PDOException $error) {
    die("Erro ao buscar pedidos: " . $error->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
</head>
<body>
    <?php include('../partials/header.php'); ?>

    <main class="container mt-4">
        <h1 class="mb-4">Pedidos</h1>
        
        <?php if (!empty($orders)): ?>
            <form action="../controllers/AdminController.php" method="POST">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID do Pedido</th>
                            <th>Cliente</th>
                            <th>CPF</th>
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
                        <?php foreach ($orders as $order): 
                            $products = explode(',', $order['products']);
                            $quantities = explode(',', $order['quantities']);
                            $unitPrices = explode(',', $order['uniprice']);
                            $subtotals = explode(',', $order['subtotal']);
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($order['idorder'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($order['nameguest'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($order['cpf'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php foreach ($products as $product): ?>
                                        <?= htmlspecialchars($product, ENT_QUOTES, 'UTF-8') ?><br>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?php foreach ($quantities as $quantity): ?>
                                        <?= htmlspecialchars($quantity, ENT_QUOTES, 'UTF-8') ?><br>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?php foreach ($unitPrices as $price): ?>
                                        R$ <?= htmlspecialchars($price, ENT_QUOTES, 'UTF-8') ?><br>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?php foreach ($subtotals as $subtotal): ?>
                                        R$ <?= htmlspecialchars($subtotal, ENT_QUOTES, 'UTF-8') ?><br>
                                    <?php endforeach; ?>
                                </td>
                                <td><?= htmlspecialchars($order['payment'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td>R$ <?= htmlspecialchars($order['total'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php
                                    $orderDAO
                                    ?>
                                    <select name="order_status[<?= htmlspecialchars($order['idorder'], ENT_QUOTES, 'UTF-8') ?>]" class="form-control">
                                        <option value="1" <?= $order['status_idstatus'] == 1 ? 'selected' : '' ?>>Em Espera</option>
                                        <option value="2" <?= $order['status_idstatus'] == 2 ? 'selected' : '' ?>>Em separação</option>
                                        <option value="3" <?= $order['status_idstatus'] == 3 ? 'selected' : '' ?>>Pronto</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary" name="update_order">Atualizar Pedidos</button>
            </form>
            
            <form action="../scripts/clear_orders.php" method="POST" class="mt-2">
                <button type="submit" class="btn btn-danger">Limpar Pedidos</button>
            </form>

            <?php
            if (isset($_SESSION['order_update_message'])) {
                echo '<div class="alert alert-success mt-3">' . htmlspecialchars($_SESSION['order_update_message'], ENT_QUOTES, 'UTF-8') . '</div>';
                unset($_SESSION['order_update_message']);
            }
            if (isset($_SESSION['order_clear_message'])) {
                echo '<div class="alert alert-warning mt-3">' . htmlspecialchars($_SESSION['order_clear_message'], ENT_QUOTES, 'UTF-8') . '</div>';
                unset($_SESSION['order_clear_message']);
            }
            ?>
        <?php else: ?>
            <p class="alert alert-info">Nenhum pedido foi feito.</p>
        <?php endif; ?>
    </main>

    <?php include('../partials/footer.php'); ?>

</body>
</html>
