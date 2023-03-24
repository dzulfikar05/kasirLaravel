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

Route::controller(TransaksiController::class)->middleware('auth', 'access')->group(function() {
    Route::get('/transaksi','index')->name('transaksi');
    Route::post('/transaksi/search','search')->name('transaksi/search');
    Route::post('/transaksi/addCart','addCart')->name('transaksi/addCart');
    Route::get('/transaksi/table','inittable')->name('transaksi/table');
    Route::post('/transaksi/plusQty','plusQty')->name('transaksi/plusQty');
    Route::post('/transaksi/minusQty','minusQty')->name('transaksi/minusQty');
    Route::post('/transaksi/destroy','destroy')->name('transaksi/destroy');
    Route::post('/transaksi/countTransaksi','countTransaksi')->name('transaksi/countTransaksi');
    Route::post('/transaksi/bayar','bayar')->name('transaksi/bayar');
    Route::post('/transaksi/truncateCart','truncateCart')->name('transaksi/truncateCart');
    Route::post('/transaksi/cetak','cetak')->name('transaksi/cetak');
    
});