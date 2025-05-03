<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('role')->default('user'); // user, seller, admin
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_admin')->default(false);

            // Kolom tambahan untuk fitur rekomendasi (SAW)
            $table->string('komoditas')->nullable();
            $table->decimal('harga_min', 10, 2)->nullable();
            $table->decimal('harga_max', 10, 2)->nullable();
            $table->string('kecamatan')->nullable();
            $table->date('prediksi_panen')->nullable();
            $table->integer('kapasitas_produksi')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
