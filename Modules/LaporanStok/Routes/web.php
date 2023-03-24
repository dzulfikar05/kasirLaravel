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
Route::controller(LaporanStokController::class)->middleware('auth', 'access')->group(function() {
    Route::get('/laporanstok','index')->name('laporanstok');
    Route::get('/laporanstok/table','initTable')->name('laporanstok/table');
    Route::post('/laporanstok/cetakLaporan','cetakLaporan')->name('laporanstok/cetakLaporan');
    Route::post('/laporanstok/cetakInvoice','cetakInvoice')->name('laporanstok/cetakInvoice');
 
    
});
