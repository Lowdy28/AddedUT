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

Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro');
Route::post('/registro', [RegistroController::class, 'registrar'])->name('registro.post');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth:web'])->group(function () {

    // Dashboard general
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('usuarios', UsuarioController::class);
    Route::get('/usuarios/buscar/ajax', [UsuarioController::class, 'buscarAjax'])->name('usuarios.buscar.ajax');


    Route::resource('eventos', EventoController::class);

    Route::resource('inscripciones', InscripcionController::class);

    Route::resource('notificaciones', NotificacionController::class);
    Route::post('/notificaciones/{notificacion}/marcar-leida', 
        [NotificacionController::class, 'marcarLeida']
    )->name('notificaciones.marcarLeida');

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

    Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':estudiante'])->group(function () {

        Route::get('/estudiante/dashboard', 
            [EstudianteDashboardController::class, 'index']
        )->name('estudiante.dashboard');

        Route::get('/estudiante/eventos', 
            [EstudianteEventoController::class, 'index']
        )->name('estudiante.eventos.index');

        Route::get('/estudiante/eventos/{evento}', 
            [EstudianteEventoController::class, 'show']
        )->name('estudiante.eventos.show');

        Route::get('/estudiante/mis-inscripciones', 
            [EstudianteEventoController::class, 'myEvents']
        )->name('estudiante.inscripciones.mine');

        Route::post('/estudiante/inscripciones/{evento}', 
            [InscripcionController::class, 'store']
        )->name('estudiante.inscripciones.store');

        Route::delete('/estudiante/inscripciones/{evento}', 
            [InscripcionController::class, 'destroyByEvent']
        )->name('estudiante.inscripciones.destroy');

        Route::get('/estudiante/perfil', [ProfileController::class, 'edit'])
            ->name('estudiante.profile.edit');

        Route::patch('/estudiante/perfil', [ProfileController::class, 'update'])
            ->name('estudiante.profile.update');
    });
});

Route::middleware(['auth'])->group(function () {

    Route::get('/reportes/export/{tipo}/{formato}', [ReporteController::class, 'export'])
        ->name('reportes.export');
    Route::get('/reportes/data/usuarios', [ReporteController::class, 'usuariosData']);
    Route::get('/reportes/data/actividades', [ReporteController::class, 'actividadesData']);
    Route::get('/reportes/data/eventos', [ReporteController::class, 'eventosData']);
    Route::get('/reportes/data/inscripciones', [ReporteController::class, 'inscripcionesData']);
});
