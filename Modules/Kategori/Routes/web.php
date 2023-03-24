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
Route::controller(KategoriController::class)->middleware('auth', 'access')->group(function() {
    Route::get('/kategori','index')->name('kategori');
    Route::get('/kategori/table','initTable')->name('kategori/table');
    Route::post('/kategori/store','store')->name('kategori/store');
    Route::post('/kategori/edit','edit')->name('kategori/edit');
    Route::post('/kategori/update','update')->name('kategori/update');
    Route::post('/kategori/destroy','destroy')->name('kategori/destroy');
    Route::post('/kategori/combobox','combobox')->name('kategori/combobox');
});
