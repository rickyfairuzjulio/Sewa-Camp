<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Informasi Penyewaan Alat Camping (CampSewa)
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. RUTE PUBLIK (DAPAT DIAKSES TANPA LOGIN)
// ==========================================
Route::get('/', [PublicController::class, 'beranda'])->name('public.beranda');
Route::get('/katalog', [PublicController::class, 'katalog'])->name('public.katalog');
Route::get('/alat/{id}', [PublicController::class, 'detailAlat'])->name('public.detail');
Route::get('/cara-sewa', [PublicController::class, 'caraSewa'])->name('public.cara_sewa');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('public.kontak');
Route::middleware('auth')->group(function () {
    Route::get('/sewa', [PublicController::class, 'formPermintaanSewa'])->name('public.sewa');
    Route::post('/sewa/simpan', [PublicController::class, 'simpanPermintaanSewa'])->name('public.sewa.simpan');
    Route::get('/sewa/sukses/{id}', [PublicController::class, 'sewaSukses'])->name('public.sewa.sukses');
});
Route::post('/sewa/{penyewaan}/midtrans-token', [MidtransController::class, 'createPublicSnapToken'])->name('public.sewa.midtrans.token');
Route::post('/sewa/{penyewaan}/midtrans-konfirmasi', [MidtransController::class, 'confirmClientPayment'])->name('public.sewa.midtrans.confirm');
Route::post('/midtrans/save-keys', [MidtransController::class, 'saveKeys'])->name('midtrans.save_keys');
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');

// ==========================================
// 2. AUTENTIKASI (LOGIN & LOGOUT)
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:registration')->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// 3. RUTE KHUSUS ADMIN (ROLE: ADMIN)
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

    // Manajemen Kategori Alat
    Route::resource('kategori', KategoriController::class)->except(['create', 'show', 'edit']);

    // Manajemen Alat Camping (CRUD Lengkap)
    Route::resource('alat', AlatController::class)->except(['show']);

    // Manajemen Petugas
    Route::resource('petugas', PetugasController::class)->except(['show']);
});

// ==========================================
// 4. RUTE KHUSUS PETUGAS (ROLE: PETUGAS)
// ==========================================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'petugasDashboard'])->name('dashboard');
});

// ==========================================
// 5. RUTE KHUSUS PELANGGAN (ROLE: PELANGGAN)
// ==========================================
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pelangganDashboard'])->name('dashboard');
    Route::get('/transaksi', [DashboardController::class, 'pelangganDashboard'])->name('transaksi');
    Route::post('/pengaturan', [DashboardController::class, 'updatePelangganProfil'])->name('pengaturan.update');
    Route::post('/upgrade-member', [DashboardController::class, 'upgradeMember'])->name('member.upgrade');
    Route::post('/penyewaan/{penyewaan}/batal', [DashboardController::class, 'batalSewaPelanggan'])->name('penyewaan.batal');
    Route::post('/penyewaan/{penyewaan}/midtrans-token', [MidtransController::class, 'createSnapToken'])->name('pembayaran.midtrans.token');
});

// ==========================================
// 6. RUTE OPERASIONAL (ADMIN & PETUGAS)
// ==========================================
Route::middleware(['auth', 'role:admin,petugas'])->prefix('admin')->name('admin.')->group(function () {
    // Manajemen Pelanggan & Verifikasi Member
    Route::resource('pelanggan', PelangganController::class);
    Route::post('/pelanggan/{pelanggan}/verifikasi', [PelangganController::class, 'verify'])->name('pelanggan.verify');

    // Transaksi Penyewaan
    Route::resource('penyewaan', PenyewaanController::class)->except(['edit', 'update', 'destroy']);
    Route::get('/penyewaan/{id}/cetak', [PenyewaanController::class, 'cetak'])->name('penyewaan.cetak');
    Route::post('/penyewaan/{id}/batal', [PenyewaanController::class, 'batal'])->name('penyewaan.batal');

    // Pembayaran
    Route::resource('pembayaran', PembayaranController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('/pembayaran/{id}/kuitansi', [PembayaranController::class, 'cetakKuitansi'])->name('pembayaran.kuitansi');
    Route::post('/penyewaan/{penyewaan}/midtrans-token', [MidtransController::class, 'createSnapToken'])->name('pembayaran.midtrans.token');

    // Pengembalian Alat
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/{id}/proses', [PengembalianController::class, 'proses'])->name('pengembalian.proses');
    Route::post('/pengembalian/{id}/simpan', [PengembalianController::class, 'simpan'])->name('pengembalian.simpan');

    // Laporan Internal
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/alat', [LaporanController::class, 'laporanAlat'])->name('laporan.alat');
    Route::get('/laporan/penyewaan', [LaporanController::class, 'laporanPenyewaan'])->name('laporan.penyewaan');
    Route::get('/laporan/pembayaran', [LaporanController::class, 'laporanPembayaran'])->name('laporan.pembayaran');
    Route::get('/laporan/belum-kembali', [LaporanController::class, 'laporanBelumKembali'])->name('laporan.belum_kembali');
});

Route::get('/run-migration', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $migrateOutput = \Illuminate\Support\Facades\Artisan::output();

        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $seedOutput = \Illuminate\Support\Facades\Artisan::output();

        return "<div style='font-family:sans-serif;padding:20px;max-width:800px;margin:auto;'>
            <h2 style='color:green;'>Migration & Seeder Berhasil!</h2>
            <p>Database TiDB sekarang sudah siap dan terisi data.</p>
            <p><a href='/' style='display:inline-block;padding:10px 20px;background:#10b981;color:white;text-decoration:none;border-radius:5px;'>Buka Beranda CampSewa &rarr;</a></p>
            <h3>Log Output:</h3>
            <pre style='background:#f4f4f4;padding:15px;border-radius:5px;'>{$migrateOutput}\n{$seedOutput}</pre>
        </div>";
    } catch (\Throwable $e) {
        return "<div style='font-family:sans-serif;padding:20px;max-width:800px;margin:auto;'>
            <h2 style='color:red;'>Gagal Migrasi:</h2>
            <pre style='background:#fee;padding:15px;border-radius:5px;'>{$e->getMessage()}\n{$e->getTraceAsString()}</pre>
        </div>";
    }
});

