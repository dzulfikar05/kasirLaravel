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
Route::controller(ProdukController::class)->middleware('auth', 'access')->group(function() {
    Route::get('/produk','index')->name('produk');
    Route::get('/produk/table','initTable')->name('produk/table');
    Route::post('/produk/store','store')->name('produk/store');
    Route::post('/produk/edit','edit')->name('produk/edit');
    Route::post('/produk/update','update')->name('produk/update');
    Route::post('/produk/destroy','destroy')->name('produk/destroy');
    Route::post('/produk/combobox','combobox')->name('produk/combobox');
    Route::post('/produk/importExcel','importExcel')->name('produk/importExcel');
});
