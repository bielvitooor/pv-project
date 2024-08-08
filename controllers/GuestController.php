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

if($_SERVER['REQUEST_METHOD'] === 'POST'){

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

    $guest = $guestDao->getGuestByCpf($cpf);
    
    if (!$guest) {
        if (empty($name)){
            echo "Nome é obrigatório";
            exit();
        } else {
            $guest = new Guest(null, $name, $cpf);
            $guestDao->addGuest($guest);
            $guest = $guestDao->getGuestByCpf($cpf);
        }
    }

    $total = 0.0;

    foreach($quantities as $id => $quantity){
        if($quantity > 0){
            $product = $productDao->getProductById($id);
            $total += $product['price'] * $quantity;
        }
    }

    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i:s', time());
    $order = new Orders($total, $paymentId, $guest['idguest'], 1, $date);
    $orderDao->createOrder($order);

    $lastOrderId = $conn->lastInsertId();

    foreach($quantities as $productId => $quantity){
        if($quantity > 0){
            $product = $productDao->getProductById($productId);
            $totalValueByProduct = $product['price'] * $quantity;
            $orderItem = new OrderItem(0, $lastOrderId, $productId, $quantity, $totalValueByProduct);
            $orderItemDao->addOrderItem($orderItem);
        }
    }

    foreach($quantities as $productId => $quantity){
        if($quantity > 0){
            $product = $productDao->getProductById($productId);
            $productDao->removeStock($productId, $quantity);
        }
    }


    function sendPostRequest($url, $data) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }


    $url = '../views/myorder.php';
    $data = ['cpf' => $cpf];

    // Envia os dados via POST
    sendPostRequest($url, $data);

    exit();
} else {
    echo "Método não permitido";
    exit();
}
?>