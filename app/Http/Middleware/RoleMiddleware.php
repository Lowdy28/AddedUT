<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->rol === $role) {
            return $next($request);
        }

        // Redirige al dashboard correcto según el rol real del usuario
        return match($user->rol) {
            'admin'      => redirect()->route('dashboard.admin'),
            'profesor'   => redirect()->route('profesor.dashboard'),
            'estudiante' => redirect()->route('estudiante.dashboard'),
            default      => redirect()->route('login'),
        };
    }
}
