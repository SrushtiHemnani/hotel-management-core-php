<?php

namespace App\models;

use Exception;

/**
 * ExtraReservation model class.
 */
class ExtraReservation extends BaseModel
{
    // Declare properties with their types
    public int $id;
    public int $reservation_id;
    public int $extra_id;
    public ?string $created_at = null;
    public ?string $updated_at = null;
    public ?string $deleted_at = null;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function getTable(): string
    {
        return 'extra_reservations';
    }

    /**
     * Save (Insert) extra reservation data if no ID exists
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO extra_reservations (reservation_id, extra_id, created_at, updated_at, deleted_at)
                  VALUES (?, ?, NOW(), NOW(), NULL)";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "ii",
            $this->reservation_id,
            $this->extra_id
        );
        return $stmt->execute();
    }

    /**
     * Update extra reservation data if ID exists
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE extra_reservations SET reservation_id = ?, extra_id = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iii",
            $this->reservation_id,
            $this->extra_id,
            $this->id
        );
        return $stmt->execute();
    }

    /**
     * Delete extra reservation record
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM extra_reservations WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    /**
     * Soft delete extra reservation record
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "UPDATE extra_reservations SET deleted_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
