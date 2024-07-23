<?php 
Class Payment {
    private $idpayment;
    private $tipo;

    // Construtor
    public function __construct($tipo) {
        $this->tipo = $tipo;
    }

    // Getters e Setters
    public function getIdPayment() {
        return $this->idpayment;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
}

?>