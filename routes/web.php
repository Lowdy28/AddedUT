<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteDashboardController;
use App\Http\Controllers\EstudianteEventoController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro');
Route::post('/registro', [RegistroController::class, 'registrar'])->name('registro.post');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth:web'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('usuarios', UsuarioController::class);
    Route::resource('eventos', EventoController::class);
    Route::resource('inscripciones', InscripcionController::class);
    Route::resource('notificaciones', NotificacionController::class);

    // AJAX usuarios
    Route::get('/usuarios/buscar/ajax', [UsuarioController::class, 'buscarAjax'])->name('usuarios.buscar.ajax');

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
});

Route::middleware(['auth:web', \App\Http\Middleware\RoleMiddleware::class.':estudiante'])->group(function() {

    Route::get('/estudiante/dashboard', [EstudianteDashboardController::class, 'index'])
        ->name('estudiante.dashboard');

    Route::get('/estudiante/eventos', [EstudianteEventoController::class, 'index'])
        ->name('estudiante.eventos.index');

    // Ruta para inscripciones desde estudiante
    Route::post('/estudiante/inscripciones', [InscripcionController::class, 'store'])
        ->name('estudiante.inscripciones.store');

    // Perfil del estudiante
    Route::get('/estudiante/perfil', [ProfileController::class, 'edit'])
        ->name('estudiante.profile.edit');

    Route::patch('/estudiante/perfil', [ProfileController::class, 'update'])
        ->name('estudiante.profile.update');
});


