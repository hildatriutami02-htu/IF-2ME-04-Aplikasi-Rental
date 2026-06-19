<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'kode_barang',
        'jenis_barang',
        'nama_barang',
        'status',
        'estimasi',
        'deskripsi',
        'harga',
        'unit',
        'gambar',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'product_id');
    }
}