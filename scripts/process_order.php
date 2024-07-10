<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    if (!isset($_SESSION['orders'])) {
        $_SESSION['orders'] = [];
    }
    
    if (isset($_POST['products'])) {
        foreach ($_POST['products'] as $product) {
            $_SESSION['orders'][] = $product;
        }
    }
    
    header('Location: ../views/orders.php');
    exit();
}
?>
