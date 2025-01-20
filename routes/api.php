<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\Client\ProfilController;
use App\Http\Controllers\Api\Client\ReservationController;
use App\Http\Controllers\Api\Provider\ProfilController as ProviderProfilController;
use App\Http\Controllers\Api\Provider\ReservationController as ProviderReservationController;
use App\Http\Controllers\Api\Provider\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        //Reservations
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::post('/reservation', [ReservationController::class, 'store'])->name('reservations.store');

        //Profil
        Route::get('/profil', [ProfilController::class, 'show']);
        Route::put('/profil', [ProfilController::class, 'updateProfile']);
    });

Route::middleware(['auth:sanctum', 'role:provider'])
    ->prefix('provider')
    ->name('provider.')
    ->group(function () {
        // Routes pour les providers
        Route::get('/reservations', [ProviderReservationController::class, 'index'])->name('reservations.index');
        Route::post('/reservations', [ProviderReservationController::class, 'store'])->name('reservations.store');
        Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
        //services
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::post('/add/service', [ServiceController::class, 'providerService']);
        Route::get('/recuperer/services', [ServiceController::class, 'getPrestataireServices']);
        //profil
        Route::get('/profil', [ProviderProfilController::class, 'show']);
        Route::put('/profil', [ProviderProfilController::class, 'updateProfile']);
    });
