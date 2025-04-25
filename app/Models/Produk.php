<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'gambar',
        'telepon',
        'alamat_lengkap', // ubah dari 'alamat'
        'kecamatan', // ditambahkan untuk keperluan filter
        'jenis_komoditas',
        'jenis_spesifik_komoditas',
        'kapasitas_produksi',
        'masa_produksi_puncak',
        'kisaran_harga_min',
        'kisaran_harga_max',
        'prediksi_panen',
        'detail',
        'is_approved',
        'user_id',
        'pembudidaya_id', // pastikan juga bisa diisi jika relasi dipakai
    ];

    protected $casts = [
        'gambar' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembudidaya()
    {
        return $this->belongsTo(Pembudidaya::class, 'pembudidaya_id');
    }
}
