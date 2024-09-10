<?php

namespace App\models;

use Exception;

/**
 * Role model class.
 */
class Role extends BaseModel
{
    // Declare properties with their types
    public int $id;
    public int $person_id;
    public ?int $hotel_id = null;
    public string $role;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function getTable(): string
    {
        return 'roles';
    }

    /**
     * Save (Insert) role data if no ID exists
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO roles (person_id, hotel_id, role, created_at, updated_at)
                  VALUES (?, ?, ?, NOW(), NOW())";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iis",
            $this->person_id,
            $this->hotel_id,
            $this->role
        );
        return $stmt->execute();
    }

    /**
     * Update role data if ID exists
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE roles SET person_id = ?, hotel_id = ?, role = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "iisi",
            $this->person_id,
            $this->hotel_id,
            $this->role,
            $this->id
        );
        return $stmt->execute();
    }

    /**
     * Delete role record
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM roles WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    /**
     * Soft delete role record
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "UPDATE roles SET deleted_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
