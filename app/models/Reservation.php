<?php

namespace App\models;

use Exception;

/**
 * Reservation model class.
 */
class Reservation extends BaseModel
{
    // Declare properties with their types
    public int $id;
    public int $person_id;
    public int $room_id;
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
        return 'reservations';
    }

    /**
     * Save (Insert) reservation data if no ID exists
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO reservations (person_id, room_id, check_in, check_out, created_at, updated_at, deleted_at)
                  VALUES (?, ?, ?, ?, NOW(), NOW(), NULL)";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iiss",
            $this->person_id,
            $this->room_id,
            $this->check_in,
            $this->check_out
        );
        return $stmt->execute();
    }

    /**
     * Update reservation data if ID exists
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE reservations SET person_id = ?, room_id = ?, check_in = ?, check_out = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iissi",
            $this->person_id,
            $this->room_id,
            $this->check_in,
            $this->check_out,
            $this->id
        );
        return $stmt->execute();
    }

    /**
     * Delete reservation record
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM reservations WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    /**
     * Soft delete reservation record
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "UPDATE reservations SET deleted_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
