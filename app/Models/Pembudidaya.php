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
        'documents', // Tambahkan field documents untuk mass assignment
        'is_approved', // Tambahkan field is_approved untuk status persetujuan
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'documents' => 'array', // Agar 'documents' di-cast sebagai array
        'is_approved' => 'integer', // Pastikan 'is_approved' di-cast sebagai boolean
    ];

    /**
     * Relasi: Pembudidaya memiliki banyak Produk
     */
    public function produk()
    {
        return $this->hasMany(Produk::class, 'pembudidaya_id');
    }
}
