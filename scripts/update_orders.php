<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Processar os dados do formulário
    if (isset($_POST['order_status'])) {
        $orderStatuses = $_POST['order_status'];
        // Aqui você processa e atualiza os status dos pedidos no banco de dados ou na sessão, conforme necessário
        
        // Definir mensagem de sucesso
        $_SESSION['order_update_message'] = 'Pedidos atualizados com sucesso!';
    } else {
        $_SESSION['order_update_message'] = 'Nenhum pedido foi atualizado.';
    }
}

// Redirecionar de volta para a página de pedidos
header('Location: ../views/orders.php');
exit();
?>
