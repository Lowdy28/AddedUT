<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): mixed
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                return match($user->rol) {
                    'admin'      => redirect()->route('dashboard.admin'),
                    'profesor'   => redirect()->route('profesor.dashboard'),
                    'estudiante' => redirect()->route('estudiante.dashboard'),
                    default      => redirect()->route('login'),
                };
            }
        }

        return $next($request);
    }
}
