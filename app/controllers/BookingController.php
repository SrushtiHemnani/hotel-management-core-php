<?php

namespace App\models;

use Exception;

/**
 * Booking model class.
 */
class Booking extends BaseModel
{
    // Declare properties with their types
    public int $id;
    public int $person_id;
    public int $hotel_id;
    public string $check_in;
    public string $check_out;
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $deleted_at = null;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function getTable(): string
    {
        return 'bookings';
    }

    /**
     * Save (Insert) booking data if no ID exists
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO bookings (person_id, hotel_id, check_in, check_out, created_at, updated_at, deleted_at)
                  VALUES (?, ?, ?, ?, NOW(), NOW(), NULL)";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iiss",
            $this->person_id,
            $this->hotel_id,
            $this->check_in,
            $this->check_out
        );
        return $stmt->execute();
    }

    /**
     * Update booking data if ID exists
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE bookings SET person_id = ?, hotel_id = ?, check_in = ?, check_out = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iissi",
            $this->person_id,
            $this->hotel_id,
            $this->check_in,
            $this->check_out,
            $this->id
        );
        return $stmt->execute();
    }

    /**
     * Delete booking
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM bookings WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    /**
     * Soft delete booking
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "UPDATE bookings SET deleted_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
