<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->nullable()->constrained('rentals')->nullOnDelete();
            $table->string('kode_transaksi')->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->integer('nominal')->default(0);
            $table->string('metode')->default('Cash');
            $table->string('bukti_bayar')->nullable();
            $table->enum('status', ['Menunggu Verifikasi', 'Lunas', 'Ditolak'])
                  ->default('Menunggu Verifikasi');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};