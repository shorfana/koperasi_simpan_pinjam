<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\Models\Anggota;

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
        'nominal_pinjaman',
        'pinjaman', // Perhatikan ini. Di request ada 'nominal_pinjaman', tapi juga ada 'pinjaman' di create()
        'tgl_jatuh_tempo',
        'tgl_realisasi',
        'keterangan',
        'bulan',
        'cicilan_perbulan',
        'status',
        'createdon',
        'createdby',
        'is_deleted',
        'usia_masuk',
        'persentase_dpu',
        'dpu_asuransi',
        'jasa_pelayanan',
        'buku_anggota',
        'materai',
        'persentase_provisi',
        'provisi',
        'angsuran_per_bulan',
        'penerimaan_bersih',
        'tanggal_lunas',
        'penerimaan_bersih_tabungan',
    ];
    // protected $fillable = [
    //     'kode_pinjaman',
    //     'tanggal',
    //     'jenis_kode_kas',
    //     'no_anggota',
    //     'pinjaman',
    //     'nominal_pinjaman',
    //     'tgl_jatuh_tempo',
    //     'keterangan',
    //     'bulan',
    //     'cicilan_perbulan',
    //     'status',
    //     'createdon',
    //     'createdby',
    //     'modifiedon',
    //     'modifiedby',
    //     'is_deleted',

    //     // Kolom tambahan
    //     'persentase_dpu',
    //     'usia_masuk',
    //     'angsuran_per_bulan',
    //     'penerimaan_bersih',
    //     'dpu_asuransi',
    //     'jasa_pelayanan',
    //     'buku_anggota',
    //     'materai',
    //     'persentase_provisi',
    //     'provisi',
    //     'tanggal_lunas',
    //     'penerimaan_bersih_tabungan',
    // ];

    // Relasi ke model Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'no_anggota', 'no_anggota');
    }

    // Accessors untuk data anggota
    public function getNamaNasabahAttribute()
    {
        return $this->anggota->nama ?? '-';
    }

    public function getNikNasabahAttribute()
    {
        return $this->anggota->ktp ?? '-';
    }

    public function getKotaNasabahAttribute()
    {
        return $this->anggota->kota ?? '-';
    }

    public function getKecamatanNasabahAttribute()
    {
        return $this->anggota->kecamatan ?? '-';
    }

    public function getNoPensiunNasabahAttribute()
    {
        return $this->anggota->no_pensiun ?? '-';
    }

    public function getJenisPensiunNasabahAttribute()
    {
        return $this->anggota->jenis_pensiun ?? '-';
    }

    public function getTglLahirNasabahAttribute()
    {
        return $this->anggota->tgl_lahir ? Carbon::parse($this->anggota->tgl_lahir)->format('d F Y') : '-';
    }

    public function getUsiaNasabahAttribute()
    {
        return $this->anggota->tgl_lahir ? Carbon::parse($this->anggota->tgl_lahir)->age : '-';
    }

    public function getAlamatLengkapNasabahAttribute()
    {
        $alamat = $this->anggota->alamat ?? '';
        $kelurahan = $this->anggota->kelurahan ?? '';
        $kecamatan = $this->anggota->kecamatan ?? '';
        $kota = $this->anggota->kota ?? '';
        $provinsi = $this->anggota->provinsi ?? '';

        $parts = array_filter([$alamat, $kelurahan, $kecamatan, $kota, $provinsi]);
        return implode(', ', $parts);
    }

    public function getNohpNasabahAttribute()
    {
        return $this->anggota->nohp ?? '-';
    }

    // Accessor untuk tanggal realisasi
    public function getTanggalRealisasiFormattedAttribute()
    {
        return $this->tanggal ? Carbon::parse($this->tanggal)->format('d F Y') : '-';
    }

    // Accessor untuk tanggal lunas
    public function getTanggalLunasFormattedAttribute()
    {
        return $this->tanggal_lunas ? Carbon::parse($this->tanggal_lunas)->format('d F Y') : '-';
    }

    // Accessor untuk nilai-nilai numerik yang perlu diformat Rp
    public function getNominalPinjamanFormattedAttribute()
    {
        return 'Rp ' . number_format($this->nominal_pinjaman, 0, ',', '.');
    }

    public function getCicilanPerbulanFormattedAttribute()
    {
        return 'Rp ' . number_format($this->cicilan_perbulan, 0, ',', '.');
    }

    public function getProvisiFormattedAttribute()
    {
        return 'Rp ' . number_format($this->provisi, 0, ',', '.');
    }

    public function getDpuAsuransiFormattedAttribute()
    {
        return 'Rp ' . number_format($this->dpu_asuransi, 0, ',', '.');
    }

    public function getJasaPelayananFormattedAttribute()
    {
        return 'Rp ' . number_format($this->jasa_pelayanan, 0, ',', '.');
    }

    public function getBukuAnggotaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->buku_anggota, 0, ',', '.');
    }

    public function getMateraiFormattedAttribute()
    {
        return 'Rp ' . number_format($this->materai, 0, ',', '.');
    }

    public function getPenerimaanBersihFormattedAttribute()
    {
        return 'Rp ' . number_format($this->penerimaan_bersih, 0, ',', '.');
    }

    public function getPenerimaanBersihTabunganFormattedAttribute()
    {
        return 'Rp ' . number_format($this->penerimaan_bersih_tabungan, 0, ',', '.');
    }

    public function getTotalPenerimaanBersihAttribute()
    {
        $total = ($this->penerimaan_bersih ?? 0) + ($this->penerimaan_bersih_tabungan ?? 0);
        return 'Rp ' . number_format($total, 0, ',', '.');
    }

}
