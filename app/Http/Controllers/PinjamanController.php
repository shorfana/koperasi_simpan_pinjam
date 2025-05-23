<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BankPersen;
use App\Models\Anggota;
use App\Models\Pinjaman;
use Carbon\Carbon;
use ZipArchive;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan ini diimpor
use Illuminate\Support\Facades\Storage;
use DateTime;
use DateInterval;

class PinjamanController extends Controller
{
    public function index()
    {
        // $pinjaman = DB::select('SELECT * FROM vw_informasi_pinjaman');
        $pinjaman = Pinjaman::with('anggota')->where('is_deleted', '0')->get();
        return view('admin.pinjaman.index', [
            'title' => 'Data Pinjaman',
            'pinjaman' => $pinjaman
        ]);
    }

    public function show_bank()
    {
        $pinjaman = Pinjaman::with('anggota')->get();
        return view('admin.pinjaman.index', [
            'title' => 'Data Pinjaman',
            'pinjaman' => $pinjaman
        ]);
    }

    public function informasiPinjamanB(){
        $pinjaman = Pinjaman::with('anggota')->get();
        return view('admin.pinjaman.index', [
            'title' => 'Data Pinjaman',
            'pinjaman' => $pinjaman
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        // dd($request);
        try {
            // Cek apakah anggota sudah ada berdasarkan NIK
            $anggota = Anggota::where('ktp', $request->nik)->first();
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
                    'gaji'             => $sisa_gaji,
                    'simpanan_pokok'    => $request->simpanan_pokok,
                    'type'             => 'pensiunan',
                    'status'           => 'aktif',
                    'is_deleted'       => '0',
                    'createdon'        => Carbon::now(),
                    'createdby'        => session('user')->name,
                ]);
            }


            //End perhitungan persentase
            // Insert ke tabel Pinjaman
            Pinjaman::create([
                'kode_pinjaman'               => $this->generateKodePinjaman(),
                'tanggal'                     => Carbon::now(),
                'jenis_kode_kas'              => $this->generateKodeKas(),
                'no_anggota'                  => $anggota->no_anggota,
                'nominal_pinjaman'            => $request->nominal_pinjaman,
                // 'pinjaman'                    => $request->pinjaman,
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
                'persentase_provisi'       => $persentase_provisi,
                'provisi'                  => $provisi,
                'angsuran_per_bulan'        => $angsuran,
                'penerimaan_bersih'         => $penerimaan_bersih,
                'tanggal_lunas'             => Carbon::parse($request->tgl_realisasi)->addMonths($request->lama_pinjaman)->format('Y-m-d'),
                'penerimaan_bersih_tabungan'=> $penerimaan_bersih + ($request->tabungan ?? 0),
            ]);

            DB::commit();
            return back()->with('success', 'Pinjaman berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e->getMessage());
            return back()->with('success', 'Terjadi kesalahan: ' . $e->getMessage());
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
            ->leftJoin('pinjaman as p', function($join) {
                $join->on('a.no_anggota', '=', 'p.no_anggota')
                     ->where('p.is_deleted', '0'); // Added condition for pinjaman.is_deleted
            })
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
                'jenis_pensiun',
                'simpanan_pokok',
                'gaji'
            )
            ->first();

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

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

    public function generateBankKwitansiPdf(Request $request, $kode_pinjaman)
    {
        // Ambil data pinjaman berdasarkan kode_pinjaman
        $pinjaman = Pinjaman::with('anggota')->findOrFail($kode_pinjaman);
        $dataAnggota = Anggota::where('no_anggota', $pinjaman->no_anggota)
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
                'jenis_pensiun',
                'simpanan_pokok',
                'gaji',
            )
            ->first();
        $bankPersen = BankPersen::first();
        // Pastikan session('user') ada sebelum mengakses properti 'name'
        $petugasName = session('user')->name ?? 'DIANA';

        // dd($bankPersen->dpu);
        //perhitungan penurunan diskon
        $plafond = $pinjaman->nominal_pinjaman;
        $tenor = $pinjaman->bulan; //lama pinjaman
        $tgl_lahir = $dataAnggota->tgl_lahir;
        $tgl_realisasi = (new DateTime($pinjaman->tgl_lunas))->sub(new DateInterval('P' . $pinjaman->bulan . 'M'))->format('Y-m-d H:i:s');;
        $tabungan = $dataAnggota->simpanan_pokok ?? 0;

        // Asli (tanpa diskon)
        $angsuran_asli = $this->hitungCicilan($plafond, $tenor);
        $dpu_asli = $this->hitungDPU($plafond, $tgl_lahir, $tgl_realisasi);
        $jasa_asli = $this->hitungJasa($plafond);
        $provisi_asli = $this->hitungProvisi($plafond, $tenor);
        $materai = $this->hitungMaterai();
        $buku = $this->hitungBuku();

        // Persentase diskon
        $diskon_angsuran = $bankPersen->angsuran/100; // 5%
        $diskon_dpu = $bankPersen->dpu/100; // 10%
        $diskon_jasa = $bankPersen->jasa/100; // 15%
        $diskon_provisi = $bankPersen->provisis/100; // 5%

        // Setelah diskon
        $angsuran = $angsuran_asli * (1 - $diskon_angsuran);
        $dpu = $dpu_asli * (1 - $diskon_dpu);
        $jasa = $jasa_asli * (1 - $diskon_jasa);
        $provisi = $provisi_asli * (1 - $diskon_provisi);
        // Penerimaan bersih
        $penerimaan_bersih = $plafond - $dpu - $jasa - $buku - $materai - $provisi - $tabungan;

        // Data untuk kwitansi
        $data = [
            'nama_petugas' => $petugasName,
            'nama_nasabah' => $pinjaman->nama_nasabah,
            'nik' => $pinjaman->nik_nasabah,
            'tgl_lahir' => $pinjaman->tgl_lahir_nasabah,
            'usia' => $pinjaman->usia_nasabah,
            'no_pensiun' => $pinjaman->no_pensiun_nasabah,
            'jenis_pensiun' => $pinjaman->jenis_pensiun_nasabah,
            'gaji_awal_sebelum_pot_hbm' => 'Rp ' . number_format(200400, 0, ',', '.'),
            'alamat' => $pinjaman->alamat_lengkap_nasabah,
            'no_hp' => $pinjaman->nohp_nasabah,
            'tanggal_realisasi' => $pinjaman->tanggal_realisasi_formatted,
            'angsuran' => 'Rp ' . number_format($angsuran, 0, ',', '.'),
            'sisa_gaji' => 'Rp ' . number_format($dataAnggota->sismpanan_pokok, 0, ',', '.'),
            'tanggal_lunas' => $pinjaman->tanggal_lunas_formatted,
            'plafond' => $pinjaman->nominal_pinjaman_formatted,
            'tenor' => $pinjaman->bulan . ' BULAN',
            'provisi_biaya' => 'Rp ' . number_format($provisi, 0, ',', '.'),
            'dpu_asuransi' => 'Rp ' . number_format($dpu, 0, ',', '.'),
            'jasa_pelayanan' => 'Rp ' . number_format($jasa, 0, ',', '.'),
            'buku_anggota' => 'Rp ' . number_format($buku, 0, ',', '.'),
            'materai_biaya' => 'Rp ' . number_format($materai, 0, ',', '.'),
            'sisa_hutang' => 'Rp -',
            'penerimaan_bersih' => 'Rp ' . number_format($penerimaan_bersih, 0, ',', '.'),
            'pengambilan_tabungan_lama' => 'Rp ' . number_format($dataAnggota->simpanan_pokok, 0, ',', '.'),
            'penerimaan_bersih_tab' => 'Rp ' . number_format($penerimaan_bersih + $dataAnggota->simpanan_pokok, 0, ',', '.'),
            'current_date' => Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y'),
            'petugas_name' => $petugasName,
            'nasabah_name' => $pinjaman->nama_nasabah,
            'nik_nasabah_kwitansi' => $pinjaman->nik_nasabah,
            'simpanan_pokok' => $dataAnggota->simpanan_pokok,
        ];

        // Buat PDF dari view
        $pdf = Pdf::loadView('admin.pinjaman.kwitansi_template', $data);
        $dateNow = Carbon::now();
        // Unduh PDF
        return $pdf->download('kwitansi_pinjaman_' . $dataAnggota->nama .'_'. $dateNow .'.pdf');
    }

    public function generateKwitansiPdf(Request $request, $kode_pinjaman)
    {
        // Ambil data pinjaman berdasarkan kode_pinjaman
        $pinjaman = Pinjaman::with('anggota')->findOrFail($kode_pinjaman);
        // dd($pinjaman);
        $dataAnggota = Anggota::where('no_anggota', $pinjaman->no_anggota)
            ->select(
                'ktp',
                'simpanan_pokok',
                'gaji'
            )
            ->first();
        // Pastikan session('user') ada sebelum mengakses properti 'name'
        $petugasName = session('user')->name ?? 'DIANA';

        // Data untuk kwitansi
        $data = [
            'nama_petugas' => $petugasName,
            'nama_nasabah' => $pinjaman->nama_nasabah,
            'nik' => $pinjaman->nik_nasabah,
            'tgl_lahir' => $pinjaman->tgl_lahir_nasabah,
            'usia' => $pinjaman->usia_nasabah,
            'no_pensiun' => $pinjaman->no_pensiun_nasabah,
            'jenis_pensiun' => $pinjaman->jenis_pensiun_nasabah,
            'gaji_awal_sebelum_pot_hbm' => 'Rp ' . number_format(200400, 0, ',', '.'),
            'alamat' => $pinjaman->alamat_lengkap_nasabah,
            'no_hp' => $pinjaman->nohp_nasabah,
            'tanggal_realisasi' => $pinjaman->tanggal_realisasi_formatted,
            'angsuran' => $pinjaman->cicilan_perbulan_formatted,
            'sisa_gaji' => 'Rp ' . number_format($dataAnggota->gaji, 0, ',', '.'),
            'tanggal_lunas' => $pinjaman->tanggal_lunas_formatted,
            'plafond' => $pinjaman->nominal_pinjaman_formatted,
            'tenor' => $pinjaman->bulan . ' BULAN',
            'provisi_biaya' => $pinjaman->provisi_formatted,
            'dpu_asuransi' => $pinjaman->dpu_asuransi_formatted,
            'jasa_pelayanan' => $pinjaman->jasa_pelayanan_formatted,
            'buku_anggota' => $pinjaman->buku_anggota_formatted,
            'materai_biaya' => $pinjaman->materai_formatted,
            'sisa_hutang' => 'Rp -',
            'penerimaan_bersih' => $pinjaman->penerimaan_bersih_formatted,
            'pengambilan_tabungan_lama' => 'Rp ' . number_format($dataAnggota->simpanan_pokok, 0, ',', '.'),
            'penerimaan_bersih_tab' => 'Rp ' . number_format($pinjaman->penerimaan_bersih_tabungan + $dataAnggota->simpanan_pokok, 0, ',', '.'),
            'current_date' => Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y'),
            'petugas_name' => $petugasName,
            'nasabah_name' => $pinjaman->nama_nasabah,
            'nik_nasabah_kwitansi' => $pinjaman->nik_nasabah,
            'simpanan_pokok' => $dataAnggota->simpanan_pokok,
        ];

        // Buat PDF dari view
        $pdf = Pdf::loadView('admin.pinjaman.kwitansi_template', $data);
        $datePrint = Carbon::now();
        // Unduh PDF
        return $pdf->download('kwitansi_pinjaman_' . $pinjaman->nama_nasabah .'_'. $datePrint .'.pdf');
    }

    public function generateMultipleKwitansiPdf(Request $request)
    {
        $selectedKodePinjaman = $request->input('kode_pinjaman');

        if (empty($selectedKodePinjaman)) {
            return response()->json(['message' => 'Tidak ada pinjaman yang dipilih.'], 400);
        }

        $pinjamanItems = Pinjaman::with('anggota')->whereIn('kode_pinjaman', $selectedKodePinjaman)->get();

        $zipFileName = 'kwitansi_pinjaman_' . Carbon::now()->format('YmdHis') . '.zip';
        $zipPath = Storage::path($zipFileName);
        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($pinjamanItems as $pinjaman) {
                $petugasName = session('user')->name ?? 'DIANA'; // Pastikan ini juga ada

                $data = [
                    'nama_petugas' => $petugasName,
                    'nama_nasabah' => $pinjaman->nama_nasabah,
                    'nik' => $pinjaman->nik_nasabah,
                    'tgl_lahir' => $pinjaman->tgl_lahir_nasabah,
                    'usia' => $pinjaman->usia_nasabah,
                    'no_pensiun' => $pinjaman->no_pensiun_nasabah,
                    'jenis_pensiun' => $pinjaman->jenis_pensiun_nasabah,
                    'gaji_awal_sebelum_pot_hbm' => 'Rp ' . number_format(200400, 0, ',', '.'),
                    'alamat' => $pinjaman->alamat_lengkap_nasabah,
                    'no_hp' => $pinjaman->nohp_nasabah,
                    'tanggal_realisasi' => $pinjaman->tanggal_realisasi_formatted,
                    'angsuran' => $pinjaman->cicilan_perbulan_formatted,
                    'sisa_gaji' => 'Rp ' . number_format(52067, 0, ',', '.'),
                    'tanggal_lunas' => $pinjaman->tanggal_lunas_formatted,
                    'plafond' => $pinjaman->nominal_pinjaman_formatted,
                    'tenor' => $pinjaman->bulan . ' BULAN',
                    'provisi_biaya' => $pinjaman->provisi_formatted,
                    'dpu_asuransi' => $pinjaman->dpu_asuransi_formatted,
                    'jasa_pelayanan' => $pinjaman->jasa_pelayanan_formatted,
                    'buku_anggota' => $pinjaman->buku_anggota_formatted,
                    'materai_biaya' => $pinjaman->materai_formatted,
                    'sisa_hutang' => 'Rp -',
                    'penerimaan_bersih' => $pinjaman->penerimaan_bersih_formatted,
                    'pengambilan_tabungan_lama' => $pinjaman->penerimaan_bersih_tabungan_formatted,
                    'penerimaan_bersih_tab' => $pinjaman->total_penerimaan_bersih,
                    'current_date' => Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y'),
                    'petugas_name' => $petugasName,
                    'nasabah_name' => $pinjaman->nama_nasabah,
                    'nik_nasabah_kwitansi' => $pinjaman->nik_nasabah,
                ];

                // Buat PDF untuk setiap kwitansi
                $pdf = Pdf::loadView('admin.pinjaman.kwitansi_template', $data);
                $pdfContent = $pdf->output(); // Ambil konten PDF
                
                $datePrint = Carbon::now();
                // Tambahkan konten PDF ke dalam zip
                $zip->addFromString('kwitansi_' . $pinjaman->nama_nasabah . '_' . $datePrint . '.pdf', $pdfContent);
            }
            $zip->close();

            // Unduh file zip
            return response()->download($zipPath)->deleteFileAfterSend(true);
        } else {
            return response()->json(['message' => 'Gagal membuat file zip.'], 500);
        }
    }

    public function edit($no_anggota)
    {
        // Menggunakan relasi 'anggota' untuk memuat data anggota terkait
        $pinjaman = Pinjaman::with('anggota')->where('no_anggota', $no_anggota)->first();

        if (!$pinjaman) {
            return response()->json(['message' => 'Data pinjaman tidak ditemukan'], 404);
        }

        // Ketika $pinjaman di-toArray(), accessor akan otomatis dijalankan dan
        // data dari accessor akan ditambahkan ke array.
        $data = $pinjaman->toArray();

        // Beberapa data anggota perlu diakses langsung dari relasi jika tidak ada accessor spesifik
        // atau jika accessor mengembalikan format yang berbeda dari yang dibutuhkan modal
        // Contoh: Untuk NIP, karena Anda menambahkan input `nip_anggota`
        if ($pinjaman->anggota) {
            $data['anggota'] = $pinjaman->anggota->toArray(); // Sertakan seluruh data anggota untuk akses langsung
        } else {
            $data['anggota'] = []; // Pastikan ada array kosong jika anggota tidak ditemukan
        }

        // Format tanggal jika diperlukan (accssor di model Anda sudah memformatnya, jadi mungkin tidak perlu lagi di sini)
        // Jika Anda ingin tanggal di modal dalam format YYYY-MM-DD untuk input type="date"
        // Maka accessor Anda harus mengembalikan format itu, atau kita format ulang di sini.
        // Berdasarkan accessor Anda: getTglLahirNasabahAttribute() mengembalikan 'd F Y', jadi kita perlu penyesuaian di JS.
        // Untuk input type="date", format YYYY-MM-DD dibutuhkan.

        return response()->json($data);
    }

    public function update(Request $request, $kode_pinjaman)
    {
        dd($request);
        DB::beginTransaction();
        try {
            // Validasi data input
            $validatedData = $request->validate([
                'nominal_pinjaman' => 'required|numeric',
                'lama_pinjaman' => 'required|integer', // 'bulan' di model Pinjaman
                'tgl_realisasi' => 'required|date', // 'tanggal' di model Pinjaman
                'pengambilan_tabungan' => 'nullable|numeric',
                'keterangan' => 'nullable|string|max:255',
                'jaminan' => 'nullable|string|max:255', // Sesuaikan dengan tipe data di DB
                'nik' => 'required|string', // Untuk mencari anggota
            ]);

            // Temukan pinjaman yang akan diperbarui
            $pinjaman = Pinjaman::where('kode_pinjaman', $kode_pinjaman)->firstOrFail();

            // Ambil data anggota terkait untuk perhitungan
            $anggota = Anggota::where('ktp', $validatedData['nik'])->firstOrFail();

            // Lakukan perhitungan ulang berdasarkan data input yang baru
            $usia = $this->hitungUsia($anggota->tgl_lahir, $validatedData['tgl_realisasi']);
            $persentase_dpu = $this->hitungPersentaseDPU($anggota->tgl_lahir, $validatedData['tgl_realisasi']);
            $angsuran = $this->hitungCicilan($validatedData['nominal_pinjaman'], $validatedData['lama_pinjaman']);
            $penerimaan_bersih = $this->hitungPenerimaanBersih(
                $validatedData['nominal_pinjaman'],
                $anggota->tgl_lahir,
                $validatedData['tgl_realisasi'],
                $validatedData['lama_pinjaman'],
                $validatedData['pengambilan_tabungan'] ?? 0
            );
            $sisa_gaji = $anggota->gaji - $angsuran; // Menggunakan gaji dari anggota
            $persentase_provisi = $this->hitungPersentaseProvisi($validatedData['lama_pinjaman']);
            $provisi = $this->hitungProvisi($validatedData['nominal_pinjaman'], $validatedData['lama_pinjaman']);
            $dpu_asuransi = $this->hitungDPU($validatedData['nominal_pinjaman'], $anggota->tgl_lahir, $validatedData['tgl_realisasi']);
            $jasa_pelayanan = round($this->hitungJasa($validatedData['nominal_pinjaman']));
            $buku_anggota = $this->hitungBuku();
            $materai = $this->hitungMaterai();


            // Update data pinjaman
            $pinjaman->update([
                'nominal_pinjaman' => $validatedData['nominal_pinjaman'],
                'bulan' => $validatedData['lama_pinjaman'],
                'tgl_realisasi' => $validatedData['tgl_realisasi'],
                'keterangan' => $validatedData['keterangan'],
                'jaminan' => $validatedData['jaminan'], // Jika jaminan bisa diedit
                'modifiedby' => session('user')->name,
                'modifiedon' => now(),

                // Update hasil perhitungan
                'usia_masuk' => $usia,
                'persentase_dpu' => $persentase_dpu,
                'dpu_asuransi' => $dpu_asuransi,
                'jasa_pelayanan' => $jasa_pelayanan,
                'buku_anggota' => $buku_anggota,
                'materai' => $materai,
                'persentase_provisi' => $persentase_provisi,
                'provisi' => $provisi,
                'angsuran_per_bulan' => $angsuran,
                'penerimaan_bersih' => $penerimaan_bersih,
                'tanggal_lunas' => Carbon::parse($validatedData['tgl_realisasi'])->addMonths($validatedData['lama_pinjaman'])->format('Y-m-d'),
                'penerimaan_bersih_tabungan' => $penerimaan_bersih + ($validatedData['pengambilan_tabungan'] ?? 0),
            ]);

            // Update gaji anggota (karena sisa_gaji dihitung dari gaji_awal - angsuran)
            $anggota->update([
                'gaji' => $sisa_gaji,
                'simpanan_pokok' => $validatedData['pengambilan_tabungan'] ?? $anggota->simpanan_pokok, // Update simpanan pokok jika ada perubahan pengambilan tabungan
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data pinjaman berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate pinjaman: ' . $e->getMessage());
        }
    }

    public function delete($pinjaman)
    {
        // dd($pinjaman);
        try {
            Pinjaman::where('kode_pinjaman', $pinjaman)->update(['is_deleted' => '1']);
            return redirect()->back()->with('success', 'Data anggota berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'Data anggota gagal dihapus.');
        }
    }

}


