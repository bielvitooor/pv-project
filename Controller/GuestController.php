<?php
require_once "../banco/Connection.php";
require_once "../dao/GuestDao.php";
require_once "../model/Guest.php";

use config\banco\Connection as Connection;

try {
    $conn = Connection::getConnection();
} catch (\PDOException $error) {
    die("Erro de conexão: " . $error->getMessage());
}

$guestDao = new GuestDao($conn);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $cpf = $_POST['cpf'];
    if($name == "" || $cpf == ""){
        echo "Preencha todos os campos!";
    } else {
        $guest = new Guest(null, $name, $cpf);
        if($ifGuestExists = $guestDao->getGuestByCpf($cpf)){
            echo "CPF já cadastrado!";
        } else {
            $guestDao->addGuest($guest);
            echo "Hóspede cadastrado com sucesso!";
        }
        echo "Guest ID: " . $guest->getIdguest() . ", Name: " . $guest->getName() . ", CPF: " . $guest->getCpf();
    }
   
} 
?>


