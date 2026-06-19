<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('rental_id')->nullable()->after('id');
            $table->string('kode_transaksi')->nullable()->after('rental_id');
            $table->string('nama_pelanggan')->nullable()->after('kode_transaksi');
            $table->integer('nominal')->default(0)->after('nama_pelanggan');
            $table->string('metode')->default('Cash')->after('nominal');
            $table->string('bukti_bayar')->nullable()->after('metode');
            $table->enum('status', ['Menunggu Verifikasi', 'Lunas', 'Ditolak'])
                  ->default('Menunggu Verifikasi')
                  ->after('bukti_bayar');
            $table->text('catatan')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'rental_id',
                'kode_transaksi',
                'nama_pelanggan',
                'nominal',
                'metode',
                'bukti_bayar',
                'status',
                'catatan',
            ]);
        });
    }
};