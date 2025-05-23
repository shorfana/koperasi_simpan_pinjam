<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\BankPersenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/dashboard', [DashboardController::class, 'show']);
// Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
// Route yang butuh login session

Route::middleware(['user.session'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::controller(AnggotaController::class)->group(function () {
        Route::get('/anggota-data', 'show');
        Route::get('/history-data', 'data_history');
        Route::post('/anggota', 'store')->name('anggota.store'); // ✅ Tambahkan ini
        Route::put('/anggota/{id}', 'update')->name('anggota.update');
        Route::get('/anggota/{id}/edit', 'edit')->name('anggota.edit');
        // Route::put('/anggota-delete/{id}','softDeleteItem')->name('anggota-delete.softDeleteItem'); //[ItemController::class, 'softDeleteItem']);


    });
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');            // Tampilkan semua user
        Route::post('/users', 'store')->name('users.store');           // Simpan user baru
        Route::post('/users-update', 'update')->name('users.update');   // Update user
        Route::delete('/users/{user}', 'destroy')->name('users.destroy'); // Hapus user
    });
    Route::controller(PinjamanController::class)->group(function () {
        Route::get('/pinjaman', 'index');  // Tampilkan semua pinjaman
        Route::get('/informasi-pinjaman', 'show_bank');  // Tampilkan semua pinjaman
        Route::get('/informasi-pinjaman', 'informasiPinjamanB');  // Tampilkan semua pinjaman
        Route::post('/pinjaman', 'store')->name('pinjaman.store');  // Simpan pinjaman baru

        // Tambahan route search nasabah dan get anggota by ktp
        // Route::get('/pinjaman/search-nasabah', 'searchNasabah')->name('pinjaman.searchNasabah');
        // Route::get('/pinjaman/get-anggota-by-ktp', 'GetAnggotaByKtp')->name('pinjaman.GetAnggotaByKtp');
    });
    Route::controller(BankPersenController::class)->group(function () {
        Route::get('/bank-persen', 'show')->name('bank-persen.show');
        Route::post('/bank-persen', 'store')->name('bank-persen.store');
        // Route::post('/bankpersen/update', 'update')->name('bank-persen.update');
        Route::delete('/bank-persen/delete', 'destroy')->name('bank-persen.destroy');
        // Route::get('/bank-persen', 'show')->name('bank-persen.show');            // Tampilkan semua user
        // Route::post('/bank-persen/update', 'update')->name('bank-persen.update');           // Simpan user baru
        // // Route::post('/users-update', 'update')->name('users.update');   // Update user
        // Route::delete('/bank-persen/delete', 'destroy')->name('bank-persen.destroy'); // Hapus user
    });
});
    Route::post('/bank-persen/update', [BankPersenController::class, 'update'])->name('bank-persen.update');


    Route::get('/pinjaman/searchNasabah', [PinjamanController::class, 'searchNasabah'])->name('pinjaman.searchNasabah');
    Route::get('/pinjaman/GetAnggotaByKtp', [PinjamanController::class, 'GetAnggotaByKtp'])->name('pinjaman.GetAnggotaByKtp');
    // Route untuk generate kwitansi PDF tunggal berdasarkan kode_pinjaman
    Route::get('/pinjaman/kwitansi/{kode_pinjaman}/pdf', [PinjamanController::class, 'generateKwitansiPdf'])->name('pinjaman.kwitansi.single');
    Route::get('/pinjaman/bank_kwitansi/{kode_pinjaman}/pdf', [PinjamanController::class, 'generateBankKwitansiPdf'])->name('pinjaman.kwitansi.single');
    Route::get('/anggota-delete/{id}', [AnggotaController::class, 'delete'])->name('anggota-delete.delete');
    // Route::get('/anggota-delete/{id}', 'softDeleteItem')->name('anggota-delete.softDeleteItem');

    // Route untuk generate kwitansi PDF multiple (zipped) berdasarkan array kode_pinjaman
    Route::post('/pinjaman/kwitansi/multiple/pdf', [PinjamanController::class, 'generateMultipleKwitansiPdf'])->name('pinjaman.kwitansi.multiple');
    Route::get('/pinjaman/{no_anggota}/edit', [PinjamanController::class, 'edit'])->name('pinjaman.edit');

    // Rute untuk mengirim data pembaruan pinjaman dari form modal
    // Ini akan dipanggil saat form di modal disubmit dengan method PUT
    Route::put('/pinjaman/{kode_pinjaman}', [PinjamanController::class, 'update'])->name('pinjaman.update');
    Route::get('/pinjaman/{kode_pinjaman}/delete', [PinjamanController::class, 'delete'])->name('pinjaman.delete');

    Route::get('/users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');

// Route::controller(AuthController::class)->group(function () {
//     Route::get('/login', 'login_show');
//     Route::get('/register', 'register_show');
//     // Route::get('/history-data', 'data_history');
//     // // Route::post('/orders', 'store');
// });
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login_show')->middleware('guest.user')->name('login');
    Route::post('/login', 'login_process')->name('login.process');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('/register', 'register_show')->name('register');
});


//data dashboard
Route::get('/dashboard/loans', [DashboardController::class, 'showMonthlyLoansChart']);
