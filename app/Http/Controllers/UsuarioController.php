<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $usuarios = Usuario::when($buscar, function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%")
                  ->orWhere('correo', 'like', "%$buscar%")
                  ->orWhere('rol', 'like', "%$buscar%");
            })
            ->orderBy('id_usuario', 'desc')
            ->paginate(15);

        return view('usuarios.index', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:6',
            'rol' => 'required',
            'activo' => 'sometimes|boolean'
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'activo' => $request->activo ?? 1,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario creado correctamente',
                'usuario' => $usuario
            ]);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => "required|email|unique:usuarios,correo,$id,id_usuario",
            'rol' => 'required',
            'activo' => 'required|boolean',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->rol = $request->rol;
        $usuario->activo = $request->activo;

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente',
                'usuario' => $usuario
            ]);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
