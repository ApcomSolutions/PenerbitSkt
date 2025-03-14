<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');           // Judul/nama produk
            $table->string('slug')->unique();  // Slug untuk URL
            $table->text('description')->nullable(); // Deskripsi produk
            $table->string('author')->nullable();    // Penulis/pengarang
            $table->string('publisher')->nullable(); // Diterbitkan oleh
            $table->date('publish_date')->nullable(); // Tanggal terbit
            $table->string('isbn')->nullable();      // ISBN jika buku
            $table->string('cover_image')->nullable(); // Gambar sampul
            $table->string('dimensions')->nullable(); // Dimensi/ukuran buku
            $table->integer('pages')->nullable();    // Jumlah halaman
            $table->string('language')->nullable();  // Bahasa
            $table->string('edition')->nullable();   // Edisi
            $table->decimal('price', 10, 2)->nullable(); // Harga
            $table->decimal('discount_price', 10, 2)->nullable(); // Harga diskon
            $table->integer('stock')->default(0);    // Stok
            $table->boolean('is_featured')->default(false); // Produk unggulan
            $table->boolean('is_published')->default(true); // Status publikasi
            $table->timestamps();
            $table->softDeletes(); // Untuk trash/recycle bin
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
