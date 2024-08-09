<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'company',
        'vat',
        'token',
    ];

    protected $hidden = [
        'password',
        'token',
    ];

    // Eğer adresleri ilişkilendirmeniz gerekiyorsa, aşağıdaki gibi bir ilişki ekleyebilirsiniz
    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }
}
