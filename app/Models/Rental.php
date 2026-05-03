<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';

    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'product_id',
        'nama_pelanggan',
        'email',
        'nama_barang',
        'qty',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_kembali_real',
        'harga_per_hari',
        'total_harga',
        'denda_per_hari',
        'total_denda',
        'status_pembayaran',
        'status_transaksi',
        'catatan',
        'foto_ktp',
    ];
}