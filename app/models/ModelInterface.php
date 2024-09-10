<?php

namespace App\models;

/**
 *
 */
interface ModelInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public static function find(int $id);

    /**
     * @return mixed
     */
    public static function all();

    /**
     * @return mixed
     */
    public function save();

    /**
     * @return mixed
     */
    public function update();

    /**
     * @return mixed
     */
    public function softDelete();

    /**
     * @return mixed
     */
    public function delete();
}
