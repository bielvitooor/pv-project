<?php
class Product
{
    private $idproduct;
    private $name_product;
    private $price;
    private $quantity;

    public function __construct($idproduct, $name_product, $price, $quantity)
    {
        $this->idproduct = $idproduct;
        $this->name_product = $name_product;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    // Métodos getter e setter
    public function getIdProduct()
    {
        return $this->idproduct;
    }

    public function setIdProduct($idproduct)
    {
        $this->idproduct = $idproduct;
    }

    public function getNameProduct()
    {
        return $this->name_product;
    }

    public function setNameProduct($name_product)
    {
        $this->name_product = $name_product;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
}
?>
