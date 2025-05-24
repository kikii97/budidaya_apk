<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $fillable = ['pembudidaya_id', 'judul', 'pesan', 'dibaca'];

    public function pembudidaya()
    {
        return $this->belongsTo(Pembudidaya::class);
    }
}
