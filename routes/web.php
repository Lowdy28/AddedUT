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

use Illuminate\Support\Facades\Route;

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// 🔹 Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

// 🔹 Registro público
Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro');
Route::post('/registro', [RegistroController::class, 'registrar'])->name('registro.post');

// 🔹 Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🔹 Rutas protegidas
Route::middleware(['auth:web'])->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Recursos
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('eventos', EventoController::class);
    Route::resource('inscripciones', InscripcionController::class);
    Route::resource('notificaciones', NotificacionController::class);

    // AJAX para usuarios
    Route::get('/usuarios/buscar/ajax', [UsuarioController::class, 'buscarAjax'])->name('usuarios.buscar.ajax');

});

//Reportes
Route::middleware(['auth'])->group(function () {

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/export/{tipo}/{formato}', [ReporteController::class, 'export'])
        ->name('reportes.export');
    Route::get('/reportes/data/usuarios', [ReporteController::class, 'usuariosData']);
    Route::get('/reportes/data/actividades', [ReporteController::class, 'actividadesData']);
    Route::get('/reportes/data/eventos', [ReporteController::class, 'eventosData']);
    Route::get('/reportes/data/inscripciones', [ReporteController::class, 'inscripcionesData']);

});

