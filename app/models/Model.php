<?php

class Model
{
    /**
     * @var PDO $db
     */
    private static $db;

    /**
     * @var string $query
     */
    public static $query;

    /**
     * Connect to the database
     */
    public static function init()
    {
        self::$db = Connection::connect();
    }

    /**
     * Get a single record from the table
     *
     * @param int $id
     * @return object|array|bool
     */
    public  static function get(int $id = null): object | array | bool
    {
        $tableName = static::$tableName;
        $keyColumn = static::$keyColumn;
        $className = get_called_class();

        if ($id) {
            $query = "SELECT * FROM $tableName WHERE $keyColumn = :id";
            $statement = self::$db->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->execute();
            $object = $statement->fetchObject($className);
            return $object;
        } else {
            $query = "SELECT * FROM $tableName";
            $statement = self::$db->query($query);
            $statement->setFetchMode(PDO::FETCH_CLASS, $className);
            $objects = $statement->fetchAll();
            return $objects;
        }
    }

    /**
     * Insert a new record into the table
     * @return int|bool
     */
    public function create(): int | bool
    {
        $tableName = static::$tableName;

        $query = "INSERT INTO $tableName (";
        $values = "";
        foreach ($this as $key => $value) {
            $query .= $key . ", ";
            $values .= ":$key, ";
        }
        $query = rtrim($query, ', ');
        $query .= ") VALUES (";
        $query .= $values;
        $query = rtrim($query, ', ');
        $query = $query .= ")";

        $statement = self::$db->prepare($query);
        foreach ($this as $key => $value) {
            $statement->BindValue(":$key", $value);
        }

        if ($statement->execute()) {
            return self::$db->lastInsertId();
        } else {
            return false;
        }
        return $result;
    }

    /**
     * Update a record
     *
     * @param int $id
     * @return bool
     */
    public function update(int $id): bool
    {
        $tableName = static::$tableName;
        $keyColumn = static::$keyColumn;

        $query = "UPDATE $tableName SET ";
        foreach ($this as $key => $value) {
            $query .= "$key = :$key, ";
        }
        $query = rtrim($query, ', ');
        $query .= " WHERE $keyColumn = :id";

        $statement = self::$db->prepare($query);
        foreach ($this as $key => $value) {
            $statement->BindValue(":$key", $value);
        }
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        return $result;
    }

    /**
     * Delete a record
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $tableName = static::$tableName;
        $keyColumn = static::$keyColumn;
        $query = "DELETE FROM $tableName WHERE $keyColumn = :id";
        $statement = self::$db->prepare($query);
        $statement->bindValue(':id', $id);
        $result = $statement->execute();
        return $result;
    }

    /**
     * Gett all records from the table
     *
     * @return object
     */
    public static function all(): object
    {
        $tableName = static::$tableName;
        self::$query = "SELECT * FROM $tableName ";
        return new self();
    }

    /**
     * Compose query
     *
     * @param string $key
     * @param string $value
     * @param string $compOperator
     * @param string $logicOperator
     * @return self
     */
    public function where($key, $value, $compOperator = '=', $logicOperator = null): object
    {
        if (!$logicOperator) {
            self::$query .= "Where $key $compOperator '" . $value . "'";
        } else {
            self::$query .= "$logicOperator Where $key $compOperator '" . $value . "'";
        }
        return new self();
    }

    /**
     * Compose query
     *
     * @param array $tables
     * @param array $joinColumns
     * @return self
     */
    public static function join(array $tables, array $joinColumns): object
    {
        self::$query .= "JOIN $tables[1] ON $tables[0].$joinColumns[0] = $tables[1].$joinColumns[1] ";
        return new self();
    }

    /**
     * Get records according to the specified query
     *
     * @return array
     */
    public function fetch(): array
    {
        $statement = self::$db->query(self::$query);
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }
}
        