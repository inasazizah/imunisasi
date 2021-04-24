<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::get('/form', 'BabyController@create')->name('form');
Route::post('/form', 'BabyController@store')->name('form.store');
Route::get('/hasil', 'BabyController@show')->name('form.show');
Route::get('/riwayat', 'RiwayatController@index')->name('riwayat');
Route::put('/riwayat','RiwayatController@update')->name('riwayat.update');
Route::get('/detail/{id}', 'ImunisasiController@detail')->name('detail');