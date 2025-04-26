<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pembudidaya extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pembudidaya';

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'role',
        'documents',
        'is_approved',
    ];

    protected $casts = [
        'documents' => 'array', // hanya documents yang di-cast
    ];

    protected $attributes = [
        'role' => 'pembudidaya',
        'is_approved' => null,
    ];
}
