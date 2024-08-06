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
    header('Content-Type: application/json');
    echo json_encode(["error" => "Erro de conexão: " . $error->getMessage()]);
    exit();
}

$guestDao = new GuestDao($conn);
$orderDao = new OrderDao($conn);
$orderItemDao = new OrderItemDao($conn);
$productDao = new ProductDao($conn);
//listar os pedidos via cpf

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Verifica se é uma requisição para verificação de CPF
    if(isset($_SERVER['HTTP_CONTENT_TYPE']) && $_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
        $data = json_decode(file_get_contents('php://input'), true);
        $cpf = $data['cpf'];

        $guest = $guestDao->getGuestByCpf($cpf);
        
        header('Content-Type: application/json');
        if ($guest) {
            echo json_encode(["exists" => true]);
        } else {
            echo json_encode(["exists" => false]);
        }
        exit();
    }

    $name = $_POST['name'] ?? null;
    $cpf = $_POST['cpf'];
    $paymentId = $_POST['payment'];
    $quantities = $_POST['quantities'];

    // Verifica se o hóspede já existe
    $guest = $guestDao->getGuestByCpf($cpf);
    
    if (!$guest) {
        if (empty($name)){
            echo "Nome é obrigatório";
            exit();
        } else {
            // Se não existe, cria um novo hóspede
            $guest = new Guest(null, $name, $cpf);
            $guestDao->addGuest($guest);
            $guest = $guestDao->getGuestByCpf($cpf); // Recupera o hóspede com o ID gerado
        }
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
    $order = new Orders($total, $paymentId, $guest['idguest'], 1);
    $orderDao->createOrder($order);

    // Adiciona os itens ao pedido
    $lastOrderId = $conn->lastInsertId();

    foreach($quantities as $productId => $quantity){
        if($quantity > 0){
            $product = $productDao->getProductById($productId);
            $totalValueByProduct = $product['price'] * $quantity;
            $orderItem = new OrderItem(0, $lastOrderId, $productId, $quantity, $totalValueByProduct);
            $orderItemDao->addOrderItem($orderItem);
        }
    }
    //atualizar o estoque automaticamente
    foreach($quantities as $productId => $quantity){
        if($quantity > 0){
            $product = $productDao->getProductById($productId);
            $productDao->removeStock($productId, $quantity);
        }
    }
    header("Location: ../index.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>
