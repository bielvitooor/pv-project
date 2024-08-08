<?php
class Orders
{
    private $idorder;
    private $totalvalue;
    private $payment_idpayment;
    private $guest_idguest;
    private $status_idstatus;
    
    private $dateorder;

    public function __construct($totalvalue, $payment_idpayment, $guest_idguest,$status_idstatus,$dateorder){
        $this->status_idstatus = $status_idstatus;
        $this->totalvalue = $totalvalue;
        $this->payment_idpayment = $payment_idpayment;
        $this->guest_idguest = $guest_idguest;
        $this->dateorder = $dateorder;
    }

    public function getIdOrder(){
        return $this->idorder;
    }

    public function getStatusOrder(){
        return $this->status_idstatus;
    }

    public function getTotalValue(){
        return $this->totalvalue;
    }

    public function getPaymentIdPayment(){
        return $this->payment_idpayment;
    }

    public function getGuestIdGuest(){
        return $this->guest_idguest;
    }

    public function setIdOrder($idorder){
        $this->idorder = $idorder;
    }

    public function setStatusOrder($status_idstatus){
        $this->status_idstatus = $status_idstatus;
    }

    public function setTotalValue($totalvalue){
        $this->totalvalue = $totalvalue;
    }

    public function setPaymentIdPayment($payment_idpayment){
        $this->payment_idpayment = $payment_idpayment;
    }

    public function setGuestIdGuest($guest_idguest){
        $this->guest_idguest = $guest_idguest;
    }
    public function getStatusIdStatus(){
        return $this->status_idstatus;
    }
    public function setStatusIdStatus($status_idstatus){
        $this->status_idstatus = $status_idstatus;
    }
    public function getDateOrder(){
        return $this->dateorder;
    }
    public function setDateOrder($dateorder){
        $this->dateorder = $dateorder;
    }
}
?>
