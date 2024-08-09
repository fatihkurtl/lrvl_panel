<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'image',
        'brand',
        'price',
        'category',
        'weight',
        'stock',
        'color',
        'description',
        'active',
        'created_at',
        'updated_at',
    ];

    public function shoppingCarts()
    {
        return $this->hasMany(ShoppingCart::class);
    }
}
