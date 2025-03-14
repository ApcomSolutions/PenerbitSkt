<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('image_path');    // Path gambar
            $table->string('caption')->nullable(); // Caption/keterangan gambar
            $table->boolean('is_primary')->default(false); // Gambar utama
            $table->integer('order')->default(0); // Urutan tampilan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_images');
    }
};
