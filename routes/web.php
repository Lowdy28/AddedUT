<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (solo para usuarios autenticados)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de perfil (solo autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Registro
Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro');
Route::post('/registrar', [RegistroController::class, 'registrar'])->name('registrar');

// ---- RUTAS DE LOGIN ----
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🔹 IMPORTANTE: comenta esta línea si aún te da conflicto con el login viejo
// require __DIR__.'/auth.php';
