<?php

class OrderDao
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function showAllOrders()
    {
        $stmt = $this->conn->query("SELECT * FROM orders");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addOrder($order)
    {
        $stmt = $this->conn->prepare("INSERT INTO orders (status_order, totalvalue, payment_idpayment, guest_idguest) VALUES (:status_order, :totalvalue, :payment_idpayment, :guest_idguest)");
        $stmt->bindParam(':status_order', $order->getStatusOrder());
        $stmt->bindParam(':totalvalue', $order->getTotalValue());
        $stmt->bindParam(':payment_idpayment', $order->getPaymentIdPayment());
        $stmt->bindParam(':guest_idguest', $order->getGuestIdGuest());
        return $stmt->execute();
    }

    public function removeOrder($idorder)
    {
        $stmt = $this->conn->prepare("DELETE FROM orders WHERE idorder = :idorder");
        $stmt->bindParam(':idorder', $idorder);
        return $stmt->execute();
    }
}

// Exemplo de uso

