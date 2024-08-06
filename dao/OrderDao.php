<?php
require_once("../dao/OrderItemDAO.php");
class OrderDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function createOrder($Order){
        $guestId = $Order->getGuestIdGuest();
        $paymentId = $Order->getPaymentIdPayment();
        $totalValue = $Order->getTotalValue();
        $statusId = $Order->getStatusOrder();
        $stmt = $this->conn->prepare("INSERT INTO orders (guest_idguest, payment_idpayment, totalvalue, status_idstatus) VALUES (:guest_idguest, :payment_idpayment, :totalvalue, :status_idstatus)");
        $stmt->bindParam(':guest_idguest', $guestId);
        $stmt->bindParam(':payment_idpayment', $paymentId);
        $stmt->bindParam(':totalvalue', $totalValue);
        $stmt->bindParam(':status_idstatus', $statusId);
        return $stmt->execute();
    }
    public function getAllOrders(){
        $stmt = $this->conn->query("SELECT 
                        o.idorder,
                        g.name AS nameguest,
                        g.cpf,
                        GROUP_CONCAT(p.name_product SEPARATOR ', ') AS products,
                        GROUP_CONCAT(oi.quantity SEPARATOR ', ') AS quantities,
                        GROUP_CONCAT(p.price SEPARATOR ', ') AS uniprice,
                        GROUP_CONCAT(oi.quantity * p.price SEPARATOR ', ') AS subtotal,
                        o.totalvalue AS total,
                        s.description AS statusoder,
                        o.status_idstatus, -- Adicionando status_idstatus
                        m.tipo as payment
                      FROM 
                        pv.orders o
                        INNER JOIN pv.guest g ON o.guest_idguest = g.idguest
                        INNER JOIN pv.order_items oi ON o.idorder = oi.order_id
                        INNER JOIN pv.product p ON oi.product_id = p.idproduct
                        INNER JOIN pv.status s ON o.status_idstatus = s.idstatus
                        INNER JOIN pv.payment m ON o.payment_idpayment = m.idpayment
                      GROUP BY 
                        o.idorder, g.name, g.cpf, o.totalvalue, o.status_idstatus, s.description, m.tipo");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllOrderByCpf($cpf) {
        $stmt = $this->conn->query("
           SELECT * FROM myorder WHERE cpf = $cpf;
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
