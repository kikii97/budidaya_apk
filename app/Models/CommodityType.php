<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommodityType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon'];

    public function budidayas()
    {
        return $this->hasMany(Budidaya::class);
    }
}
