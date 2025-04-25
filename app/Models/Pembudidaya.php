<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pembudidaya extends Authenticatable
{
    use Notifiable;

    protected $guard = 'pembudidaya'; // Sesuaikan dengan guard di auth.php

    protected $table = 'pembudidaya'; // Menyesuaikan nama tabel

    protected $fillable = [
        'name', 'email', 'password', 'address',
    ];

    protected $hidden = [
        'password',
    ];
        // Relasi Pembudidaya ke Produk
        public function produk()
        {
            return $this->hasMany(Produk::class, 'pembudidaya_id');
        }
}
