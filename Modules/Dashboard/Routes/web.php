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
Route::controller(DashboardController::class)->middleware('auth', 'access')->group(function() {
    Route::get('/','index')->name('dashboard');
    Route::post('/dashboard/getDataCard','getDataCard')->name('dashboard/getDataCard');
    Route::post('/dashboard/getChartTerlaris','getChartTerlaris')->name('dashboard/getChartTerlaris');
});