<?php
require_once('../banco/Connection.php');
require_once('../dao/OrderDao.php');
require_once('../Controller/GuestController.php');
require_once('../dao/OrderItemDao.php');
use config\banco\Connection as Connection;
try {
    $conn = Connection::getConnection();
    $orderDao = new OrderDao($conn);
    $orders = $orderDao->getOrdersByCpf($guest->getId());
} catch (\PDOException $error) {
    die("Erro de conexão: " . $error->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main>
        <h1>MEUS PEDIDOS</h1>
        <section class="orders row">
            <php foreach($orders as $order): ?>
        </section>

    </main>
</body>
</html>
