<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\KeaktifanController;
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

Route::get('/', function () {
    return redirect('mahasiswa');
});


Route::post('/endpoint/{table}', [BackupController::class, 'storeData']);
Route::get('/pdf', [BackupController::class, 'storeData'])->name('mahasiswa.index');

Route::prefix('mahasiswa')->group(function () {
    Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::get('/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::get('/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::put('/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::delete('/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
});

Route::prefix('pertemuan')->group(function () {
    Route::get('/', [PertemuanController::class, 'index'])->name('pertemuan.index');
    Route::get('/create', [PertemuanController::class, 'create'])->name('pertemuan.create');
    Route::post('/store', [PertemuanController::class, 'store'])->name('pertemuan.store');
    Route::get('/{id}', [PertemuanController::class, 'show'])->name('pertemuan.show');
    Route::get('/{id}/edit', [PertemuanController::class, 'edit'])->name('pertemuan.edit');
    Route::put('/{id}', [PertemuanController::class, 'update'])->name('pertemuan.update');
    Route::delete('/{id}', [PertemuanController::class, 'destroy'])->name('pertemuan.destroy');
});

Route::prefix('absensi')->group(function () {
    Route::get('/{id}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::post('/update', [AbsensiController::class, 'update'])->name('absensi.update');
});

Route::prefix('laporan')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/create', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/store', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/{id}', [LaporanController::class, 'show'])->name('laporan.show');
    Route::get('/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::post('/update', [LaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
});

Route::prefix('nilai')->group(function () {
Route::get('/', [NilaiController::class, 'index'])->name('nilai.index');
Route::get('/{id}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
Route::post('/update', [NilaiController::class, 'update'])->name('nilai.update');
});

Route::prefix('keaktifan')->group(function () {
Route::get('/', [KeaktifanController::class, 'index'])->name('keaktifan.index');
Route::get('/create', [KeaktifanController::class, 'create'])->name('keaktifan.create');
Route::post('/store', [KeaktifanController::class, 'store'])->name('keaktifan.store');
Route::get('/{id}/edit', [KeaktifanController::class, 'edit'])->name('keaktifan.edit');
Route::put('/{id}', [KeaktifanController::class, 'update'])->name('keaktifan.update');
Route::delete('/{id}', [KeaktifanController::class, 'destroy'])->name('keaktifan.destroy');
});