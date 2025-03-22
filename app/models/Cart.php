<?php

class Cart extends Model
{
    protected static $tableName = 'cart';
    protected static $keyColumn = 'item_id';
    protected $user_id;
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

    public function setUser_id($value)
    {
        $this->user_id = $value;
    }

    public function getUser_id()
    {
        return $this->user_id;
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
