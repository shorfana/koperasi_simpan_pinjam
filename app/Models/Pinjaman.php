<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    // Nama tabel jika tidak mengikuti konvensi
    protected $table = 'pinjaman';

    // Primary key bukan 'id', jadi kita tentukan
    protected $primaryKey = 'kode_pinjaman';

    // Tidak pakai auto-increment (karena kode_pinjaman integer manual)
    public $incrementing = false;

    // Kalau primary key bukan tipe integer default
    protected $keyType = 'int';

    // Tidak menggunakan timestamps default (created_at, updated_at)
    public $timestamps = false;

    protected $fillable = [
        'kode_pinjaman',
        'tanggal',
        'jenis_kode_kas',
        'no_anggota',
        'pinjaman',
        'nominal_pinjaman',
        'tgl_jatuh_tempo',
        'keterangan',
        'bulan',
        'cicilan_perbulan',
        'status',
        'createdon',
        'createdby',
        'modifiedon',
        'modifiedby',
        'is_deleted',

        // Kolom tambahan
        'persentase_dpu',
        'usia_masuk',
        'angsuran_per_bulan',
        'penerimaan_bersih',
        'dpu_asuransi',
        'jasa_pelayanan',
        'buku_anggota',
        'materai',
        'persentase_provisi',
        'provisi',
        'tanggal_lunas',
        'penerimaan_bersih_tabungan',
    ];

}
