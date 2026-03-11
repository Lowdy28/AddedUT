<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class RecuperarContrasenaController extends Controller
{
    /**
     * Minutos antes de que la sesión de recuperación expire.
     */
    private const EXPIRA_MINUTOS = 5;

    // ──────────────────────────────────────────────────────────
    // PASO 1 — Mostrar formulario de verificación
    // ──────────────────────────────────────────────────────────
    public function showForm()
    {
        if ($this->sesionValida()) {
            return redirect()->route('recuperar.nueva');
        }

        // Limpiar sesión expirada si la hubiera
        session()->forget(['recuperar_id', 'recuperar_nombre', 'recuperar_expira']);

        return view('auth.recuperar');
    }

    // ──────────────────────────────────────────────────────────
    // PASO 1 — Verificar identidad
    // ──────────────────────────────────────────────────────────
    public function verificar(Request $request)
    {
        // ── Rate limiting interno: registra intentos y muestra avisos progresivos ──
        // El throttle global de Laravel (bootstrap/app.php) ya corta a nivel HTTP;
        // este contador agrega mensajes de advertencia antes de llegar a ese límite.
        $key = 'recuperar:' . $request->ip();

        $request->validate([
            'matricula' => 'required|string',
            'nombre'    => 'required|string',
        ], [
            'matricula.required' => 'La matrícula es obligatoria.',
            'nombre.required'    => 'El nombre completo es obligatorio.',
        ]);

        $usuario = Usuario::where('matricula', trim($request->matricula))->first();

        if (!$usuario || strtolower(trim($usuario->nombre)) !== strtolower(trim($request->nombre))) {
            // Contar intento fallido (ventana de 2 minutos)
            RateLimiter::hit($key, 120);

            $intentosRestantes = 5 - RateLimiter::attempts($key);

            $mensaje = 'Los datos no coinciden con ninguna cuenta registrada.';
            if ($intentosRestantes <= 2 && $intentosRestantes > 0) {
                $mensaje .= " Te quedan {$intentosRestantes} intento(s) antes de ser bloqueado temporalmente.";
            }

            return back()
                ->withInput(['matricula' => $request->matricula])
                ->withErrors(['matricula' => $mensaje]);
        }

        // ✅ Verificación exitosa — limpiar contador y guardar sesión con expiración
        RateLimiter::clear($key);

        session([
            'recuperar_id'     => $usuario->id_usuario,
            'recuperar_nombre' => $usuario->nombre,
            'recuperar_expira' => now()->addMinutes(self::EXPIRA_MINUTOS)->timestamp,
        ]);

        return redirect()->route('recuperar.nueva');
    }

    // ──────────────────────────────────────────────────────────
    // PASO 2 — Mostrar formulario de nueva contraseña
    // ──────────────────────────────────────────────────────────
    public function showNueva()
    {
        if (!$this->sesionValida()) {
            session()->forget(['recuperar_id', 'recuperar_nombre', 'recuperar_expira']);
            return redirect()->route('recuperar')
                ->withErrors(['matricula' => 'La sesión expiró o no es válida. Verifica tu identidad de nuevo.']);
        }

        return view('auth.nueva-contrasena', [
            'minutosRestantes' => $this->minutosRestantes(),
        ]);
    }

    // ──────────────────────────────────────────────────────────
    // PASO 2 — Guardar nueva contraseña
    // ──────────────────────────────────────────────────────────
    public function guardar(Request $request)
    {
        // Verificar sesión vigente antes de cualquier cosa
        if (!$this->sesionValida()) {
            session()->forget(['recuperar_id', 'recuperar_nombre', 'recuperar_expira']);
            return redirect()->route('recuperar')
                ->withErrors(['matricula' => 'La sesión expiró. Verifica tu identidad de nuevo.']);
        }

        // Rate limiting para el guardado también
        $key = 'recuperar.guardar:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $segundos = RateLimiter::availableIn($key);
            return back()->withErrors([
                'password' => "Demasiados intentos. Espera {$segundos} segundos."
            ]);
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $usuario = Usuario::find(session('recuperar_id'));

        if (!$usuario) {
            session()->forget(['recuperar_id', 'recuperar_nombre', 'recuperar_expira']);
            return redirect()->route('recuperar')
                ->withErrors(['matricula' => 'Sesión inválida. Intenta de nuevo.']);
        }

        $usuario->update([
            'password' => Hash::make($request->password),
        ]);

        // Limpiar todo
        RateLimiter::clear($key);
        session()->forget(['recuperar_id', 'recuperar_nombre', 'recuperar_expira']);

        return redirect()->route('login')
            ->with('status', '¡Contraseña actualizada! Ya puedes iniciar sesión con tu nueva contraseña.');
    }

    // ──────────────────────────────────────────────────────────
    // Helpers privados
    // ──────────────────────────────────────────────────────────

    /**
     * Verifica que la sesión exista Y no haya expirado.
     */
    private function sesionValida(): bool
    {
        if (!session()->has('recuperar_id') || !session()->has('recuperar_expira')) {
            return false;
        }
        return now()->timestamp <= session('recuperar_expira');
    }

    /**
     * Minutos restantes de la sesión activa (para mostrar en vista).
     */
    private function minutosRestantes(): int
    {
        if (!session()->has('recuperar_expira')) return 0;
        return max(0, (int) ceil((session('recuperar_expira') - now()->timestamp) / 60));
    }
}
