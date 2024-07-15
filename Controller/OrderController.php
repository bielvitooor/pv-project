<?php
require_once("../banco/Connection.php");
require_once("../dao/ProductDao.php");
require_once("../dao/OrderDao.php");
require_once("../dao/OrderItemDao.php");
require_once("../Model/Product.php");
require_once("../Model/Orders.php");
require_once("../Model/OrderItem.php");

use config\banco\Connection as Connection;

try {
    $conn = Connection::getConnection();
} catch (\PDOException $error) {
    die("Erro de conexão: " . $error->getMessage());
}

$productDao = new ProductDao($conn);
$orderDao = new OrderDao($conn);
$orderItemsDao = new OrderItemDao($conn);

function addOrder($orderItems, $payment_idpayment, $guest_idguest, $status_idstatus)
{
    global $conn, $orderDao, $orderItemsDao, $productDao;

    try {
        // Iniciar a transação
        $conn->beginTransaction();

        // Calcular o valor total
        $totalvalue = 0;
        foreach ($orderItems as $item) {
            $totalvalue += $item['quantity'] * $item['price'];
        }

        // Adicionar um novo pedido
        $order = new Orders($totalvalue, $payment_idpayment, $guest_idguest, $status_idstatus);
        $orderDao->addOrder($order);
        $orderId = $conn->lastInsertId();

        // Adicionar itens do pedido
        foreach ($orderItems as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            // Adicionar item ao pedido
            $orderItem = new OrderItem(null, $orderId, $productId, $quantity, $price);
            $orderItemsDao->addOrderItem($orderItem);

            // Atualizar quantidade no estoque
            $productDao->removeStock($productId, $quantity);
        }

        // Confirmar a transação
        $conn->commit();
    } catch (\Exception $e) {
        // Reverter a transação em caso de erro
        $conn->rollBack();
        die("Erro ao processar o pedido: " . $e->getMessage());
    }
}

// Exemplo de uso:
$orderItems = [
    ['product_id' => 1, 'quantity' => 2, 'price' => 10.00],
    ['product_id' => 2, 'quantity' => 1, 'price' => 20.00]
];
$payment_idpayment = 1;
$guest_idguest = 1;
$status_idstatus = 8;

addOrder($orderItems, $payment_idpayment, $guest_idguest, $status_idstatus);
//showAllOrders();
?>
