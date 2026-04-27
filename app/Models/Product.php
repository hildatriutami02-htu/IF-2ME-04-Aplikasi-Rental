<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jenis_barang',
        'deskripsi',
        'status',
        'estimasi',
        'harga',
        'unit',
        'gambar',
    ];
}