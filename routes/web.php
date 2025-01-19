<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware('auth:admin')->get('/', [IndexController::class, 'index'])->name('index');
//------------ Login --------------
Route::get('/login', [AuthController::class, 'loginVue'])->name('login')->middleware('guest:admin');
//------------ Route pour le traitement de login ---------
Route::post('/login_admin', [AuthController::class, 'login'])->name('login_admin');


Route::middleware('auth:admin')->group(function () {
    //------------ Route de logout ------
    Route::get('/logout', [AuthController::class, 'deconnexion'])->name('logout');
    Route::resource('services', ServicesController::class);
    Route::resource('partners', PartnerController::class);
    Route::post('partners/enable/{partner}', [PartnerController::class, 'enable'])->name('partners.enable'); /// enable
    Route::post('partners/disable/{partner}', [PartnerController::class, 'disable'])->name('partners.disable'); //disable
    Route::resource('reservations', ReservationController::class);
    Route::resource('clients', ClientController::class);
    Route::post('clients/enable/{partner}', [PartnerController::class, 'enable'])->name('clients.enable'); /// enable
    Route::post('clients/disable/{partner}', [PartnerController::class, 'disable'])->name('clients.disable'); //disable
});
