<?php
class Order
{
    private $idorder;
    private $status_order;
    private $totalvalue;
    private $payment_idpayment;
    private $guest_idguest;

    public function __construct($status_order, $totalvalue, $payment_idpayment, $guest_idguest)
    {
        $this->status_order = $status_order;
        $this->totalvalue = $totalvalue;
        $this->payment_idpayment = $payment_idpayment;
        $this->guest_idguest = $guest_idguest;
    }

    public function getIdOrder()
    {
        return $this->idorder;
    }

    public function getStatusOrder()
    {
        return $this->status_order;
    }

    public function getTotalValue()
    {
        return $this->totalvalue;
    }

    public function getPaymentIdPayment()
    {
        return $this->payment_idpayment;
    }

    public function getGuestIdGuest()
    {
        return $this->guest_idguest;
    }

    public function setIdOrder($idorder)
    {
        $this->idorder = $idorder;
    }

    public function setStatusOrder($status_order)
    {
        $this->status_order = $status_order;
    }

    public function setTotalValue($totalvalue)
    {
        $this->totalvalue = $totalvalue;
    }

    public function setPaymentIdPayment($payment_idpayment)
    {
        $this->payment_idpayment = $payment_idpayment;
    }

    public function setGuestIdGuest($guest_idguest)
    {
        $this->guest_idguest = $guest_idguest;
    }
}
?>
