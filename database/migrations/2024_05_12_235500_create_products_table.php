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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug');
            $table->text('thumb_gambar');
            $table->integer('kategori_id');
            $table->integer('sub_kategori_id')->nullable();
            $table->integer('anak_kategori_id')->nullable();
            $table->integer('brand_id');
            $table->integer('qty');
            $table->text('deskripsi_pendek');
            $table->text('deskripsi_panjang');
            $table->text('video_link')->nullable();
            $table->string('sku')->nullable();
            $table->double('harga');
            $table->double('harga_diskon')->nullable();
            $table->date('tanggal_diskon_mulai')->nullable();
            $table->date('tanggal_diskon_akhir')->nullable();
            $table->string('tipe_produk')->nullable();
            $table->boolean('status');
            $table->string('seo_title')->nullable();
            $table->text('seo_deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
