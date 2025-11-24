<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class LoginController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::guard('web')->user();

            // Redirigir según rol
            return match($user->rol) {
                'admin' => redirect()->route('dashboard.admin'),
                'profesor' => redirect()->route('profesor.dashboard'),
                'estudiante' => redirect()->route('estudiante.dashboard'),
                default => redirect()->route('dashboard')
            };
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.'
        ])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
