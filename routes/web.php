<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\TPasienController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\RiwayatTerjualController;
use App\Http\Controllers\RiwayatMasukController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RiwayatPembayaranController;

// ================== AUTH & HOME ==================
Route::get('/', function () {
    return view('rumah');
})->middleware('guest.redirect'); // Halaman utama
// Hanya admin yang bisa akses
Route::get('/home', [HomeController::class, 'home'])
    ->name('home')
    ->middleware('admin');

// Hanya user yang bisa akses
Route::get('/beranda', [HomeController::class, 'beranda'])
    ->name('beranda')
    ->middleware('user');
// Route::get('/sidebar/home', [HomeController::class, 'home'])->middleware('guest.redirect'); // Duplikat route ke /home

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/prosesLogin', [LoginController::class, 'prosesLogin'])->name('prosesLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/prosesRegister', [LoginController::class, 'prosesRegister'])->name('prosesRegister');

// ================== ADMIN ==================
Route::middleware(['admin'])->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');

    // PASIEN ADMIN
    Route::get('/tambahpasien', [TPasienController::class, 'index'])->name('sidebar.tambahpasien');
    Route::post('/pPasien', [TPasienController::class, 'store'])->name('tpasien.store');

    Route::get('/pasien/antrian', [PasienController::class, 'antrianAdmin'])->name('pasien.antrian');
    Route::get('/antrian', [PasienController::class, 'antrianAdmin']); // Alias
    Route::post('/pasien/antrian', [PasienController::class, 'antrian']);

    Route::get('/pasien/edit/{id}', [PasienController::class, 'editForm'])->name('pasien.edit');
    Route::post('/pasien/edit/{id}', [PasienController::class, 'processEdit'])->name('pasien.update');
    Route::delete('/pasien/delete/{id}', [PasienController::class, 'delete'])->name('pasien.delete');

    Route::get('/pasien/tambah', [PasienController::class, 'index'])->name('pasien.tambah');
    Route::post('/pasien/proses', [PasienController::class, 'prosesPasien'])->name('prosesPasien');

    Route::post('/pasien/konfirmasi/{id}', [PasienController::class, 'konfirmasi'])->name('pasien.konfirmasi');
    Route::post('/pasien/batal/{id}', [PasienController::class, 'batal'])->name('pasien.batal');

    // DETAIL DIAGNOSA
    Route::get('/detail', [DetailController::class, 'index'])->name('detail.index');
    Route::get('detail/edit/{id}', [DetailController::class, 'edit'])->name('detail.edit');
    Route::post('detail/update/{id}', [DetailController::class, 'update'])->name('detail.update');
    Route::get('/print/{id}', [DetailController::class, 'print'])->name('detail.print');
    
    Route::post('/hasil/store', [HasilController::class, 'store'])->name('hasil.store');
    Route::post('/hasil/update/{id}', [HasilController::class, 'update'])->name('hasil.update');
    Route::post('/prosespembayaran', [DetailController::class, 'pembayaran'])->name('pembayaran.proses');

    // OBAT
    Route::prefix('obat')->group(function () {
        Route::get('/', [ObatController::class, 'index'])->name('obat.index');
        Route::get('/create', [ObatController::class, 'create'])->name('obat.create');
        Route::post('/store', [ObatController::class, 'store'])->name('obat.store');
        Route::get('/edit/{id}', [ObatController::class, 'edit'])->name('obat.edit');
        Route::post('/update', [ObatController::class, 'update'])->name('obat.update');
        Route::delete('/delete/{id}', [ObatController::class, 'delete'])->name('obat.delete');
        Route::get('/terjual/{id}', [ObatController::class, 'terjual'])->name('obat.terjual');
    });

    Route::get('/masuk', [ObatController::class, 'create']);
    Route::post('/obat', [ObatController::class, 'index']);

    // RIWAYAT
    Route::get('/riwayat', [RiwayatTerjualController::class, 'index'])->name('riwayat.terjual');
    Route::get('/obatmasuk', [RiwayatMasukController::class, 'obatmasuk'])->name('riwayat.masuk');
    Route::post('/riwayat/searchTerjual', [RiwayatTerjualController::class, 'searchTerjual'])->name('riwayat.search.terjual');
    Route::post('/riwayat/searchMasuk', [RiwayatMasukController::class, 'searchMasuk'])->name('riwayat.search.masuk');

    // PEMBAYARAN
    // Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    // Route::post('/pembayaran', [PembayaranController::class, 'index']);
    // Route::get('/pembayaran/detail/{id}', [PembayaranController::class, 'getDetail'])->name('pembayaran.detail');
    // Route::get('/pembayaran/riset/{id}', [PembayaranController::class, 'riset'])->name('pembayaran.reset');

    // RIWAYAT PEMBAYARAN
    Route::get('/riwayatpembayaran', [RiwayatPembayaranController::class, 'index'])->name('riwayatpembayaran.index');
    Route::get('/riwayat_pembayaran/detail/{id}', [RiwayatPembayaranController::class, 'detail'])->name('riwayatpembayaran.detail');
    Route::get('/riwayatpembayaran/markAsPaid/{id}', [RiwayatPembayaranController::class, 'markAsPaid'])->name('riwayatpembayaran.mark');
    Route::get('/riwayatpembayaran/hapus/{id}', [PembayaranController::class, 'hapusData'])->name('riwayatpembayaran.delete');

    // ROUTE TOGGLE
    Route::post('/admin/toggle-pendaftaran', [PasienController::class, 'togglePendaftaran'])->name('admin.togglePendaftaran');

    // RIWAYAT DATA PASIEN
    Route::get('/riwayatpasien', [RiwayatController::class, 'index'])->name('riwayat.pasien');
});

// ================== USER ==================
Route::middleware(['user'])->group(function () {
    Route::get('/beranda', [HomeController::class, 'beranda'])->name('beranda');
    Route::get('/antri', [PasienController::class, 'antrianUser'])->name('antri');
    Route::get('/pasien', [HomeController::class, 'pasien'])->name('home.pasien');
    Route::get('/riwayat', [HomeController::class, 'riwayat'])->name('home.riwayat');

    Route::post('/pasien/proses', [PasienController::class, 'prosesPasienUser'])->name('prosesPasienUser');
    Route::get('/status-pendaftaran', [PasienController::class, 'statusPendaftaran'])->name('status.pendaftaran');
});