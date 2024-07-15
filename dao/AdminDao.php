<?php

require_once("../banco/Connection.php");
use config\banco\Connection as Connection;

class AdminDao
{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function getAdminByLogin($login){
        $stmt = $this->conn->prepare("SELECT * FROM admin WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function authenticate($login, $password){
        $admin = $this->getAdminByLogin($login);
        if ($admin && $admin['password'] === $password) {
            return $admin;
        } else {
            return false;
        }
    }
}

// Exemplo de uso
try {
    $conn = Connection::getConnection();
    $adminDao = new AdminDao($conn);

    // Tentativa de autenticação
    $login = "admin";
    $password = "admin";

    $admin = $adminDao->authenticate($login, $password);

    if ($admin) {
        echo "Autenticação bem-sucedida. Bem-vindo, " . $admin['name'] . "!";
    } else {
        echo "Falha na autenticação. Verifique suas credenciais.";
    }
} catch (\PDOException $error) {
    die("Erro de conexão: " . $error->getMessage());
}

?>
