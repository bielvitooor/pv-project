<?php
class OrderItem
{
    private $idorder_items;
    private $order_id;
    private $product_id;
    private $quantity;
    private $price;

    public function __construct($idorder_items, $order_id, $product_id, $quantity, $price){
        $this->idorder_items = $idorder_items;
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    // Métodos getter e setter
    public function getIdOrderItems(){
        return $this->idorder_items;
    }

    public function setIdOrderItems($idorder_items){
        $this->idorder_items = $idorder_items;
    }

    public function getOrderId(){
        return $this->order_id;
    }

    public function setOrderId($order_id){
        $this->order_id = $order_id;
    }

    public function getProductId(){
        return $this->product_id;
    }

    public function setProductId($product_id){
        $this->product_id = $product_id;
    }

    public function getQuantity(){
        return $this->quantity;
    }

    public function setQuantity($quantity){
        $this->quantity = $quantity;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setPrice($price){
        $this->price = $price;
    }
}
?>
