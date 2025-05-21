<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File; // Untuk menghapus file
use App\Models\Item; // Sesuaikan namespace dan nama model Anda
use Illuminate\Support\Facades\Log; // Opsional: untuk logging error
use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
   public function show()
   {
        $anggota = Anggota::where('is_deleted', 0)->get();

        return view('admin.anggota.anggota_data', [
            'title' => 'Data Anggota',
            'anggota' => $anggota
        ]);
   }

    public function store(Request $request)
    {
        // Validasi awal jika diperlukan
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email',
            'foto.*' => 'nullable|image|max:1024', // 1MB per gambar
        ]);

        // Inisialisasi variabel
        $fotoNama = [];

        // Jika ada file foto diunggah
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $fotoFile) {
                $randomName = Str::random(5) . '.' . $fotoFile->getClientOriginalExtension();
                $fotoFile->move(public_path('uploads/anggota'), $randomName);
                $fotoNama[] = $randomName;
            }
        }

        // Simpan ke DB
        Anggota::create([
            'no_anggota' => Anggota::max('no_anggota') + 1,
            'nip' => $request->nip,
            'ktp' => $request->ktp,
            'email' => $request->email,
            'nama' => $request->nama,
            'tgl_lahir' => $request->tgl_lahir,
            'nohp' => $request->no_hp,
            'tgl_aktivasi' => $request->tgl_aktivasi,
            'tgl_keluar' => $request->tgl_keluar,
            'simpanan_wajib' => $request->simpanan_wajib ?? 0,
            'rekening' => $request->rekening,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota_alamat,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'alamat' => $request->alamat,
            'no_pensiun' => $request->no_pensiun,
            'gaji' => $request->gaji,
            'jenis_pensiun' => $request->jenis_pensiun,
            'simpanan_pokok' => $request->simpanan_pokok,
            'foto' => json_encode($fotoNama), // simpan sebagai JSON string
            'type' => $request->type,
            'status' => $request->status,
            'is_deleted' => '0',
            'createdon' => now(),
            'createdby' => auth()->user()->name ?? 'system',
        ]);

        return redirect()->back()->with('success', 'Data anggota berhasil disimpan.');
    }

    public function edit($id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Kalau mau return semua field dalam JSON:
        return response()->json($anggota);
    }

    public function update(Request $request, $id)
    {
        // Temukan anggota berdasarkan ID
        $anggota = Anggota::findOrFail($id);

        // Validasi data yang masuk
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email',
            'foto.*' => 'nullable|image|max:1024', // 1MB per gambar
        ]);

        // Inisialisasi variabel untuk nama foto baru
        $fotoNamaBaru = [];

        // Jika ada file foto baru diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($anggota->foto) {
                $fotoLama = json_decode($anggota->foto);
                foreach ($fotoLama as $namaFile) {
                    if (File::exists(public_path('uploads/anggota/' . $namaFile))) {
                        File::delete(public_path('uploads/anggota/' . $namaFile));
                    }
                }
            }

            // Unggah foto baru
            foreach ($request->file('foto') as $fotoFile) {
                $randomName = Str::random(5) . '.' . $fotoFile->getClientOriginalExtension();
                $fotoFile->move(public_path('uploads/anggota'), $randomName);
                $fotoNamaBaru[] = $randomName;
            }
        } else {
            // Jika tidak ada foto baru diunggah, pertahankan foto lama
            $fotoNamaBaru = json_decode($anggota->foto ?? '[]');
        }

        // Perbarui data anggota
        $anggota->update([
            'nip' => $request->nip,
            'ktp' => $request->ktp,
            'email' => $request->email,
            'nama' => $request->nama,
            'tgl_lahir' => $request->tgl_lahir,
            'nohp' => $request->nohp,
            'tgl_aktivasi' => $request->tgl_aktivasi,
            'tgl_keluar' => $request->tgl_keluar,
            'simpanan_wajib' => $request->simpanan_wajib ?? 0,
            'rekening' => $request->rekening,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'alamat' => $request->alamat,
            'no_pensiun' => $request->no_pensiun,
            'gaji' => $request->gaji,
            'jenis_pensiun' => $request->jenis_pensiun,
            'simpanan_pokok' => $request->simpanan_pokok,
            'foto' => json_encode($fotoNamaBaru), // Simpan sebagai JSON string
            'type' => $request->type,
            'status' => $request->status,
            'updatedon' => now(), // Tambahkan timestamp update
            'updatedby' => auth()->user()->name ?? 'system', // Tambahkan user yang mengupdate
        ]);

        // Periksa apakah permintaan mengharapkan respons JSON (misalnya dari AJAX)
        if ($request->expectsJson()) {
            return response()->json(['success' => 'Data anggota berhasil diperbarui.']);
        }

        return redirect()->back()->with('success', 'Data anggota berhasil diperbarui.');
    }



    public function data_history(){

        return view('admin/anggota/history_data', [
            'title' => 'Data History'
        ]);
    }

    public function softDeleteItem(Request $request, $no_anggota)
    {
        // Validasi data yang diterima
        // Pastikan 'is_deleted' ada di body request dan bernilai 1


        try {
            // Cari anggota berdasarkan no_anggota
            // Karena primaryKey adalah 'no_anggota' dan tidak incrementing,
            // find() akan bekerja dengan baik.
            $anggota = Anggota::find($no_anggota);
            // dd("halo");
            // var_dump("testst");
            if (!$anggota) {
                return response()->json(['message' => 'Data anggota tidak ditemukan.'], 404);
            }
            // Cek apakah anggota masih memiliki pinjaman
            $hasPinjaman = DB::table('anggota as a')
                        ->join('pinjaman as p', 'a.no_anggota', '=', 'p.no_anggota')
                        ->where('a.no_anggota', $no_anggota)
                        ->exists();

            if ($hasPinjaman) {
                return response()->json(['message' => 'Anggota sedang memiliki pinjaman aktif. Harap selesaikan pinjaman terlebih dahulu.', 'anggota' => $anggota], 200);
            }

            // // Update kolom is_deleted menjadi 1
            $anggota->is_deleted = "1";
            $anggota->save(); // Simpan perubahan ke database

            return response()->json(['message' => 'Data anggota berhasil di delete.', 'anggota' => $anggota], 200);

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Kesalahan saat melakukan soft delete anggota: ' . $e->getMessage(), ['no_anggota' => $no_anggota, 'request_body' => $request->all()]);

            return response()->json([
                'message' => 'Terjadi kesalahan server saat menghapus data anggota.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
