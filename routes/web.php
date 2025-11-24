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

// 🔹 Registro público
Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro');
Route::post('/registro', [RegistroController::class, 'registrar'])->name('registro.post');

// 🔹 Login y Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth:web'])->group(function () {


Route::middleware(['auth:web'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('usuarios', UsuarioController::class);
    Route::resource('eventos', EventoController::class);
    Route::resource('inscripciones', InscripcionController::class);
    Route::resource('notificaciones', NotificacionController::class);

    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    
    Route::get('/usuarios/buscar/ajax', [UsuarioController::class, 'buscarAjax'])->name('usuarios.buscar.ajax');
    Route::resource('eventos', EventoController::class);

    Route::get('/inscripciones', [InscripcionController::class, 'index'])->name('inscripciones.index');
    Route::get('/inscripciones/create', [InscripcionController::class, 'create'])->name('inscripciones.create');
    Route::post('/inscripciones', [InscripcionController::class, 'store'])->name('inscripciones.store');
    Route::get('/inscripciones/{id}', [InscripcionController::class, 'show'])->name('inscripciones.show');
    Route::get('/inscripciones/{id}/edit', [InscripcionController::class, 'edit'])->name('inscripciones.edit');
    Route::put('/inscripciones/{id}', [InscripcionController::class, 'update'])->name('inscripciones.update');
    Route::delete('/inscripciones/{id}', [InscripcionController::class, 'destroy'])->name('inscripciones.destroy');

    Route::resource('notificaciones', NotificacionController::class);
    Route::post('/notificaciones/{notificacion}/marcar-leida', [NotificacionController::class, 'marcarLeida'])
        ->name('notificaciones.marcarLeida');

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
});

Route::middleware(['auth:web', \App\Http\Middleware\RoleMiddleware::class.':estudiante'])->group(function() {

    // 1. DASHBOARD
    Route::get('/estudiante/dashboard', [EstudianteDashboardController::class, 'index'])
        ->name('estudiante.dashboard');

    // 2. EVENTOS (Listado e Índice)
    Route::get('/estudiante/eventos', [EstudianteEventoController::class, 'index'])
        ->name('estudiante.eventos.index');

    // 3. EVENTOS (Detalle de un evento)
    Route::get('/estudiante/eventos/{evento}', [EstudianteEventoController::class, 'show'])
        ->name('estudiante.eventos.show');

    // 4. MIS INSCRIPCIONES (Necesaria para el botón en la vista de listado)
    Route::get('/estudiante/mis-inscripciones', [EstudianteEventoController::class, 'myEvents'])
        ->name('estudiante.inscripciones.mine');
    
    
    // 5. INSCRIPCIÓN (La única ruta POST de inscripción, requiere el parámetro {evento})
    Route::post('/estudiante/inscripciones/{evento}', [InscripcionController::class, 'store'])
        ->name('estudiante.inscripciones.store'); 

    // 6. CANCELAR INSCRIPCIÓN
    Route::delete('/estudiante/inscripciones/{evento}', [InscripcionController::class, 'destroyByEvent'])
        ->name('estudiante.inscripciones.destroy');


    // 7. PERFIL (Editar)
    Route::get('/estudiante/perfil', [ProfileController::class, 'edit'])
        ->name('estudiante.profile.edit');

    // 8. PERFIL (Actualizar)
    Route::patch('/estudiante/perfil', [ProfileController::class, 'update'])
        ->name('estudiante.profile.update');
    Route::get('/eventos/{evento}', [EstudianteEventoController::class, 'show'])->name('estudiante.eventos.showEstudiante');
    
});

});
