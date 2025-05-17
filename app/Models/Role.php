<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Nama tabel (optional kalau mengikuti konvensi Laravel)
    protected $table = 'roles';

    // Kolom yang bisa diisi massal (mass assignable)
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    // Jika ingin disable auto increment (id) atau primary key custom,
    // bisa diatur di sini (tidak diperlukan dalam kasus ini karena id default)
}
