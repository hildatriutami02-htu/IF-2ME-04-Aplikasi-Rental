<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUser extends Model
{
    use HasFactory;

    protected $table = 'data_users';

    protected $fillable = [
        'kode_user',
        'nama_lengkap',
        'no_ktp',
        'no_telp',
        'no_wa',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'foto_ktp',
    ];
}