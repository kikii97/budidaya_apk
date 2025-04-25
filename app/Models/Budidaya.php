<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budidaya extends Model
{
    use HasFactory;

    protected $fillable = [
        'commodity_type_id',
        'name',
        'description',
        'profil_usaha',
        'kapasitas_usaha',
        'proses_budidaya',
        'kendala_produksi',
        'masa_puncak_produksi',
        'produksi_tahunan',
        'pemasaran',
        'kisaran_harga',
        'uji_kualitas_air',
        'latitude',
        'longitude'
    ];

    public function commodityType()
    {
        return $this->belongsTo(CommodityType::class);
    }
}
