<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PertemuanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\KeaktifanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BackupController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return response()->json(['message' => 'API Aktif']);
});
Route::get('/backup', [BackupController::class, 'backupDatabase']);
Route::get('/truncate', [BackupController::class, 'truncateData']);
Route::get('/report', [BackupController::class, 'report']);
Route::get('/rekap', [BackupController::class, 'rekap']);
Route::get('/downloadreport', [BackupController::class, 'downloadreport']);
Route::post('/import', [BackupController::class, 'importData']);

Route::prefix('login')->group(function () {
    Route::post('/', [LoginController::class, 'login']);
    Route::post('/logintoken', [LoginController::class, 'loginWithToken']);
    Route::get('/token/{token}', [LoginController::class, 'checkToken']);
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::post('/gantipassword', [LoginController::class, 'updatePassword']);
    Route::post('/gantiusername', [LoginController::class, 'updateUsername']);
});

Route::prefix('mahasiswa')->group(function () {
    Route::get('/', [MahasiswaController::class, 'indexapi']);
    Route::post('/store', [MahasiswaController::class, 'storeapi']);
    Route::post('/batchstore', [BackupController::class, 'batchstore']);
    Route::post('/update/{id}', [MahasiswaController::class, 'updateapi']);
    Route::post('/{id}', [MahasiswaController::class, 'destroyapi']);
    Route::get('/checkmhs/{nim}', [MahasiswaController::class, 'checkmhs']);
    Route::get('/nim/{nim}', [MahasiswaController::class, 'getDetail']);
    Route::get('/nama/{nama}', [MahasiswaController::class, 'getDetailnama']);
    Route::get('/nohp/{nohp}', [MahasiswaController::class, 'getDetailnohp']);
    Route::get('/backup', [MahasiswaController::class, 'backupMahasiswa']);
});

Route::prefix('pertemuan')->group(function () {
    Route::get('/', [PertemuanController::class, 'indexapi']);
    Route::post('/store', [PertemuanController::class, 'storeapi']);
    Route::post('/{id}', [PertemuanController::class, 'updateapi']);
    Route::post('/delete/{id}', [PertemuanController::class, 'destroyapi']);
});

Route::prefix('absensi')->group(function () {
    Route::get('/', [AbsensiController::class, 'indexapi']);
    Route::get('/{id}', [AbsensiController::class, 'absenapi']);
    Route::post('/update', [AbsensiController::class, 'updateapi']);
    Route::get('/nim/{nim}', [AbsensiController::class, 'getAbsenMhs']);
});

Route::prefix('laporan')->group(function () {
    Route::get('/', [LaporanController::class, 'indexapi']);
    Route::get('/nim/{nim}', [LaporanController::class, 'getDetail']);
    Route::get('/{id}', [LaporanController::class, 'getLaporan']);
    Route::post('/update', [LaporanController::class, 'updateapi']);
    Route::delete('/{id}', [LaporanController::class, 'destroy']);
});

Route::prefix('nilai')->group(function () {
    Route::get('/', [NilaiController::class, 'indexapi']);
    Route::post('/update', [NilaiController::class, 'updateapi']);
    Route::get('/nim/{nim}', [NilaiController::class, 'getDetails']);
    Route::get('/{id}', [NilaiController::class, 'detailNilai']);
});

Route::prefix('keaktifan')->group(function () {
    Route::get('/', [KeaktifanController::class, 'indexapi']);
    Route::get('/nim/{nim}', [KeaktifanController::class, 'getDetail']);
    Route::post('/store', [KeaktifanController::class, 'storeapi']);
    Route::post('/update/{id}', [KeaktifanController::class, 'updateapi']);
    Route::post('/{id}', [KeaktifanController::class, 'destroyapi']);
});
