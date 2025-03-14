<?php

class Product extends Model
{
    public static $tableName = 'products';
    public static $keyColumn = 'product_id';
    public $name;
    public $price;
    public $size;
    public $image;
    public $created_at;
}
