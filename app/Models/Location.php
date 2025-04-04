<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'lokasi'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key

    protected $fillable = [
        'nama_desa', 
        'kecamatan', 
        'latitude', 
        'longitude'
    ]; // Kolom yang bisa diisi secara massal

    public $timestamps = true; // Menggunakan created_at & updated_at otomatis
}
