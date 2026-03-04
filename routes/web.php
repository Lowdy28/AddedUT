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
use App\Http\Controllers\ProfesorDashboardController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\AdminNoticiaController;
use App\Http\Controllers\RecomendacionController;
use App\Http\Controllers\ChatbotController;

use Illuminate\Support\Facades\Route;

// ── Pública ──────────────────────────────────────────────────────────────────
// Si ya hay sesión activa, / y /login redirigen al dashboard del rol
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::view('/terminos', 'terminos')->name('terminos');

    Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro');
    Route::post('/registro', [RegistroController::class, 'registrar'])->name('registro.post');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ── Autenticadas + sin caché (botón atrás nunca muestra página cacheada) ──────
Route::middleware(['auth:web', 'nocache'])->group(function () {

    // Redirección inteligente: /dashboard detecta el rol y manda al correcto
    Route::get('/dashboard', function () {
        $rol = auth()->user()->rol;
        return match($rol) {
            'admin'      => redirect()->route('dashboard.admin'),
            'profesor'   => redirect()->route('profesor.dashboard'),
            'estudiante' => redirect()->route('estudiante.dashboard'),
            default      => redirect()->route('login'),
        };
    })->name('dashboard');

    // ── ADMIN ─────────────────────────────────────────────────────────────────
    Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':admin'])->group(function () {

        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

        Route::resource('usuarios', UsuarioController::class);
        Route::get('/usuarios/buscar/ajax', [UsuarioController::class, 'buscarAjax'])->name('usuarios.buscar.ajax');

        Route::resource('eventos', EventoController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::resource('inscripciones', InscripcionController::class);
        Route::resource('notificaciones', NotificacionController::class);
        Route::resource('noticias', NoticiaController::class)->except(['create', 'edit', 'show']);
        Route::resource('admin/noticias', AdminNoticiaController::class)->names('admin.noticias');

        Route::post('/notificaciones/{notificacion}/marcar-leida',
            [NotificacionController::class, 'marcarLeida']
        )->name('notificaciones.marcarLeida');

        Route::post('/notificaciones/mark-all-read', function () {
            $user = App\Models\User::find(auth()->id());
            $user->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        })->name('notificaciones.markAllRead');

        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/reportes/export/{tipo}/{formato}', [ReporteController::class, 'export'])->name('reportes.export');
        Route::get('/reportes/data/usuarios', [ReporteController::class, 'usuariosData']);
        Route::get('/reportes/data/actividades', [ReporteController::class, 'actividadesData']);
        Route::get('/reportes/data/eventos', [ReporteController::class, 'eventosData']);
        Route::get('/reportes/data/inscripciones', [ReporteController::class, 'inscripcionesData']);
        Route::get('/reportes/data/noticias', [ReporteController::class, 'noticiasData']);

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // ── ESTUDIANTE ────────────────────────────────────────────────────────────
    Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':estudiante'])->group(function () {

        Route::get('/estudiante/dashboard', [EstudianteDashboardController::class, 'index'])->name('estudiante.dashboard');

        Route::get('/estudiante/eventos', [EstudianteEventoController::class, 'index'])->name('estudiante.eventos.index');
        Route::get('/estudiante/eventos/{evento}', [EstudianteEventoController::class, 'show'])->name('estudiante.eventos.show');
        Route::get('/estudiante/mis-inscripciones', [EstudianteEventoController::class, 'myEvents'])->name('estudiante.inscripciones.mine');

        Route::post('/estudiante/inscripciones/{evento}', [InscripcionController::class, 'store'])->name('estudiante.inscripciones.store');
        Route::delete('/estudiante/inscripciones/{evento}', [InscripcionController::class, 'destroyByEvent'])->name('estudiante.inscripciones.destroy');

        Route::get('/estudiante/perfil', [ProfileController::class, 'edit'])->name('estudiante.profile.edit');
        Route::patch('/estudiante/perfil', [ProfileController::class, 'update'])->name('estudiante.profile.update');

        Route::get('/estudiante/noticias', [NoticiaController::class, 'foro'])->name('estudiante.noticias.foro');
        Route::get('/estudiante/noticias/{noticia}', [NoticiaController::class, 'show'])->name('estudiante.noticias.show');
        Route::post('/estudiante/noticias/{noticia}/like', [NoticiaController::class, 'toggleLike'])->name('estudiante.noticias.like');
        Route::post('/estudiante/noticias/{noticia}/comentar', [NoticiaController::class, 'comentar'])->name('estudiante.noticias.comentar');
        Route::delete('/estudiante/noticias/comentario/{comentario}', [NoticiaController::class, 'eliminarComentario'])->name('estudiante.noticias.comentario.destroy');

        Route::post('/estudiante/recomendacion/intereses', [RecomendacionController::class, 'guardarIntereses'])->name('estudiante.recomendacion.guardar');
        Route::post('/estudiante/recomendacion/omitir', [RecomendacionController::class, 'omitir'])->name('estudiante.recomendacion.omitir');

        Route::post('/chatbot', [ChatbotController::class, 'responder'])->name('estudiante.chatbot');
    });

    // ── PROFESOR ──────────────────────────────────────────────────────────────
    Route::middleware([\App\Http\Middleware\RoleMiddleware::class . ':profesor'])->group(function () {

        Route::get('/profesor/dashboard', [ProfesorDashboardController::class, 'index'])->name('profesor.dashboard');
        Route::get('/profesor/mi-taller', [ProfesorDashboardController::class, 'miTaller'])->name('profesor.taller');

        Route::get('/profesor/profile', [ProfileController::class, 'edit'])->name('profesor.profile.edit');
        Route::patch('/profesor/profile', [ProfileController::class, 'update'])->name('profesor.profile.update');
        Route::delete('/profesor/profile', [ProfileController::class, 'destroy'])->name('profile.profile.destroy');

        Route::post('/profesor/noticias/{noticia}/like', [NoticiaController::class, 'toggleLike'])->name('profesor.noticias.like');
        Route::get('/profesor/noticias/{noticia}', [NoticiaController::class, 'show'])->name('profesor.noticias.show');
    });
});
