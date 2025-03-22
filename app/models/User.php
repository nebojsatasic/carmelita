<?php

class User extends Model
{
    public static $tableName = 'users';
    public static $keyColumn = 'user_id';
    public $name;
    public $username;
    public $email;
    public $password;
    public $created_at;
}
