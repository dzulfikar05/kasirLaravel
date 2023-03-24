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
Route::controller(StokController::class)->middleware('auth', 'access')->group(function() {
    Route::get('/stok','index')->name('stok');
    Route::post('/stok/store','store')->name('stok/store');
    Route::post('/stok/getOldData','getOldData')->name('stok/getOldData');
});