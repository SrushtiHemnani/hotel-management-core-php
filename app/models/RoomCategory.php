<?php

namespace App\models;

use Exception;

/**
 * RoomCategory model class.
 */
class RoomCategory extends BaseModel
{
    // Declare properties with their types
    public int $id;
    public string $name;
    public int $capacity;
    public ?string $description = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $deleted_at = null;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function getTable(): string
    {
        return 'room_categories';
    }

    /**
     * Save (Insert) room category data if no ID exists
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO room_categories (name, capacity, description, created_at, updated_at, deleted_at)
                  VALUES (?, ?, ?, NOW(), NOW(), NULL)";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "sis",
            $this->name,
            $this->capacity,
            $this->description
        );
        return $stmt->execute();
    }

    /**
     * Update room category data if ID exists
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE room_categories SET name = ?, capacity = ?, description = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "sisi",
            $this->name,
            $this->capacity,
            $this->description,
            $this->id
        );
        return $stmt->execute();
    }

    /**
     * Delete room category record
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM room_categories WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    /**
     * Soft delete room category record
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "UPDATE room_categories SET deleted_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
