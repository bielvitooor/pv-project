<?php

class OrderItemDao
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addOrderItem($orderItem)
    {
        $stmt = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
        $stmt->bindParam(':order_id', $orderItem->getOrderId());
        $stmt->bindParam(':product_id', $orderItem->getProductId());
        $stmt->bindParam(':quantity', $orderItem->getQuantity());
        $stmt->bindParam(':price', $orderItem->getPrice());
        return $stmt->execute();
    }

    public function getOrderItemsByOrderId($order_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

?>
