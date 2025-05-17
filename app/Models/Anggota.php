<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'no_anggota';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'no_anggota', 'nip', 'ktp', 'email', 'nama', 'tgl_lahir', 'nohp', 'tgl_aktivasi',
        'tgl_keluar', 'simpanan_wajib', 'rekening', 'provinsi', 'kota', 'kecamatan',
        'kelurahan', 'alamat','no_pensiun', 'jenis_pensiun', 'foto', 'type', 'status', 'is_deleted',
        'createdon', 'createdby', 'modifiedon', 'modifiedby'
    ];

    protected $casts = [
        'simpanan_wajib' => 'float',
        'tgl_lahir' => 'datetime',
        'tgl_aktivasi' => 'datetime',
        'tgl_keluar' => 'datetime',
        'createdon' => 'datetime',
        'modifiedon' => 'datetime',
    ];
}
