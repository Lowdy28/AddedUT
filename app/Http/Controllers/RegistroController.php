<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    public function mostrarFormulario()
    {
        return view('auth.register');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|in:estudiante,profesor,admin',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'activo' => true,
        ]);

        // Inicia sesión automáticamente después de registrarse
        Auth::login($usuario);

        // Redirige según rol
        $rol = $usuario->rol;
        if ($rol === 'admin') return redirect()->route('dashboard');
        if ($rol === 'profesor') return redirect()->route('profesor.dashboard');
        if ($rol === 'estudiante') return redirect()->route('estudiante.dashboard');

        return redirect()->route('dashboard');
    }
}
