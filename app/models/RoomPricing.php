<?php

namespace App\models;

use Exception;

/**
 * RoomPricing model class.
 */
class RoomPricing extends BaseModel
{
    // Declare properties with their types
    public int $id;
    public int $room_id;
    public float $price;
    public ?string $start_date = null;
    public ?string $end_date = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $deleted_at = null;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function getTable(): string
    {
        return 'room_pricing';
    }

    /**
     * Save (Insert) room pricing data if no ID exists
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO room_pricing (room_id, price, start_date, end_date, created_at, updated_at, deleted_at)
                  VALUES (?, ?, ?, ?, NOW(), NOW(), NULL)";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "idss",
            $this->room_id,
            $this->price,
            $this->start_date,
            $this->end_date
        );
        return $stmt->execute();
    }

    /**
     * Update room pricing data if ID exists
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE room_pricing SET room_id = ?, price = ?, start_date = ?, end_date = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "idssi",
            $this->room_id,
            $this->price,
            $this->start_date,
            $this->end_date,
            $this->id
        );
        return $stmt->execute();
    }

    /**
     * Delete room pricing record
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM room_pricing WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    /**
     * Soft delete room pricing record
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "UPDATE room_pricing SET deleted_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
