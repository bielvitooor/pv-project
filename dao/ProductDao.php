<?php
class ProductDao
{
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }
    function getProductById($idproduct){
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE idproduct = :idproduct");
        $stmt->bindParam(':idproduct', $idproduct);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function showAllProducts(){
        $stmt = $this->conn->query("SELECT * FROM product");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addProduct($product){
        $name_product = $product->getNameProduct();
        $price = $product->getPrice();
        $quantity = $product->getQuantity();

        $stmt = $this->conn->prepare("INSERT INTO product (name_product, price, quantity) VALUES (:name_product, :price, :quantity)");
        $stmt->bindParam(':name_product', $name_product);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }

    public function updateProduct($product){
        $stmt = $this->conn->prepare("UPDATE product SET  price = :price, quantity = :quantity WHERE idproduct = :idproduct");
        //$stmt->bindParam(':name_product', $product->getNameProduct());
        $stmt->bindParam(':price', $product->getPrice());
        $stmt->bindParam(':quantity', $product->getQuantity());
        $stmt->bindParam(':idproduct', $product->getIdProduct());
        return $stmt->execute();
    }

    public function removeProduct($idproduct){
        $stmt = $this->conn->prepare("DELETE FROM product WHERE idproduct = :idproduct");
        $stmt->bindParam(':idproduct', $idproduct);
        return $stmt->execute();
    }

    public function addStock($idproduct, $quantity){
        $stmt = $this->conn->prepare("UPDATE product SET quantity = quantity + :quantity WHERE idproduct = :idproduct");
        $stmt->bindParam(':idproduct', $idproduct);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }

    public function removeStock($idproduct, $quantity){
        $stmt = $this->conn->prepare("UPDATE product SET quantity = quantity - :quantity WHERE idproduct = :idproduct AND quantity >= :quantity");
        $stmt->bindParam(':idproduct', $idproduct);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }
}

// Exemplo de uso
// try {
//     $conn = Connection::getConnection();
//     $productDao = new ProductDao($conn);
//     $products = $productDao->showAllProducts();
//     foreach ($products as $product) {
//         echo "ID: " . $product['idproduct'] . ", Nome: " . $product['name_product'] . ", Preço: " . $product['price'] . ", Quantidade: " . $product['quantity'] . "<br>";
//     }
// } catch (\PDOException $error) {
//     die("Erro de conexão: " . $error->getMessage());
// }

?>
