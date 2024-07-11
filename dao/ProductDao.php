<?php
require_once("../banco/Connection.php");
use config\banco\Connection as Connection;

try {
    $conn = Connection::getConnection();
    /*  if ($conn instanceof \PDO) {
        echo "Conexão PDO estabelecida com sucesso!<br>";

        // Exemplo de execução de query
        $stmt = $conn->query("SELECT * FROM guest");
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Exibe os resultados
        foreach ($resultados as $resultado) {
            echo "ID: " . $resultado['idguest'] . ", Nome: " . $resultado['name'] . "<br>";
        }
    } else {
        echo "Erro ao estabelecer conexão PDO.";
    }*/
} catch (\PDOException $error) {
    die("Erro de conexão: " . $error->getMessage());
}

class ProductDao
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function showProductall()
    {
        $stmt = $this->conn->query("SELECT * FROM product");
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function addStock($idproduct, $quantity)
    {
        $stmt = $this->conn->prepare("UPDATE product SET quantity = quantity + :quantity WHERE idproduct = :idproduct");
        $stmt->bindParam(':idproduct', $idproduct);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }
    public function removeStock($idproduct, $quantity)
    {
        $stmt = $this->conn->prepare("UPDATE product SET quantity = quantity - :quantity WHERE idproduct = :idproduct AND quantity >= :quantity");
        $stmt->bindParam(':idproduct', $idproduct);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }

}

/* Exemplo de uso:
$productDao = new ProductDao($conn);
$products = $productDao->showProductall();
foreach ($products as $product) {
    echo "ID: " . $product['idproduct'] . ", Nome: " . $product['name_product'] . ", Preço: " . $product['price'] . ", Quantidade: " . $product['quantity'] . "<br>";
}
$products=$productDao->removeStock(1,10);
$products = $productDao->showProductall();
foreach ($products as $product) {
    echo "ID: " . $product['idproduct'] . ", Nome: " . $product['name_product'] . ", Preço: " . $product['price'] . ", Quantidade: " . $product['quantity'] . "<br>";
}*/

?>
