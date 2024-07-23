<?php
require_once("../banco/Connection.php");
use config\banco\Connection as Connection;
require_once("../models/Status.php");

try {
    $conn = Connection::getConnection();
} catch (\PDOException $error) {
    die("Erro de conexão: " . $error->getMessage());
}

class StatusDao
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllStatuses()
    {
        $stmt = $this->conn->query("SELECT * FROM status");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getStatusById($idstatus)
    {
        $stmt = $this->conn->prepare("SELECT * FROM status WHERE idstatus = :idstatus");
        $stmt->bindParam(':idstatus', $idstatus);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
$teste = new StatusDao($conn);
$status = $teste->getAllStatuses();
foreach ($status as $stat) {
    echo "ID: " . $stat['idstatus'] . ", Status: " . $stat['description'] . "<br>";
};


?>