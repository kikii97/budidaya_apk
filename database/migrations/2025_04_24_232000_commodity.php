<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Commodity extends Migration
{
    public function up()
    {
        Schema::create('commodity_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama komoditas, contoh: Udang, Rumput Laut
            $table->string('icon')->nullable(); // Nama icon atau path icon
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commodity_types');
    }
}
