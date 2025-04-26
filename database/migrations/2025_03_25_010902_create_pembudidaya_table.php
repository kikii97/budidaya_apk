<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembudidaya', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique(); // pastikan email unik
            $table->string('password');
            $table->text('address');
            $table->enum('role', ['pembudidaya', 'admin'])->default('pembudidaya'); // Kolom role, dengan enum untuk pilihan yang lebih terbatas
            $table->json('documents')->nullable(); // Kolom tambahan untuk dokumen (bisa simpan banyak file dalam array JSON)
            $table->boolean('is_approved')->default(false); // Kolom status persetujuan dengan default false
            $table->rememberToken();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembudidaya');
    }
};
