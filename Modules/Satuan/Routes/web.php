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
Route::controller(SatuanController::class)->middleware('auth', 'access')->group(function() {
    Route::get('/satuan','index')->name('satuan');
    Route::get('/satuan/table','initTable')->name('satuan/table');
    Route::post('/satuan/store','store')->name('satuan/store');
    Route::post('/satuan/edit','edit')->name('satuan/edit');
    Route::post('/satuan/update','update')->name('satuan/update');
    Route::post('/satuan/destroy','destroy')->name('satuan/destroy');
    Route::post('/satuan/combobox','combobox')->name('satuan/combobox');
});
