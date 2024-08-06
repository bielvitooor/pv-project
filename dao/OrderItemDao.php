<?php

require_once("../banco/Connection.php");
require_once("../dao/OrderDao.php");
require_once("../models/Orders.php");
require_once("../dao/productDao.php");
require_once("../models/Product.php");
use config\banco\Connection as Connection;

class OrderItemDao
{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getAllOrderItems(){
        $stmt = $this->conn->query("SELECT * FROM order_items");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOrderItemsByOrderId($orderId){
        $stmt = $this->conn->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addOrderItem($orderItem){
        $orderItemId=$orderItem->getOrderId();
        $productId=$orderItem->getProductId();
        $quantity=$orderItem->getQuantity();
        $price=$orderItem->getPrice();
    
        $stmt = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
        $stmt->bindParam(':order_id', $orderItemId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    public function removeOrderItem($idOrderItem){
        $stmt = $this->conn->prepare("DELETE FROM order_items WHERE idorder_items = :idorder_items");
        $stmt->bindParam(':idorder_items', $idOrderItem);
        return $stmt->execute();
    }
}

?>
