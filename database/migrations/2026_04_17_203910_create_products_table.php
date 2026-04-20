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

            $table->string('kode_barang')->nullable();
            $table->string('nama_barang');
            $table->string('jenis_barang')->nullable();
            $table->text('deskripsi')->nullable();

            $table->string('status')->default('Ready');
            $table->string('estimasi')->nullable();

            $table->integer('harga')->default(0);
            $table->integer('unit')->default(0);

            $table->string('gambar')->nullable();

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