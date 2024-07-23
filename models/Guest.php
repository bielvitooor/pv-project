<?php
class Guest
{
    private $idguest;
    private $name;
    private $cpf;

    public function __construct($idguest, $name, $cpf){
        $this->idguest = $idguest;
        $this->name = $name;
        $this->cpf = $cpf;
    }

    // Métodos getter e setter
    public function getIdGuest(){
        return $this->idguest;
    }


    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getCpf(){
        return $this->cpf;
    }

    public function setCpf($cpf){
        $this->cpf = $cpf;
    }
}
?>
