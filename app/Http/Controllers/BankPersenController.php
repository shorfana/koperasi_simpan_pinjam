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
            'dpu' => 'required|integer',
            'angsuran' => 'required|integer',
            'jasa' => 'required|integer',
            'provisi' => 'required|integer',
        ]);

        $bankPersen = BankPersen::create($data);

        return back()->with('success', 'Bank Persen berhasil ditambahkan');
    }

    public function show()
    {
        $bank_persen = BankPersen::all(); // Ambil semua data dari tabel bank_persen
        // return view('admin.bank_persen.index', compact('bank_persen'));
        // dd($bank_persen);
        return view('admin.bank_persen.index', [
            'title' => 'Data Bank Persen',
            'bank_persens' => $bank_persen
        ]);
    }

    public function update(Request $request, BankPersen $bankPersen)
    {
        // dd($request);
        $data = $request->validate([
            'dpu' => 'required|integer',
            'angsuran' => 'required|integer',
            'jasa' => 'required|integer',
            'provisi' => 'required|integer',
        ]);

        $bankPersen = BankPersen::find($request->id); // cari berdasarkan id dari hidden input

        if (!$bankPersen) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $bankPersen->update($data);

        return back()->with('success', 'Bank Persen berhasil Diubah');
    }

    public function destroy(BankPersen $bankPersen)
    {
        $bankPersen->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
