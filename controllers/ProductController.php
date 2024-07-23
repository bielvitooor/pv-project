<?php
require_once("../banco/Connection.php");
require_once("../dao/ProductDao.php");
require_once("../model/Product.php");

use config\banco\Connection as Connection;

try {
    $conn = Connection::getConnection();
} catch (\PDOException $error) {
    die("Erro de conexão: " . $error->getMessage());
}

$productDao = new ProductDao($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_product = $_POST['name_product'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $product = new Product(null, $name_product, $price, $quantity);
    $result = $productDao->addProduct($product);
    if($result){
        echo "Produto cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar produto!";
    
    }

    header("Location: ../views/product.php");
    exit();
}
else{
    $products = $productDao->showAllProducts();
    include "../views/product.php";

}

?>
