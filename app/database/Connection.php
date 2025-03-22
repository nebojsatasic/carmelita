<?php

/**
 * Database connection class - singleton pattern
 */
class Connection
{
    /**
     * @var PDO $db
     */
    private static $db;

    /**
     * Connection constructor
     */
    private function __construct()
    {
    }

    /**
     * Connecting to database
     *
     * @return PDO $db
     */
    public  static function connect()
    {
        if (!self::$db) {
            self::$db = new PDO(
                Config::get('db/db_type') . ':host=' . Config::get('db/host') . ';dbname=' . Config::get('db/db_name'),
                Config::get('db/user'),
                Config::get('db/password')
            );
        }

        return self::$db;
    }
}
