<?php

namespace App\models;

use Exception;

/**
 * Person model class.
 */
class Person extends BaseModel
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string|null
     */
    public ?string $password = null;

    /**
     * @var string|null
     */
    public ?string $phone = null;

    /**
     * @var string|null
     */
    public ?string $date_of_birth = null;

    /**
     * @var string|null
     */
    public ?string $address = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the table name.
     *
     * @return string
     */
    protected static function getTable(): string
    {
        return 'persons';
    }

    /**
     * Save (Insert) person data if no ID exists.
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO persons (name, email, password, phone, date_of_birth, address) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "ssssss",
            $this->name,
            $this->email,
            $this->password,
            $this->phone,
            $this->date_of_birth,
            $this->address
        );
        return $stmt->execute();
    }

    /**
     * Update person data if ID exists.
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE persons SET name = ?, email = ?, password = ?, phone = ?, date_of_birth = ?, address = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "ssssssi",
            $this->name,
            $this->email,
            $this->password,
            $this->phone,
            $this->date_of_birth,
            $this->address,
            $this->id
        );
        return $stmt->execute();
    }

    /**
     * Delete person.
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM persons WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    /**
     * Soft delete person by setting deleted_at timestamp.
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to soft delete a record.");
        }

        $query = "UPDATE persons SET deleted_at = NOW(), updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

}
