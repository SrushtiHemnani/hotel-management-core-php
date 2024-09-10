<?php

namespace App\models;

use Exception;

/**
 * Floor model class.
 */
class Floor extends BaseModel
{
    // Declare properties with their types
    public int $id;
    public ?int $building_id = null;
    public int $hotel_id;
    public int $floor_number;
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $deleted_at = null;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function getTable(): string
    {
        return 'floors';
    }

    /**
     * Save (Insert) floor data if no ID exists
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO floors (building_id, hotel_id, floor_number, created_at, updated_at, deleted_at)
                  VALUES (?, ?, ?, NOW(), NOW(), NULL)";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iis",
            $this->building_id,
            $this->hotel_id,
            $this->floor_number
        );
        return $stmt->execute();
    }

    /**
     * Update floor data if ID exists
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE floors SET building_id = ?, hotel_id = ?, floor_number = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iisi",
            $this->building_id,
            $this->hotel_id,
            $this->floor_number,
            $this->id
        );
        return $stmt->execute();
    }

    /**
     * Delete floor record
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM floors WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    /**
     * Soft delete floor record
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "UPDATE floors SET deleted_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
