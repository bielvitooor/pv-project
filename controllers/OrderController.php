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

//getallorders usin  


?>
