<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id(); // ID unik
            $table->json('gambar'); // Ubah menjadi JSON untuk menyimpan multiple gambar
            $table->string('telepon', 15); // Nomor telepon
            $table->text('alamat_lengkap'); // Alamat lengkap produk
            $table->string('kecamatan')->index(); // Tambahan kolom untuk kecamatan
            $table->string('jenis_komoditas')->index(); // Jenis komoditas
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('jenis_spesifik_komoditas')->nullable(); // Jenis spesifik komoditas
            $table->unsignedInteger('kapasitas_produksi')->nullable(); // Kapasitas produksi
            $table->string('masa_produksi_puncak')->nullable(); // Masa produksi puncak
            $table->decimal('kisaran_harga_min', 10, 2)->unsigned(); // Harga minimum
            $table->decimal('kisaran_harga_max', 10, 2)->unsigned(); // Harga maksimum
            $table->date('prediksi_panen')->nullable(); // Prediksi panen
            $table->text('detail')->nullable(); // Detail produk
            $table->boolean('is_approved')->nullable(); // Status approval oleh admin
            $table->unsignedBigInteger('pembudidaya_id')->nullable(); // Kolom pembudidaya_id
            $table->foreign('pembudidaya_id')->references('id')->on('pembudidaya')->onDelete('cascade'); // Relasi dengan tabel pembudidaya
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk'); // Hapus tabel produk jika rollback
    }
}
