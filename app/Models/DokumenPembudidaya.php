<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPembudidaya extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pembudidaya';

    protected $fillable = [
        'pembudidaya_id',
        'surat_usaha_path',
        'foto_usaha_path',
        'status',
        'keterangan',
        'catatan',
    ];

    public function pembudidaya()
    {
        return $this->belongsTo(Pembudidaya::class);
    }
}
