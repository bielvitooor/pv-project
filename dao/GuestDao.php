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
}

// Exemplo de uso
try {
    $conn = Connection::getConnection();
    $guestDao = new GuestDao($conn);

    // Exemplo de obtenção de todos os convidados
    $guests = $guestDao->getAllGuests();
    foreach ($guests as $guest) {
        echo "ID: " . $guest['idguest'] . ", Nome: " . $guest['name'] . ", CPF: " . $guest['cpf'] . "<br>";
    }
} catch (\PDOException $error) {
    die("Erro de conexão: " . $error->getMessage());
}

?>
