<?php

namespace App\Models;

use App\Core\Database;

abstract class BaseModel
{
    protected static string $table;

    protected array $fillable = [];

    public function __construct($fillable = []) {}

    public function __get($key)
    {
        return $model->fillable[$key] ?? null;
    }

    public static function getTableName()
    {
        return static::$table;
    }

    public function fill(array $data)
    {
        return array_intersect_key($data, array_flip($this->fillable));
    }

    public static function create(array $attributes)
    {
        $pdo = Database::getConnection();
        $model = new static();
        $filledAttributes = $model->fill($attributes);

        $cols = implode(',', array_keys($filledAttributes));
        $rows = array_values($filledAttributes);
        $placeholders = implode(',', array_fill(0, count($rows), '?'));

        $sql = "INSERT INTO " . static::getTableName() . " ($cols) VALUES ($placeholders)";

        $stmt = $pdo->prepare($sql);

        if ($stmt->execute($rows)) {
            $attributes['id'] = $pdo->lastInsertId();
            return $attributes;
        };

        return null;
    }
}
