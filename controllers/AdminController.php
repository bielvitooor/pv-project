<?php
require_once("../banco/Connection.php");
require_once("../dao/AdminDAO.php");
use config\banco\Connection as Connection;

session_start();

// Verificar se foram enviados dados do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = Connection::getConnection();
        $adminDAO = new AdminDAO($conn);

        $login = $_POST['login'];
        $password = $_POST['password'];

        $admin = $adminDAO->authenticate($login, $password);

        if ($admin) {
            // Autenticação bem-sucedida
            $_SESSION['admin'] = $admin; // Armazenar dados do administrador na sessão
            echo("deu certo"); // Redirecionar para página de dashboard
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
?>
