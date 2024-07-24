<?php
require_once("../dao/OrderItemDAO.php");
class OrderDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function createOrder($Order){
        $guestId = $Order->getGuestId();
        $paymentId = $Order->getPaymentId();
        $totalValue = $Order->getTotalValue();
        $statusId = $Order->getStatusId();
        $stmt = $this->conn->prepare("INSERT INTO orders (guest_idguest, payment_idpayment, totalvalue, status_idstatus) VALUES (:guest_idguest, :payment_idpayment, :totalvalue, :status_idstatus)");
        $stmt->bindParam(':guest_idguest', $guestId);
        $stmt->bindParam(':payment_idpayment', $paymentId);
        $stmt->bindParam(':totalvalue', $totalValue);
        $stmt->bindParam(':status_idstatus', $statusId);
        return $stmt->execute();
    }
    public function getAllOrders() {
        $stmt = $this->conn->prepare("
            SELECT 
                o.idorder AS order_id,
                gu.name AS guest_name,
                p.name_product,
                oi.quantity,
                p.price AS unit_price,
                (oi.quantity * p.price) AS total_product_price,
                pay.tipo AS payment_method,
                o.totalvalue,
                s.description AS status
            FROM orders o
            INNER JOIN order_items oi ON o.idorder = oi.order_id
            INNER JOIN product p ON oi.product_id = p.idproduct
            INNER JOIN guest gu ON o.guest_idguest = gu.idguest
            INNER JOIN payment pay ON o.payment_idpayment = pay.idpayment
            INNER JOIN status s ON o.status_idstatus = s.idstatus
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderStatus($orderId, $status) {
        $stmt = $this->conn->prepare("UPDATE orders SET status_idstatus = :status WHERE idorder = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $orderId);
        return $stmt->execute();
    }

    public function clearOrders() {
        $stmt = $this->conn->prepare("DELETE FROM orders");
        return $stmt->execute();
    }
}
?>
