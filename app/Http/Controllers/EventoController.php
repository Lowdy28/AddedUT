<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $eventos = Evento::with('creador')
            ->when($buscar, function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%")
                  ->orWhere('categoria', 'like', "%$buscar%");
            })
            ->orderBy('fecha_inicio', 'asc')
            ->paginate(15);

        return view('eventos.index', compact('eventos'));
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'nombre'       => 'required|string|max:150',
                'descripcion'  => 'nullable|string',
                'categoria'    => 'nullable|string|max:50',
                'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
                'fecha_inicio' => 'required|date',
                'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
                'cupos'        => 'required|integer|min:1',
                'lugar'        => 'nullable|string|max:150',
                'horario'      => 'nullable|string|max:100',
                'dias'         => 'nullable|string|max:150',
            ]);

            $rutaImagen = null;
            if ($request->hasFile('imagen')) {
                $rutaImagen = $request->file('imagen')->store('eventos', 'public');
            }

            $evento = Evento::create([
                'nombre'          => $data['nombre'],
                'descripcion'     => $data['descripcion'] ?? 'Sin descripción',
                'categoria'       => $data['categoria'] ?? 'General',
                'imagen'          => $rutaImagen,
                'cupos'           => $data['cupos'],
                'cupo_disponible' => $data['cupos'],
                'creado_por'      => Auth::id(),
                'fecha_inicio'    => $data['fecha_inicio'],
                'fecha_fin'       => $data['fecha_fin'],
                'lugar'           => $data['lugar'] ?? null,
                'horario'         => $data['horario'] ?? null,
                'dias'            => $data['dias'] ?? null,
            ]);

            return response()->json(['message' => 'Taller creado correctamente.'], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => collect($e->errors())->flatten()->first(),
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function show(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }

    public function update(Request $request, Evento $evento): JsonResponse
    {
        try {
            $data = $request->validate([
                'nombre'       => 'required|string|max:150',
                'descripcion'  => 'nullable|string',
                'categoria'    => 'nullable|string|max:50',
                'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
                'fecha_inicio' => 'required|date',
                'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
                'cupos'        => 'required|integer|min:1',
                'lugar'        => 'nullable|string|max:150',
                'horario'      => 'nullable|string|max:100',
                'dias'         => 'nullable|string|max:150',
            ]);

            $rutaImagen = $evento->imagen;
            if ($request->hasFile('imagen')) {
                // Eliminar la imagen anterior si existe
                if ($rutaImagen && Storage::disk('public')->exists($rutaImagen)) {
                    Storage::disk('public')->delete($rutaImagen);
                }
                $rutaImagen = $request->file('imagen')->store('eventos', 'public');
            }

            $diferencia       = $data['cupos'] - $evento->cupos;
            $nuevoCupoDisp    = max(0, ($evento->cupo_disponible ?? $evento->cupos) + $diferencia);

            $evento->update([
                'nombre'          => $data['nombre'],
                'descripcion'     => $data['descripcion'] ?? 'Sin descripción',
                'categoria'       => $data['categoria'] ?? 'General',
                'imagen'          => $rutaImagen,
                'cupos'           => $data['cupos'],
                'cupo_disponible' => $nuevoCupoDisp,
                'fecha_inicio'    => $data['fecha_inicio'],
                'fecha_fin'       => $data['fecha_fin'],
                'lugar'           => $data['lugar'] ?? null,
                'horario'         => $data['horario'] ?? null,
                'dias'            => $data['dias'] ?? null,
            ]);

            return response()->json(['message' => 'Taller actualizado correctamente.']);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => collect($e->errors())->flatten()->first(),
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Evento $evento): JsonResponse
    {
        try {
            if ($evento->imagen && Storage::disk('public')->exists($evento->imagen)) {
                Storage::disk('public')->delete($evento->imagen);
            }
            $evento->delete();
            return response()->json(['message' => 'Taller eliminado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'No se pudo eliminar: ' . $e->getMessage()], 500);
        }
    }
}
