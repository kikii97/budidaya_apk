<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pembudidaya extends Authenticatable
{
    use Notifiable;

    protected $guard = 'pembudidaya'; // Nama guard khusus untuk Pembudidaya

    protected $table = 'pembudidaya'; // Nama tabel di database

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'role',
        'documents', // <<< tambahkan ini agar bisa mass assignment untuk dokumen
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'documents' => 'array', // <<< tambahkan ini supaya saat ambil dari database langsung jadi array
    ];

    /**
     * Relasi: Pembudidaya memiliki banyak Produk
     */
    public function produk()
    {
        return $this->hasMany(Produk::class, 'pembudidaya_id');
    }
}
