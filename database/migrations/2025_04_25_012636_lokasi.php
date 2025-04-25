<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Lokasi extends Migration
{
    public function up()
    {
        Schema::create('lokasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa');       // Nama desa
            $table->string('kecamatan');       // Nama kecamatan
            $table->decimal('latitude', 10, 7)->nullable();   // Latitude
            $table->decimal('longitude', 10, 7)->nullable();  // Longitude
            $table->timestamps();              // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('lokasi');
    }
}
