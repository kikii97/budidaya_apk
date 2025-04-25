<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Budidayas extends Migration
{
    public function up()
    {
        Schema::create('budidayas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commodity_type_id')->nullable()->constrained('commodity_types')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('profil_usaha');
            $table->string('kapasitas_usaha');
            $table->text('proses_budidaya');
            $table->string('kendala_produksi')->nullable();
            $table->string('masa_puncak_produksi')->nullable();
            $table->string('produksi_tahunan')->nullable();
            $table->string('pemasaran')->nullable();
            $table->string('kisaran_harga')->nullable();
            $table->string('uji_kualitas_air')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('budidayas');
    }
}
