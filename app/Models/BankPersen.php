<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankPersen extends Model
{
    use HasFactory;
    protected $table = 'bank_persen';
    protected $guarded = [];
    public $timestamps = false;

    protected $fillable = [
        'persentase_dpu',
        'usia_masuk',
        'angsuran_per_bulan',
        'penerimaan_bersih',
        'dpu_asuransi',
        'jasa_pelayanan',
        'buku_anggota',
        'materai',
        'persentase_provinsi',
        'provinsi',
        'tanggal_lunas',
        'penerimaan_bersih_tabungan',
    ];
}
