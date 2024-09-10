<?php

namespace App\models;

use Exception;

/**
 * Room model class.
 */
class Room extends BaseModel
{
    // Declare properties with their types
    public int $id;
    public int $hotel_id;
    public int $floor_id;
    public int $room_category_id;
    public string $room_number;
    public bool $is_available;
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $deleted_at = null;
    // Additional properties for joined data

    public function __construct()
    {
        parent::__construct();
    }

    protected static function getTable(): string
    {
        return 'rooms';
    }

    /**
     * Save (Insert) room data if no ID exists
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO rooms (hotel_id, floor_id, room_category_id, room_number, is_available, created_at, updated_at, deleted_at)
                  VALUES (?, ?, ?, ?, ?, NOW(), NOW(), NULL)";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iiiss",
            $this->hotel_id,
            $this->floor_id,
            $this->room_category_id,
            $this->room_number,
            $this->is_available
        );
        return $stmt->execute();
    }

    /**
     * Update room data if ID exists
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE rooms SET hotel_id = ?, floor_id = ?, room_category_id = ?, room_number = ?, is_available = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iiissi",
            $this->hotel_id,
            $this->floor_id,
            $this->room_category_id,
            $this->room_number,
            $this->is_available,
            $this->id
        );
        return $stmt->execute();
    }

    /**
     * Delete room record
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM rooms WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    /**
     * Soft delete room record
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "UPDATE rooms SET deleted_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
