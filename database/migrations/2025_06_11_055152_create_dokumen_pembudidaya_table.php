<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenPembudidayaTable extends Migration
{
    public function up()
    {
        Schema::create('dokumen_pembudidaya', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembudidaya_id');
            $table->string('surat_usaha_path'); // file PDF/JPG/PNG surat usaha
            $table->string('foto_usaha_path');  // file foto usaha
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('keterangan')->nullable(); // tambahan dari user
            $table->text('catatan')->nullable(); // feedback admin jika ditolak
            $table->timestamps();

            // Foreign key
            $table->foreign('pembudidaya_id')->references('id')->on('pembudidaya')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_pembudidaya');
    }
}
