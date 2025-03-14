<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Nama kategori
            $table->string('slug')->unique(); // Slug untuk URL
            $table->text('description')->nullable(); // Deskripsi kategori
            $table->boolean('is_active')->default(true); // Status aktif
            $table->integer('order')->default(0); // Urutan tampilan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
};
