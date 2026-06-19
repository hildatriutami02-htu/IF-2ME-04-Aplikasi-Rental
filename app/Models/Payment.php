<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'rental_id',
        'kode_transaksi',
        'nama_pelanggan',
        'nominal',
        'metode',
        'bukti_bayar',
        'status',
        'catatan',
    ];
}