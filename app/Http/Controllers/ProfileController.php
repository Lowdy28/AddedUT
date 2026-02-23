<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = \App\Models\Usuario::find(Auth::id()); 
        $talleres = [];

        if ($user->rol === 'estudiante') {
            $user->load('inscripciones.evento'); 
        } elseif ($user->rol === 'profesor') {
            $talleres = \App\Models\Evento::where('creado_por', $user->id_usuario)->get();
        }

        return view('profile.perfil', compact('user', 'talleres'));
    }

    public function update(Request $request)
    {
        $user = \App\Models\Usuario::find(Auth::id());

        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email,' . $user->id_usuario . ',id_usuario',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'password' => 'nullable|min:6'
        ]);

        $user->nombre = $request->nombre;
        $user->email = $request->email;

        if ($request->hasFile('foto')) {
            if ($user->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $request->file('foto')->store('perfiles', 'public');
        }

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        if ($user->rol === 'profesor') {
            return redirect()->route('profesor.profile.edit')->with('success', '¡Perfil actualizado correctamente!');
        }

        return redirect()->route('estudiante.profile.edit')->with('success', '¡Perfil actualizado correctamente!');
    }
}