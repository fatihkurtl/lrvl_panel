<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'cart_number',
        'expiration_date',
        'cvv',
        'total_price',
    ];
}
