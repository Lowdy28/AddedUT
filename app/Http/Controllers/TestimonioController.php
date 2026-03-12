<?php

namespace App\Http\Controllers;

use App\Models\Testimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonioController extends Controller
{
    /**
     * El usuario autenticado guarda su testimonio.
     * Solo uno por usuario — si ya tiene, lo reemplaza.
     */
    public function store(Request $request)
    {
        $request->validate([
            'estrellas'  => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|min:10|max:300',
        ], [
            'estrellas.required'   => 'Selecciona una calificación.',
            'estrellas.min'        => 'La calificación mínima es 1 estrella.',
            'estrellas.max'        => 'La calificación máxima es 5 estrellas.',
            'comentario.required'  => 'Escribe tu opinión.',
            'comentario.min'       => 'Tu opinión debe tener al menos 10 caracteres.',
            'comentario.max'       => 'Máximo 300 caracteres.',
        ]);

        $usuario = Auth::user();

        // Solo estudiantes y profesores pueden opinar
        if (!in_array($usuario->rol, ['estudiante', 'profesor'])) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        // Upsert — un usuario, un testimonio
        Testimonio::updateOrCreate(
            ['id_usuario' => $usuario->id_usuario],
            [
                'estrellas'  => $request->estrellas,
                'comentario' => $request->comentario,
                'aprobado'   => false, // vuelve a moderación si edita
            ]
        );

        return response()->json([
            'message' => '¡Gracias por tu opinión! Será revisada por el administrador antes de publicarse.',
        ]);
    }

    /**
     * El usuario consulta si ya tiene un testimonio enviado.
     */
    public function miTestimonio()
    {
        $testimonio = Testimonio::where('id_usuario', Auth::id())->first();
        return response()->json($testimonio);
    }

    // ── ADMIN ────────────────────────────────────────────────

    /**
     * Admin ve todos los testimonios pendientes y aprobados.
     */
    public function index()
    {
        $pendientes = Testimonio::with('usuario')
            ->where('aprobado', false)
            ->latest()
            ->get();

        $aprobados = Testimonio::with('usuario')
            ->where('aprobado', true)
            ->latest()
            ->get();

        return view('admin.testimonios', compact('pendientes', 'aprobados'));
    }

    /**
     * Admin aprueba un testimonio.
     */
    public function aprobar(Testimonio $testimonio)
    {
        $testimonio->update(['aprobado' => true]);
        return back()->with('status', 'Testimonio aprobado y publicado.');
    }

    /**
     * Admin rechaza (elimina) un testimonio.
     */
    public function rechazar(Testimonio $testimonio)
    {
        $testimonio->delete();
        return back()->with('status', 'Testimonio eliminado.');
    }
}
