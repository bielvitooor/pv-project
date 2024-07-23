<?php
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
//New AdminDao(Connection::getConnection());


?>
