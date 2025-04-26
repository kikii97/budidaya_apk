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
            $table->string('email')->unique();
            $table->string('password');
            $table->text('address');
            $table->string('role')->default('pembudidaya'); // kolom role
            $table->json('documents')->nullable(); // kolom tambahan untuk dokumen (bisa simpan banyak file dalam array JSON)
            $table->boolean('is_approved')->nullable(); // kolom tambahan untuk status persetujuan
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
