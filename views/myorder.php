<?php
session_start();
require_once('../banco/Connection.php');
require_once('../dao/OrderDao.php');
require_once('../dao/GuestDao.php');
require_once('../dao/OrderItemDao.php');
use config\banco\Connection as Connection;

try {
    // Assumindo que o CPF foi salvo na sessão após o login do usuário
    $conn = Connection::getConnection();
} catch (\PDOException $error) {
    die("Erro de conexão: " . $error->getMessage());
}
if(!isset($_SESSION['cpf'])){
    header('Location: login.php');
    exit();
}
$cpf=$_SESSION['cpf'];
$guestDao = new GuestDao($conn);
$orderDao = new OrderDao($conn);
$orders = $orderDao->getAllOrderByCpf($cpf);
$nome=$guestDao->getGuestByCpf($cpf);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos</title>
    <!-- Adicionar links de CSS como Bootstrap, se necessário -->
</head>
<body>
    <?php include('../partials/header.php'); ?>

    <main class="container mt-4">
        <h1 class="mb-4">Meus Pedidos</h1>
        <section class="orders row">
            <?php if (!empty($orders)): ?>
                <?php foreach($orders as $order): ?>
                <div class="order col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pedido #<?= htmlspecialchars($order['idorder'], ENT_QUOTES, 'UTF-8') ?></h5>
                            <p class="card-text"><strong>Status:</strong> <?= htmlspecialchars($order['statusorder'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><strong>Produtos:</strong> <?= htmlspecialchars($order['products'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><strong>Total:</strong> R$ <?= htmlspecialchars($order['total'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><strong>Pagamento:</strong> <?= htmlspecialchars($order['payment'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="card-text"><strong>Data:</strong><?=htmlspecialchars($order['dateorder'],ENT_QUOTES,'UTF-8') ?> <!-- Adicione aqui a data do pedido, se disponível --></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="alert alert-info">Nenhum pedido foi encontrado.</p>
            <?php endif; ?>
        </section>
    </main>

    <?php include('../partials/footer.php'); ?>
</body>
</html>
