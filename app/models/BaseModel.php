<?php

namespace App\models;

use Exception;
use mysqli;

/**
 * Base model class with common functionality.
 */
abstract class BaseModel implements ModelInterface
{
    /**
     * @var null
     *
     */
    protected static $connection = null;
    /**
     * @var string
     */
    protected static $table = ''; // Table name variable
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $deleted_at = null;

    public function __construct()
    {
        self::initConnection();
    }
    // Singleton pattern for database connection

    /**
     * @return mysqli
     */
    protected static function initConnection() : mysqli
    {
        if (self::$connection === null) {
            global $connection;  // Assuming global connection is already set
            self::$connection = $connection;
        }
        return self::$connection;
    }

    // Get the table name

    /**
     * @return string
     */
    protected static function getTable(): string
    {
        return static::$table;
    }

    public static function find(int $id)
    {
        self::initConnection();
        $table = static::getTable();
        $query = "SELECT * FROM $table WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_object(static::class)) {
            return $row;
        }
        return null;
    }
    // Generic method to find a record by any field

    /**
     * @param string $field
     * @param $value
     * @return self|null
     */
    public static function findByField(string $field, $value): ?self
    {
        self::initConnection();
        $table = static::getTable();
        $query = "SELECT * FROM $table WHERE $field = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_object(static::class)) {
            return $row;
        }
        return null;
    }

    // Fetch all records as objects

    /**
     * @return array
     */
  public static function all()
{
    self::initConnection();
    $table = static::getTable();
    $query = "SELECT * FROM $table";

    $result = self::$connection->query($query);

    // Fetch all rows as objects of the model class
    $objects = [];
    while ($object = $result->fetch_object(static::class)) {
        $objects[] = $object;
    }


    // Return array of objects
    return $objects;
}

    // Custom query execution (optional)

    /**
     * @param $query
     * @param $params
     * @param $types
     * @return array
     */
    public static function executeQuery($query, $params = [], $types = "")
    {
        self::initConnection();
        $stmt = self::$connection->prepare($query);

        if ($params && $types) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch all rows as objects of the model class
        $objects = [];
        while ($object = $result->fetch_object(static::class)) {
            $objects[] = $object;
        }

        return $objects;
    }

    // Abstract methods for saving, updating, deleting

    /**
     * @return mixed
     */
    abstract public function save();

    /**
     * @return mixed
     */
    abstract public function update();

    /**
     * @return mixed
     */
    abstract public function softDelete();

    /**
     * @return mixed
     */
    abstract public function delete();
}
