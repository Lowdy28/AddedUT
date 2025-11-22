<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Registro público
Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro');
Route::post('/registrar', [RegistroController::class, 'registrar'])->name('registrar');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('eventos', EventoController::class);
    Route::resource('inscripciones', InscripcionController::class);
    Route::resource('notificaciones', NotificacionController::class);

    Route::post(
        'notificaciones/{notificacion}/marcar-leida',
        [NotificacionController::class, 'marcarLeida']
    )->name('notificaciones.marcarLeida');

    Route::get('/reportes', [ReporteController::class, 'index'])
        ->name('reportes.index');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('usuarios', UsuarioController::class);
});

Route::get('/usuarios/buscar/ajax', [UserController::class, 'buscarAjax'])->name('usuarios.buscar.ajax');

require __DIR__.'/auth.php';
