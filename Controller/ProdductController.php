<?php

require_once("../dao/ProductDao.php");
require_once("../banco/Connection.php");
require_once("../model/Product.php");

use config\banco\Connection as Connection;

class ProductController
{
    private $productDao;

    public function __construct()
    {
        try {
            $conn = Connection::getConnection();
            $this->productDao = new ProductDao($conn);
        } catch (\PDOException $error) {
            die("Erro de conexão: " . $error->getMessage());
        }
    }

    public function showAllProducts()
    {
        $products = $this->productDao->showAllProducts();
        foreach ($products as $product) {
            echo "ID: " . $product['idproduct'] . ", Nome: " . $product['name_product'] . ", Preço: " . $product['price'] . ", Quantidade: " . $product['quantity'] . "<br>";
        }
    }

    public function addProduct($idproduct, $name_product, $price, $quantity)
    {
        $product = new Product($idproduct, $name_product, $price, $quantity);
        if ($this->productDao->addProduct($product)) {
            echo "Produto adicionado com sucesso!<br>";
        } else {
            echo "Erro ao adicionar produto.<br>";
        }
    }

    public function updateProduct($idproduct, $name_product, $price, $quantity)
    {
        $product = new Product($idproduct, $name_product, $price, $quantity);
        if ($this->productDao->updateProduct($product)) {
            echo "Produto atualizado com sucesso!<br>";
        } else {
            echo "Erro ao atualizar produto.<br>";
        }
    }

    public function removeProduct($idproduct)
    {
        if ($this->productDao->removeProduct($idproduct)) {
            echo "Produto removido com sucesso!<br>";
        } else {
            echo "Erro ao remover produto.<br>";
        }
    }

    public function addStock($idproduct, $quantity)
    {
        if ($this->productDao->addStock($idproduct, $quantity)) {
            echo "Estoque adicionado com sucesso!<br>";
        } else {
            echo "Erro ao adicionar estoque.<br>";
        }
    }

    public function removeStock($idproduct, $quantity)
    {
        if ($this->productDao->removeStock($idproduct, $quantity)) {
            echo "Estoque removido com sucesso!<br>";
        } else {
            echo "Erro ao remover estoque.<br>";
        }
    }
}

// Exemplo de uso
$controller = new ProductController();

// Mostrar todos os produtos
$controller->showAllProducts();

// Adicionar um produto
 $controller->addProduct(null, "Novob Produto", 50.00, 100);

// Atualizar um produto
// $controller->updateProduct(1, "Produto Atualizado", 60.00, 150);

// Remover um produto
// $controller->removeProduct(1);

// Adicionar estoque
 $controller->addStock(1, 50);

// Remover estoque
// $controller->removeStock(1, 10);
$controller->showAllProducts();

?>
