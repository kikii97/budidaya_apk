<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_pembudidaya', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembudidaya_id')->unique(); // Satu pembudidaya satu profil
            $table->string('foto_profil')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('alamat')->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('pembudidaya_id')->references('id')->on('pembudidaya')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_pembudidaya');
    }
};
