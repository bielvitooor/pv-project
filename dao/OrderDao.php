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

    public function addOrder($order) {
        $totalvalue = $order->getTotalValue();
        $payment_idpayment=$order->getPaymentIdPayment();
        $guest_idguest=$order->getGuestIdGuest();
        $status_idstatus=$order->getStatusIdStatus();

        $stmt = $this->conn->prepare("INSERT INTO orders (totalvalue, payment_idpayment, guest_idguest, status_idstatus) VALUES (:totalvalue, :payment_idpayment, :guest_idguest, :status_idstatus)");
        $stmt->bindParam(':totalvalue', $totalvalue);
        $stmt->bindParam(':payment_idpayment', $payment_idpayment);
        $stmt->bindParam(':guest_idguest', $guest_idguest);
        $stmt->bindParam(':status_idstatus', $status_idstatus);
        return $stmt->execute();
    }

    public function removeOrder($idorder){
        $stmt = $this->conn->prepare("DELETE FROM orders WHERE idorder = :idorder");
        $stmt->bindParam(':idorder', $idorder);
        return $stmt->execute();
    }

    public function getOrderWithItems($order_id)
    {
        $stmt = $this->conn->prepare("
            SELECT o.idorder, o.totalvalue, oi.quantity, p.name_product, p.price, (oi.quantity * oi.price) AS subtotal
            FROM orders o
            INNER JOIN order_items oi ON o.idorder = oi.order_id
            INNER JOIN product p ON oi.product_id = p.idproduct
            WHERE o.idorder = :order_id
        ");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
