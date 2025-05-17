<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Tampilkan semua user
    public function index()
{
    $users = User::all();
    $roles = Role::all(); // Ambil semua data roles

    return view('admin.user.index', compact('users', 'roles'),['title' => 'Data User']);
    // , [
    //         'title' => 'Data Anggota'
    //     ]);
}

    // Tampilkan form tambah user
    public function create()
    {
        return view('users.create');
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Tampilkan form edit
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request)
    {
        // dd($request);
        // Validasi request, ingat untuk 'email' unique harus ignore berdasarkan id dari input
        $validated = $request->validate([
            'id'    => 'required|exists:users,id',  // pastikan id valid dan ada
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($request->id),
            ],
            'password' => 'nullable|string|min:6',
            'role'     => 'required|string',
        ]);

        // Cari user berdasarkan id dari form
        $user = User::findOrFail($validated['id']);

        // Jika password tidak kosong, hash dulu
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);  // hapus supaya tidak update password jadi null
        }

        // Update user
        $user->update($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
