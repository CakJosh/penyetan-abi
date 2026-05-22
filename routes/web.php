<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Admin\AccountController; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan; // <-- Ini yang bikin kode di bawah tidak merah lagi!

// ==========================================
// 1. RUTE UNTUK USER / PELANGGAN
// ==========================================
Route::get('/', function () {
    return view('menu');
})->name('user.menu');

Route::get('/keranjang', function () {
    return view('keranjang');
})->name('user.keranjang');

// ==========================================
// 2. RUTE UNTUK ADMIN PANEL
// ==========================================

// Tampilan Halaman Login Admin
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('login');

// Proses Data Login Admin
Route::post('/admin/login', function (Request $request) {
    // 1. Validasi input: Memastikan username & password tidak kosong
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ], [
        'username.required' => 'Username wajib diisi.',
        'password.required' => 'Password wajib diisi.',
    ]);

    // 2. Memetakan input 'username' dari form agar dibaca sebagai 'email' di database
    $credentials = [
        'email'    => $request->username, 
        'password' => $request->password
    ];

    // 3. Cek kecocokan data dengan database (Authentication)
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    // 4. JIKA AKUN SALAH: Mengembalikan error ke field 'username' agar ditangkap sempurna oleh $errors->first()
    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->withInput();
});

// Proses Logout Admin
Route::post('/admin/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/admin/login'); 
})->name('logout');

// Dashboard & Laporan Admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); 
})->name('admin.dashboard');

Route::get('/admin/laporan', function () {
    return view('admin.laporan');
})->name('admin.laporan');

// Manajemen Menu - CRUD Otomatis 
Route::resource('admin/menu', MenuController::class)->names('admin.menu');

// Manajemen Akun Admin
Route::get('/admin/akun', [AccountController::class, 'index'])->name('admin.akun.index');
Route::post('/admin/akun', [AccountController::class, 'update'])->name('admin.akun.update');

// ==========================================
// 3. RUTE DARURAT JALANKAN MIGRASI
// ==========================================
Route::get('/jalankan-migrasi-rahasia', function() {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "Selamat Josh, database Penyetan Abi sukses terbuat!";
    } catch (\Exception $e) {
        return "Gagal karena: " . $e->getMessage();
    }
});