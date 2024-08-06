<?php
require_once ("../banco/Connection.php");
require_once ("../dao/AdminDao.php");
require_once ("../dao/ProductDao.php");
require_once ("../models/Product.php");
require_once("../dao/OrderDao.php");
use config\banco\Connection as Connection;

session_start();

// Verificar se foram enviados dados do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login']) && isset($_POST['password'])) {
        try {
            $conn = Connection::getConnection();
            $adminDAO = new AdminDAO($conn);

            $login = $_POST['login'];
            $password = $_POST['password'];

            $admin = $adminDAO->authenticate($login, $password);

            if ($admin) {
                // Autenticação bem-sucedida
                $_SESSION['admin'] = $admin; // Armazenar dados do administrador na sessão
                header("Location: ../views/painel.php"); // Redirecionar para página de dashboard
                exit();
            } else {
                // Autenticação falhou
                header("Location: ../views/login.php?error=1"); // Redirecionar com mensagem de erro
                exit();
            }
        } catch (\PDOException $error) {
            die("Erro de conexão: " . $error->getMessage());
        }
    }
}
// Função de logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../views/login.php");
    exit();
}
if(isset($_POST['update'])){
    try {
        $conn = Connection::getConnection();
        $productDao = new ProductDao($conn);
        foreach ($_POST['products'] as $idproduct => $product) {
            
            $productDao->updateProduct(new Product($idproduct, $product['name_product'], $product['price'], $product['quantity']));
        }
        header("Location: ../views/painel.php");
        exit();
    }
    catch (\PDOException $error) {
        die("Erro de conexão: " . $error->getMessage());
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order'])) {
    try {
        $conn = Connection::getConnection();
        $orderDao = new OrderDAO($conn);

        foreach ($_POST['order_status'] as $idorder => $status) {
            $orderDao->updateOrderStatus($idorder, $status);
        }

        $_SESSION['order_update_message'] = "Pedidos atualizados com sucesso.";
        header("Location: ../views/orders.php");
        exit();
    } catch (\PDOException $error) {
        die("Erro de conexão: " . $error->getMessage());
    }
} else {
    header("Location: ../views/painel.php");
    exit();
}
?>