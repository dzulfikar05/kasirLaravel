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

Route::controller(ProfileController::class)->middleware('auth')->group(function() {
    Route::get('/profile','index')->name('profile');
    Route::post('/profile/store','store')->name('profile/store');
    Route::post('/profile/edit','edit')->name('profile/edit');
    Route::post('/profile/update','update')->name('profile/update');
    Route::post('/profile/destroy','destroy')->name('profile/destroy');
});