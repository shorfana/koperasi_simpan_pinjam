<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Anggota;
use App\Models\Pinjaman;
use Carbon\Carbon;

class PinjamanController extends Controller
{
    public function index(){

        $pinjaman = DB::select('SELECT * FROM vw_informasi_pinjaman');
        return view('admin.pinjaman.index', [
            'title' => 'Data Pinjaman',
            'pinjaman' => $pinjaman
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        dd($request);
        try {
            // Cek apakah anggota sudah ada berdasarkan NIK
            $anggota = Anggota::where('ktp', $request->nik)->first();

            // Jika tidak ada, insert anggota baru
            if (!$anggota) {
                $anggota = Anggota::create([
                    'no_anggota'       => $this->generateNoAnggota(),
                    'nip'              => null,
                    'ktp'              => $request->nik,
                    'email'            => null,
                    'nama'             => $request->nama_nasabah,
                    'tgl_lahir'        => $request->tgl_lahir,
                    'nohp'             => $request->nohp,
                    'tgl_aktivasi'     => Carbon::now(),
                    'rekening'         => null,
                    'provinsi'         => $request->provinsi,
                    'kota'             => $request->kota,
                    'kecamatan'        => $request->kecamatan,
                    'kelurahan'        => $request->kelurahan,
                    'alamat'           => $request->alamat,
                    'no_pensiun'       => $request->no_pensiun,
                    'jenis_pensiun'    => $request->jenis_pensiun,
                    'type'             => 'pensiunan',
                    'status'           => 'aktif',
                    'is_deleted'       => '0',
                    'createdon'        => Carbon::now(),
                    'createdby'        => session('user')->name,
                ]);
            }

            //PPerhitungan persentase
            $usia = $this->hitungUsia($request->tgl_lahir, $request->tgl_realisasi);
            $persentase_dpu = $this->hitungPersentaseDPU($request->tgl_lahir, $request->tgl_realisasi);
            $angsuran = $this->hitungCicilan($request->nominal_pinjaman, $request->lama_pinjaman);
            $penerimaan_bersih = $this->hitungPenerimaanBersih(
                $request->nominal_pinjaman,
                $request->tgl_lahir,
                $request->tgl_realisasi,
                $request->lama_pinjaman,
                $request->tabungan ?? 0
            );
            $sisa_gaji = $request->gaji_awal - $angsuran;
            $persentase_provisi = $this->hitungPersentaseProvisi($request->lama_pinjaman);
            $provisi = $this->hitungProvisi($request->nominal_pinjaman, $request->lama_pinjaman);
            $dpu_asuransi = $this->hitungDPU($request->nominal_pinjaman, $request->tgl_lahir, $request->tgl_realisasi);
            $jasa_pelayanan = round($this->hitungJasa($request->nominal_pinjaman));
            $buku_anggota = $this->hitungBuku();
            $materai = $this->hitungMaterai();
            //End perhitungan persentase
            // Insert ke tabel Pinjaman
            Pinjaman::create([
                'kode_pinjaman'               => $this->generateKodePinjaman(),
                'tanggal'                     => Carbon::now(),
                'jenis_kode_kas'              => $this->generateKodeKas(),
                'no_anggota'                  => $anggota->no_anggota,
                'nominal_pinjaman'            => $request->nominal_pinjaman,
                'tgl_jatuh_tempo'             => Carbon::parse($request->tgl_realisasi)->addMonths($request->lama_pinjaman),
                'tgl_realisasi'               => $request->tgl_realisasi,
                'keterangan'                  => $request->keterangan ?? null,
                'bulan'                       => $request->lama_pinjaman,
                'cicilan_perbulan'            => $this->hitungCicilan($request->nominal_pinjaman, $request->lama_pinjaman),
                'status'                      => 'aktif',
                'createdon'                   => Carbon::now(),
                'createdby'                   => session('user')->name,
                'is_deleted'                  => '0',

                // Kolom tambahan perhitungan berdasarkan tgl_lahir anggota
                // Simpan angka murni (int)
                'usia_masuk'                => $usia,
                'persentase_dpu'            => $persentase_dpu,
                'dpu_asuransi'              => $dpu_asuransi,
                'jasa_pelayanan'            => $jasa_pelayanan,
                'buku_anggota'              => $buku_anggota,
                'materai'                   => $materai,
                'persentase_provisi'        => $persentase_provisi,
                'provisi'                   => $provisi,
                'angsuran_per_bulan'        => $angsuran,
                'penerimaan_bersih'         => $penerimaan_bersih,
                'tanggal_lunas'             => Carbon::parse($request->tgl_realisasi)->addMonths($request->lama_pinjaman)->format('Y-m-d'),
                'penerimaan_bersih_tabungan'=> $penerimaan_bersih + ($request->tabungan ?? 0),
            ]);

            DB::commit();
            return back()->with('success', 'Pinjaman berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function generateKodeKas()
    {
        $lastKas = DB::table('pinjaman')
            ->where('jenis_kode_kas', 'like', 'KAS%')
            ->orderByDesc('jenis_kode_kas')
            ->value('jenis_kode_kas');

        if ($lastKas) {
            $lastNumber = (int) substr($lastKas, 3); // Ambil angka setelah 'KAS'
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return 'KAS' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }


    private function generateNoAnggota()
    {
        $last = Anggota::max('no_anggota');
        return $last ? $last + 1 : 10001;
    }

    private function generateKodePinjaman()
    {
        $last = Pinjaman::max('kode_pinjaman');
        return $last ? $last + 1 : 20001;
    }


    public function searchNasabah(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $keywordLower = strtolower($keyword);

        $results = \DB::table('anggota as a')
            ->leftJoin('pinjaman as p', 'a.no_anggota', '=', 'p.no_anggota')
            ->where(function($query) use ($keyword) {
                $query->whereRaw('LOWER(a.nama) LIKE ?', ['%' . strtolower($keyword) . '%']);
            })
            ->where(function($query) {
                $query->where('p.status', '1')
                    ->orWhereNull('p.no_anggota');
            })
            ->select('a.nama', 'a.ktp')
            ->distinct()
            ->limit(10)
            ->get();

        return response()->json($results);
    }

    public function GetAnggotaByKtp(Request $request)
    {
        $ktp = $request->query('ktp');

        if (!$ktp) {
            return response()->json(['message' => 'KTP tidak boleh kosong'], 400);
        }

        $data = Anggota::where('ktp', $ktp)
            ->select(
                'ktp',
                'nama',
                'tgl_lahir',
                'nohp',
                'provinsi',
                'kota',
                'kecamatan',
                'kelurahan',
                'alamat',
                'no_pensiun',
                'jenis_pensiun'
            )
            ->first();

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    // private function hitungCicilan($plafond, $bulan)
    // {
    //     return round($plafond / $bulan);
    // }

    // private function hitungPersentaseDPU($tgl_lahir)
    // {
    //     $usia = Carbon::now()->diffInYears(Carbon::parse($tgl_lahir));
    //     return $usia > 15 ? (10 + ($usia - 15)) : 10;
    // }

    // private function hitungDPU($plafond, $tgl_lahir)
    // {
    //     $persen = $this->hitungPersentaseDPU($tgl_lahir);
    //     return ($persen / 100) * $plafond;
    // }

    // private function hitungPersentaseProvisi($lama_pinjaman)
    // {
    //     return $lama_pinjaman <= 12 ? 5 : (5 + (($lama_pinjaman - 12) * 0.5));
    // }

    // private function hitungProvisi($plafond, $lama_pinjaman)
    // {
    //     return $this->hitungPersentaseProvisi($lama_pinjaman) / 100 * $plafond;
    // }

    // private function hitungPenerimaanBersih($plafond, $tgl_lahir, $lama_pinjaman)
    // {
    //     $dpu       = $this->hitungDPU($plafond, $tgl_lahir);
    //     $jasa      = round(0.0356 * $plafond);
    //     $buku      = 10000;
    //     $materai   = 10000;
    //     $provisi   = $this->hitungProvisi($plafond, $lama_pinjaman);

    //     return $plafond - $dpu - $jasa - $buku - $materai - $provisi;
    // }
    public function hitungUsia($tgl_lahir, $tgl_realisasi)
    {
        return Carbon::parse($tgl_realisasi)->diffInYears(Carbon::parse($tgl_lahir));
    }

    public function hitungPersentaseDPU($tgl_lahir, $tgl_realisasi)
    {
        $usia = $this->hitungUsia($tgl_lahir, $tgl_realisasi);
        if ($usia <= 75) {
            return 10;
        }
        return 10 + (($usia - 75) * 1);
    }

    public function hitungDPU($plafond, $tgl_lahir, $tgl_realisasi)
    {
        $persentase_dpu = $this->hitungPersentaseDPU($tgl_lahir, $tgl_realisasi);
        return $plafond * ($persentase_dpu / 100);
    }

    public function hitungJasa($plafond)
    {
        return 0.035 * $plafond;
    }

    public function hitungBuku()
    {
        return 15000;
    }

    public function hitungMaterai()
    {
        return 10000;
    }

    public function hitungPersentaseProvisi($tenor)
    {
        if ($tenor <= 12) {
            return 5;
        }
        return 5 + (($tenor - 12) * 0.5);
    }

    public function hitungProvisi($plafond, $tenor)
    {
        $persen_provisi = $this->hitungPersentaseProvisi($tenor);
        return $plafond * ($persen_provisi / 100);
    }

    public function hitungCicilan($plafond, $tenor)
    {
        // angsuran flat bunga 3% + admin 5rb
        return round((($plafond / $tenor) + ($plafond * 0.03)) + 5000);
    }

    public function hitungPenerimaanBersih($plafond, $tgl_lahir, $tgl_realisasi, $tenor, $tabungan = 0)
    {
        $dpu = $this->hitungDPU($plafond, $tgl_lahir, $tgl_realisasi);
        $jasa = $this->hitungJasa($plafond);
        $buku = $this->hitungBuku();
        $materai = $this->hitungMaterai();
        $provisi = $this->hitungProvisi($plafond, $tenor);

        return $plafond - $dpu - $jasa - $buku - $materai - $provisi - $tabungan;
    }

    public function prosesSimulasi($request)
    {
        $usia = $this->hitungUsia($request->tgl_lahir, $request->tgl_realisasi);
        $persentase_dpu = $this->hitungPersentaseDPU($request->tgl_lahir, $request->tgl_realisasi);
        $angsuran = $this->hitungCicilan($request->nominal_pinjaman, $request->lama_pinjaman);
        $penerimaan_bersih = $this->hitungPenerimaanBersih(
            $request->nominal_pinjaman,
            $request->tgl_lahir,
            $request->tgl_realisasi,
            $request->lama_pinjaman,
            $request->tabungan ?? 0
        );
        $sisa_gaji = $request->gaji_awal - $angsuran;

        return [
            'persentase_dpu'              => $persentase_dpu . '%',
            'usia_masuk'                  => $usia . ' TAHUN',
            'angsuran_per_bulan'          => 'Rp ' . number_format($angsuran, 0, ',', '.'),
            'sisa_gaji'                   => 'Rp ' . number_format($sisa_gaji, 0, ',', '.'),
            'penerimaan_bersih'           => 'Rp ' . number_format($penerimaan_bersih, 0, ',', '.'),
            'dpu_asuransi'                => 'Rp ' . number_format($this->hitungDPU($request->nominal_pinjaman, $request->tgl_lahir, $request->tgl_realisasi), 0, ',', '.'),
            'jasa_pelayanan'              => 'Rp ' . number_format(round($this->hitungJasa($request->nominal_pinjaman)), 0, ',', '.'),
            'buku_anggota'                => 'Rp ' . number_format($this->hitungBuku(), 0, ',', '.'),
            'materai'                    => 'Rp ' . number_format($this->hitungMaterai(), 0, ',', '.'),
            'persentase_provisi'          => $this->hitungPersentaseProvisi($request->lama_pinjaman) . '%',
            'provisi'                    => 'Rp ' . number_format($this->hitungProvisi($request->nominal_pinjaman, $request->lama_pinjaman), 0, ',', '.'),
            'tanggal_lunas'              => Carbon::parse($request->tgl_realisasi)->addMonths($request->lama_pinjaman)->format('d/m/Y'),
            'penerimaan_bersih_tabungan' => 'Rp ' . number_format($penerimaan_bersih + ($request->tabungan ?? 0), 0, ',', '.'),
        ];
    }



}
