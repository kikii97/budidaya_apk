<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pembudidaya extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'is_approved' => 'integer', // Tetap cast ke integer saat diakses
        'documents' => 'array',     // Karena field documents disimpan JSON
    ];

    protected $attributes = [
        'role' => 'pembudidaya',   // Default role kalau tidak diisi
        'is_approved' => null,     // Default NULL, belum dikonfirmasi
    ];
}
