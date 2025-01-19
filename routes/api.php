<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\Client\ProfilController;
use App\Http\Controllers\Api\Client\ReservationController;
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
        // Routes pour les clients
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
    });

Route::middleware(['auth:sanctum', 'role:provider'])
    ->prefix('provider')
    ->name('provider.')
    ->group(function () {
        // Routes pour les providers
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
    });
