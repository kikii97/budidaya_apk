<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\ProfilPembudidaya;
use App\Models\Produk;

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
        'documents' => 'array',
    ];

    protected $attributes = [
        'role' => 'pembudidaya',
        'is_approved' => null,
    ];

    // Relasi ke tabel profil_pembudidaya
    public function profil()
    {
        return $this->hasOne(ProfilPembudidaya::class, 'pembudidaya_id');
    }

    // 🔥 Relasi ke Produk
    public function produk()
    {
        return $this->hasMany(Produk::class, 'pembudidaya_id');
    }
}
