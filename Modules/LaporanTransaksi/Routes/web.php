<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
;
Route::controller(LaporanTransaksiController::class)->middleware('auth', 'access')->group(function() {
    Route::get('/laporantransaksi','index')->name('laporantransaksi');
    Route::get('/laporantransaksi/table','initTable')->name('laporantransaksi/table');
    Route::get('/laporantransaksi/detail','detail')->name('laporantransaksi/detail');
    Route::post('/laporantransaksi/cetak','cetak')->name('laporantransaksi/cetak');
    Route::post('/laporantransaksi/totalPendapatan','totalPendapatan')->name('laporantransaksi/totalPendapatan');
    Route::post('/laporantransaksi/cetakReport','cetakReport')->name('laporantransaksi/cetakReport');
    Route::post('/laporantransaksi/cetakLaporan','cetakLaporan')->name('laporantransaksi/cetakLaporan');
    
});
