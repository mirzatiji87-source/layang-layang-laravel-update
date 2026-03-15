<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\JuriController;
use App\Http\Controllers\AdminController;

// Public Routes
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/info-lomba', function () {
    return view('info');
})->name('info');

Route::get('/pengumuman', function () {
    return view('pengumuman');
})->name('pengumuman');

Route::get('/galeri', function () {
    return view('galeri');
})->name('galeri');

// Auth Routes (dari Breeze)
require __DIR__.'/auth.php';

// Fallback logout via GET (untuk development)
Route::get('/logout', function() {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth');

// Redirect setelah login berdasarkan role
Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'juri') return redirect()->route('juri.dashboard');
    return redirect()->route('peserta.dashboard');
})->middleware('auth')->name('dashboard');

// ===== PESERTA ROUTES =====
Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/dashboard', [PesertaController::class, 'dashboard'])->name('dashboard');
    Route::get('/upload', [PesertaController::class, 'uploadForm'])->name('upload');
    Route::post('/upload', [PesertaController::class, 'uploadDesign'])->name('upload.store');
    Route::get('/status', [PesertaController::class, 'status'])->name('status');
    Route::get('/juknis', [PesertaController::class, 'juknis'])->name('juknis');
});

// ===== JURI ROUTES =====
Route::middleware(['auth', 'role:juri'])->prefix('juri')->name('juri.')->group(function () {
    Route::get('/dashboard', [JuriController::class, 'dashboard'])->name('dashboard');
    Route::get('/desain', [JuriController::class, 'daftarDesain'])->name('desain');
    Route::get('/desain/{design}', [JuriController::class, 'detailDesain'])->name('desain.detail');
    Route::post('/nilai/{design}', [JuriController::class, 'simpanNilai'])->name('nilai.store');
    Route::get('/penilaian-saya', [JuriController::class, 'penilaianSaya'])->name('penilaian');
});

// ===== ADMIN ROUTES =====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/peserta', [AdminController::class, 'peserta'])->name('peserta');
    Route::post('/peserta/{user}/verify', [AdminController::class, 'verifyPeserta'])->name('peserta.verify');
    Route::delete('/peserta/{user}', [AdminController::class, 'deletePeserta'])->name('peserta.delete');
    Route::get('/juri', [AdminController::class, 'juri'])->name('juri');
    Route::post('/juri', [AdminController::class, 'storeJuri'])->name('juri.store');
    Route::delete('/juri/{user}', [AdminController::class, 'deleteJuri'])->name('juri.delete');
    Route::get('/desain', [AdminController::class, 'desain'])->name('desain');
    Route::post('/desain/{design}/approve', [AdminController::class, 'approveDesain'])->name('desain.approve');
    Route::post('/desain/{design}/reject', [AdminController::class, 'rejectDesain'])->name('desain.reject');
    Route::get('/penilaian', [AdminController::class, 'penilaian'])->name('penilaian');
    Route::get('/juara', [AdminController::class, 'juara'])->name('juara');
    Route::post('/juara/publish', [AdminController::class, 'publishJuara'])->name('juara.publish');
    Route::post('/lomba/toggle', [AdminController::class, 'toggleLomba'])->name('lomba.toggle');
});