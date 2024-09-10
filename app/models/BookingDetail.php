<?php

namespace App\models;

use Exception;

/**
 * BookingDetail model class.
 */
class BookingDetail extends BaseModel
{
    // Declare properties with their types
    public int $id;
    public int $booking_id;
    public int $room_id;
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $deleted_at = null;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function getTable(): string
    {
        return 'booking_details';
    }

    /**
     * Save (Insert) booking detail data if no ID exists
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO booking_details (booking_id, room_id, created_at, updated_at, deleted_at)
                  VALUES (?, ?, NOW(), NOW(), NULL)";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "ii",
            $this->booking_id,
            $this->room_id
        );
        return $stmt->execute();
    }

    /**
     * Update booking detail data if ID exists
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE booking_details SET booking_id = ?, room_id = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iii",
            $this->booking_id,
            $this->room_id,
            $this->id
        );
        return $stmt->execute();
    }

    /**
     * Delete booking detail
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM booking_details WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    /**
     * Soft delete booking detail
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "UPDATE booking_details SET deleted_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
