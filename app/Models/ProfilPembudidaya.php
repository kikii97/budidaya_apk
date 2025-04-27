<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPembudidaya extends Model
{
    use HasFactory;

    protected $table = 'profil_pembudidaya'; // Pastikan tabelnya

    protected $fillable = [
        'foto_profil',
        'nomor_telepon',
        'deskripsi',
        'alamat',
        'pembudidaya_id',
    ];

    public function pembudidaya()
    {
        return $this->belongsTo(Pembudidaya::class, 'pembudidaya_id');
    }
}
