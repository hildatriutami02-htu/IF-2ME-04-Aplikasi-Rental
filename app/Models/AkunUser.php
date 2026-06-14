<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkunUser extends Model
{
    protected $table = 'akun_users';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role',
    ];
}