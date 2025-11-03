<?php 

namespace App\Models;

class Product extends BaseModel{
    protected static string $table = "produtos";

    protected array $fillable = [
        'nome',
        'descricao',
        'preco'
    ];
}