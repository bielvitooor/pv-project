<?php
class Admin {
    private $idadmin;
    private $login;
    private $password;
    private $name;

    public function __construct($idadmin, $login, $password, $name) {
        $this->idadmin = $idadmin;
        $this->login = $login;
        $this->password = $password;
        $this->name = $name;
    }

    // Métodos getter e setter
    public function getIdAdmin() {
        return $this->idadmin;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
}
?>
