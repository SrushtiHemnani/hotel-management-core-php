<?php

namespace App\models;

use Exception;

/**
 * Facility model class.
 */
class Facility extends BaseModel
{
    // Declare properties with their types
    public int $id;
    public string $facility;
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $deleted_at = null;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function getTable(): string
    {
        return 'facilities';
    }

    /**
     * Save (Insert) facility data if no ID exists
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO facilities (facility, created_at, updated_at, deleted_at)
                  VALUES (?, NOW(), NOW(), NULL)";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("s", $this->facility);
        return $stmt->execute();
    }

    /**
     * Update facility data if ID exists
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE facilities SET facility = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("si", $this->facility, $this->id);
        return $stmt->execute();
    }

    /**
     * Delete facility record
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM facilities WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    /**
     * Soft delete facility record
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "UPDATE facilities SET deleted_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
