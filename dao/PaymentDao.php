<?php
Class PaymentDao{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getAllPayments(){
        $stmt = $this->conn->query("SELECT * FROM payment");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPaymentById($id){
        $stmt = $this->conn->prepare("SELECT * FROM payment WHERE idpayment = :idpayment");
        $stmt->bindParam(':idpayment', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function addPayment($payment){
        $type=$payment->getType();
    
        $stmt = $this->conn->prepare("INSERT INTO payment (tipo) VALUES (:tipo)");
        $stmt->bindParam(':tipo', $type);
        return $stmt->execute();
    }

    public function removePayment($idPayment){
        $stmt = $this->conn->prepare("DELETE FROM payment WHERE idpayment = :idpayment");
        $stmt->bindParam(':idpayment', $idPayment);
        return $stmt->execute();
    }
}
?>