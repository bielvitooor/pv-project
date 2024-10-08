<?php

require_once("../banco/Connection.php");
use config\banco\Connection as Connection;

class GuestDao
{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getAllGuests(){
        $stmt = $this->conn->query("SELECT * FROM guest");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getGuestById($idGuest){
        $stmt = $this->conn->prepare("SELECT * FROM guest WHERE idguest = :idguest");
        $stmt->bindParam(':idguest', $idGuest);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getIdGuest(){
        $stmt = $this->conn->query("SELECT idguest FROM guest ORDER BY idguest DESC LIMIT 1");
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function addGuest($guest){
        $stmt = $this->conn->prepare("INSERT INTO guest (name, cpf) VALUES (:name, :cpf)");
        $stmt->bindParam(':name', $guest->getName());
        $stmt->bindParam(':cpf', $guest->getCpf());
        return $stmt->execute();
    }

    public function removeGuest($idGuest){
        $stmt = $this->conn->prepare("DELETE FROM guest WHERE idguest = :idguest");
        $stmt->bindParam(':idguest', $idGuest);
        return $stmt->execute();
    }
    public function getGuestByCpf($cpf){
        $stmt = $this->conn->prepare("SELECT * FROM guest WHERE cpf = :cpf");
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

// Exemplo de uso

?>
