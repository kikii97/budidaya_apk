<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'nama_customer',
        'no_hp_customer',
        'jumlah',
        'tanggal_order',
        'keterangan',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
