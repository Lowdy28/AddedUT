<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RegistroController extends Controller
{
    public function mostrarFormulario()
    {
        return view('auth.register');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre'               => 'required|string|max:100',
            'email'                => 'required|email|unique:usuarios,email',
            'password'             => 'required|string|min:6|confirmed',
            'terms'                => 'accepted',
        ], [
            'nombre.required'      => 'El nombre es obligatorio.',
            'email.required'       => 'El correo institucional es obligatorio.',
            'email.unique'         => 'Este correo ya esta registrado.',
            'password.min'         => 'La contrasena debe tener al menos 6 caracteres.',
            'password.confirmed'   => 'Las contrasenas no coinciden.',
            'terms.accepted'       => 'Debes aceptar los terminos y condiciones.',
        ]);

        $email = strtolower(trim($request->email));
        if (!str_ends_with($email, '@uttec.edu.mx')) {
            throw ValidationException::withMessages([
                'email' => 'Solo se permiten correos institucionales (@uttec.edu.mx).',
            ]);
        }

        $matricula = explode('@', $email)[0];

        $rol = Usuario::detectarRolPorMatricula($matricula);

        if ($rol === null) {
            throw ValidationException::withMessages([
                'email' => 'La matricula "' . $matricula . '" no tiene un formato reconocido. '
                         . 'Estudiantes: 10 digitos (ej. 2523260044@uttec.edu.mx). '
                         . 'Profesores: letra(s) + digitos (ej. P2301@uttec.edu.mx).',
            ]);
        }

        // Verificar que la matricula no este ya registrada
        if (Usuario::where('matricula', $matricula)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Esta matricula ya tiene una cuenta registrada.',
            ]);
        }

        $usuario = Usuario::create([
            'nombre'          => $request->nombre,
            'matricula'       => $matricula,
            'email'           => $email,
            'password'        => Hash::make($request->password),
            'rol'             => $rol,
            'activo'          => true,
            'fecha_registro'  => now(),
        ]);

        Auth::login($usuario);

        if ($rol === 'admin')      return redirect()->route('dashboard');
        if ($rol === 'profesor')   return redirect()->route('profesor.dashboard');
        if ($rol === 'estudiante') return redirect()->route('estudiante.dashboard');

        return redirect()->route('dashboard');
    }
}
