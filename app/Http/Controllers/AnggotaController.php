<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Str;

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
        $anggota = Anggota::find($id);
        if (!$anggota) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        // Validasi data (sesuaikan rules)
        $validated = $request->validate([
            'nip' => 'nullable|string|max:50',
            'ktp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'nama' => 'required|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'no_hp' => 'nullable|string|max:20',
            'tgl_aktivasi' => 'nullable|date',
            'tgl_keluar' => 'nullable|date',
            'simpanan_wajib' => 'nullable|numeric',
            'provinsi' => 'nullable|string|max:100',
            'kota_alamat' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kelurahan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:500',
            'rekening' => 'nullable|string|max:50',
            'foto' => 'nullable', // karena multiple pakai foto[] di form
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024', // max 1MB per gambar
            'type' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'no_pensiun' => 'nullable|string|max:50',
            'jenis_pensiun' => 'nullable|string|max:50',
        ]);

        // Update atribut selain foto dulu
        $anggota->nip = $validated['nip'] ?? $anggota->nip;
        $anggota->ktp = $validated['ktp'] ?? $anggota->ktp;
        $anggota->email = $validated['email'] ?? $anggota->email;
        $anggota->nama = $validated['nama'];
        $anggota->tgl_lahir = $validated['tgl_lahir'] ?? $anggota->tgl_lahir;
        $anggota->no_hp = $validated['no_hp'] ?? $anggota->no_hp;
        $anggota->tgl_aktivasi = $validated['tgl_aktivasi'] ?? $anggota->tgl_aktivasi;
        $anggota->tgl_keluar = $validated['tgl_keluar'] ?? $anggota->tgl_keluar;
        $anggota->simpanan_wajib = $validated['simpanan_wajib'] ?? $anggota->simpanan_wajib;
        $anggota->provinsi = $validated['provinsi'] ?? $anggota->provinsi;
        $anggota->kota_alamat = $validated['kota_alamat'] ?? $anggota->kota_alamat;
        $anggota->kecamatan = $validated['kecamatan'] ?? $anggota->kecamatan;
        $anggota->kelurahan = $validated['kelurahan'] ?? $anggota->kelurahan;
        $anggota->alamat = $validated['alamat'] ?? $anggota->alamat;
        $anggota->rekening = $validated['rekening'] ?? $anggota->rekening;
        $anggota->type = $validated['type'] ?? $anggota->type;
        $anggota->status = $validated['status'] ?? $anggota->status;
        $anggota->no_pensiun = $validated['no_pensiun'] ?? $anggota->no_pensiun;
        $anggota->jenis_pensiun = $validated['jenis_pensiun'] ?? $anggota->jenis_pensiun;

        // Handle foto multiple update
        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada
            if ($anggota->foto) {
                $oldFotos = json_decode($anggota->foto, true);
                if (is_array($oldFotos)) {
                    foreach ($oldFotos as $oldFoto) {
                        $path = public_path('uploads/anggota' . $oldFoto);
                        if (file_exists($path)) {
                            unlink($path);
                        }
                    }
                }
            }

            $uploadedFiles = $request->file('foto');
            $newFileNames = [];

            foreach ($uploadedFiles as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/anggota'), $filename);
                $newFileNames[] = $filename;
            }

            // Simpan nama file foto baru sebagai JSON
            $anggota->foto = json_encode($newFileNames);
        }

        $anggota->save();

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }



    public function data_history(){

        return view('admin/anggota/history_data', [
            'title' => 'Data History'
        ]);
    }
}
