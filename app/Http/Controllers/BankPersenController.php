<?php
namespace App\Http\Controllers;

use App\Models\BankPersen;
use Illuminate\Http\Request;

class BankPersenController extends Controller
{
    public function index()
    {
        return response()->json(BankPersen::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'persentase_dpu' => 'required|integer',
            'usia_masuk' => 'required|integer',
            'angsuran_per_bulan' => 'required|integer',
            'penerimaan_bersih' => 'required|integer',
            'dpu_asuransi' => 'required|integer',
            'jasa_pelayanan' => 'required|integer',
            'buku_anggota' => 'required|integer',
            'materai' => 'required|integer',
            'persentase_provinsi' => 'required|integer',
            'provinsi' => 'required|integer',
            'tanggal_lunas' => 'required|date',
            'penerimaan_bersih_tabungan' => 'required|integer',
        ]);

        $bankPersen = BankPersen::create($data);

        return response()->json($bankPersen, 201);
    }

    public function show()
    {
        $bank_persen = BankPersen::all(); // Ambil semua data dari tabel bank_persen
        // return view('admin.bank_persen.index', compact('bank_persen'));
        return view('admin.bank_persen.index', [
            'title' => 'Data Bank Persen',
            'bank_persens' => $bank_persen
        ]);
    }

    public function update(Request $request, BankPersen $bankPersen)
    {
        $data = $request->validate([
            'persentase_dpu' => 'integer',
            'usia_masuk' => 'integer',
            'angsuran_per_bulan' => 'integer',
            'penerimaan_bersih' => 'integer',
            'dpu_asuransi' => 'integer',
            'jasa_pelayanan' => 'integer',
            'buku_anggota' => 'integer',
            'materai' => 'integer',
            'persentase_provinsi' => 'integer',
            'provinsi' => 'integer',
            'tanggal_lunas' => 'date',
            'penerimaan_bersih_tabungan' => 'integer',
        ]);

        $bankPersen->update($data);

        return response()->json($bankPersen);
    }

    public function destroy(BankPersen $bankPersen)
    {
        $bankPersen->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
