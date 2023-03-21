<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthenticationController::class, 'login'])->name('login');
Route::post('/', [AuthenticationController::class, 'loginPost'])->name('login.post');

Route::middleware(['auth'])->prefix('home')->group(function () {
    Route::get('/sign-out', [AuthenticationController::class, 'signout'])->name('signout');

    Route::get('/', HomeController::class)->name('home');

    Route::resource('jabatan', JabatanController::class);
    Route::resource('karyawan', KaryawanController::class);
});
