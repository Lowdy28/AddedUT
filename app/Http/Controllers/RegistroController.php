<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistroController extends Controller
{
    public function mostrarFormulario()
    {
        return view('registro');
    }

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'matricula' => 'required|string|max:20',
            'area_academica' => 'required|string',
            'cuatrimestre' => 'required|numeric|min:1|max:10',
            'turno' => 'required|string',
            'genero' => 'required|string',
            'edad' => 'required|numeric|min:15|max:99',
        ]);

        $data = $request->only([
            'nombre',
            'matricula',
            'area_academica',
            'cuatrimestre',
            'turno',
            'genero',
            'edad'
        ]);

        $registro = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(storage_path('app/registros_estudiantes.txt'), $registro.PHP_EOL, FILE_APPEND);

        return redirect()->back()->with('mensaje', '¡Registro guardado exitosamente!');
    }
}