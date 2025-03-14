<?php

class OrderItem extends Model
{
    protected static $tableName = 'order_items';
    protected static $keyColumn = 'order_item_id';
    protected $order_id;
    protected $product_id;
    protected $quantity;

    public function __set($name, $value)
    {
        $name = 'set' . ucfirst($name);
        if (method_exists($this, $name)) {
            return $this->$name($value);
        }
    }

public function __get($name)
    {
        $name = 'get' . ucfirst($name);
        if (method_exists($this, $name)) {
            return $this->$name();
        }
    }

    public function setOrder_id($value)
    {
        $this->order_id = $value;
    }

    public function getOrder_id()
    {
        return $this->order_id;
    }

    public function setProduct_id($value)
    {
        $this->product_id = $value;
    }

    public function getProduct_id()
    {
        return $this->product_id;
    }

    public function setQuantity($value)
    {
        $this->quantity = $value;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
