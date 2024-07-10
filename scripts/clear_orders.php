<?php
session_start();

// Limpa os pedidos da sessão
if (isset($_SESSION['orders'])) {
    unset($_SESSION['orders']);
}

// Define uma mensagem de sucesso
$_SESSION['order_clear_message'] = "Todos os pedidos foram limpos.";

// Redireciona de volta para a página de pedidos
header("Location: ../views/orders.php");
exit();
