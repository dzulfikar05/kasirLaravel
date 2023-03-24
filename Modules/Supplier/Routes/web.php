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
Route::controller(SupplierController::class)->middleware('auth', 'access')->group(function() {
    Route::get('/supplier','index')->name('supplier');
    Route::get('/supplier/table','initTable')->name('supplier/table');
    Route::post('/supplier/store','store')->name('supplier/store');
    Route::post('/supplier/edit','edit')->name('supplier/edit');
    Route::post('/supplier/update','update')->name('supplier/update');
    Route::post('/supplier/destroy','destroy')->name('supplier/destroy');
    Route::post('/supplier/combobox','combobox')->name('supplier/combobox');
});
