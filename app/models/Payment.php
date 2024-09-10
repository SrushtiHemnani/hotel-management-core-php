<?php

namespace App\models;

use Exception;

/**
 * Payment model class.
 */
class Payment extends BaseModel
{
    // Declare properties with their types
    public int $id;
    public int $billing_id;
    public string $payment_method;
    public float $amount;
    public ?string $payment_date = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct()
    {
        parent::__construct();
    }

    protected static function getTable(): string
    {
        return 'payments';
    }

    /**
     * Save (Insert) payment data if no ID exists
     *
     * @return bool
     */
    public function save(): bool
    {
        $query = "INSERT INTO payments (billing_id, payment_method, amount, payment_date, created_at, updated_at)
                  VALUES (?, ?, ?, ?, NOW(), NOW())";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "isds",
            $this->billing_id,
            $this->payment_method,
            $this->amount,
            $this->payment_date
        );
        return $stmt->execute();
    }

    /**
     * Update payment data if ID exists
     *
     * @return bool
     * @throws Exception
     */
    public function update(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to update a record.");
        }

        $query = "UPDATE payments SET billing_id = ?, payment_method = ?, amount = ?, payment_date = ?, updated_at = NOW() WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param(
            "isdis",
            $this->billing_id,
            $this->payment_method,
            $this->amount,
            $this->payment_date,
            $this->id
        );
        return $stmt->execute();
    }

    /**
     * Delete payment record
     *
     * @return bool
     * @throws Exception
     */
    public function delete(): bool
    {
        if (!$this->id) {
            throw new Exception("ID is required to delete a record.");
        }

        $query = "DELETE FROM payments WHERE id = ?";
        $stmt = self::$connection->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}
