<?php
require_once "../banco/Connection.php";
require_once "../dao/GuestDao.php";
require_once "../dao/OrderDao.php";
require_once "../dao/OrderItemDao.php";
require_once "../dao/ProductDao.php";
require_once "../models/Guest.php";
require_once "../models/Orders.php";
require_once "../models/OrderItem.php";

use config\banco\Connection as Connection;

try {
    $conn = Connection::getConnection();
} catch (\PDOException $error) {
    die("Erro de conexão: " . $error->getMessage());
}

$guestDao = new GuestDao($conn);
$orderDao = new OrderDao($conn);
$orderItemDao = new OrderItemDao($conn);
$productDao = new ProductDao($conn);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $cpf = $_POST['cpf'];
    $paymentId = $_POST['payment']; 
    $quantities = $_POST['quantities'];

    // Verifica se o hóspede já existe
    $guest = $guestDao->getGuestByCpf($cpf);

    if (!$guest) {
        // Se não existe, cria um novo hóspede
        $guest = new Guest(null, $name, $cpf);
        $guestDao->addGuest($guest);
        $guest = $guestDao->getGuestByCpf($cpf); // Recupera o hóspede com o ID gerado
    }

    $total = 0.0;

    // Calcula o total do pedido
    foreach($quantities as $id => $quantity){
        if($quantity > 0){
            $product = $productDao->getProductById($id);
            $total += $product['price'] * $quantity;
        }
    }

    // Cria o pedido
    $order = new Orders(null, $total, $paymentId, $guest['idguest'], 1);
    $orderDao->createOrder($order);

    // Adiciona os itens ao pedido
    foreach($quantities as $productId => $quantity){
        if($quantity > 0){
            $product = $productDao->getProductById($productId);
            $totalValueByProduct = $product['price'] * $quantity;
            $orderItem = new OrderItem(null, $order->getIdOrder(), $productId, $quantity, $totalValueByProduct);
            $orderItemDao->addOrderItem($orderItem);
        }
    }

    header("Location: ../index.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>
