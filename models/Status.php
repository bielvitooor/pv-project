<?php
class Status{
    private $idstatus;
    private $description;
    function __construct($idstatus, $description){
        $this->idstatus = $idstatus;
        $this->description = $description;

    }
    public function getIdstatus(){
        return $this->idstatus;
    }
    public function getDescription(){
        return $this->description;
    }

    
}   
?>