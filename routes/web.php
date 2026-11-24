<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Publico\HabitacionController;
use App\Http\Controllers\Publico\ReservaController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;
use App\Http\Controllers\Admin\HabitacionController as AdminHabitacionController;

// Página principal
Route::get('/', function () {
    return view('welcome');
})->name('inicio');

Route::get('/api/habitaciones', [HabitacionController::class, 'index'])
    ->name('api.habitaciones.index');

Route::get('/reservas/crear/{id}', [ReservaController::class, 'crear'])
    ->name('reservas.crear');

Route::post('/reservas/crear/{id}', [ReservaController::class, 'guardar'])
    ->name('reservas.guardar');

// Autenticación
Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.post');

});

// Cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Dashboard del administrador
Route::middleware(['auth', 'rol:Administrador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/api/reservas', [AdminReservaController::class, 'index'])
            ->name('reservas.index');

        Route::put('/api/reservas/{id}/estado', [AdminReservaController::class, 'actualizarEstado'])
            ->name('reservas.estado');

        Route::get('/api/habitaciones', [AdminHabitacionController::class, 'index'])
            ->name('habitaciones.index');

        Route::post('/api/habitaciones', [AdminHabitacionController::class, 'store'])
            ->name('habitaciones.store');

        Route::put('/api/habitaciones/{id}', [AdminHabitacionController::class, 'update'])
            ->name('habitaciones.update');

        Route::delete('/api/habitaciones/{id}', [AdminHabitacionController::class, 'destroy'])
            ->name('habitaciones.destroy');

});

// Dashboard del recepcionista
Route::middleware(['auth', 'rol:Recepcionista'])
    ->prefix('recepcionista')
    ->name('recepcionista.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('recepcionista.dashboard');
        })->name('dashboard');

});

// Dashboard del cliente
Route::middleware(['auth', 'rol:Cliente'])
    ->prefix('cliente')
    ->name('cliente.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('cliente.dashboard');
        })->name('dashboard');

});

