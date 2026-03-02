<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate(['mensaje' => 'required|string|max:500']);

        $eventos = Evento::where('cupo_disponible', '>', 0)
            ->get()
            ->map(function ($e) {
                return "- {$e->nombre} | Categoría: {$e->categoria} | Lugar: {$e->lugar} | Cupos: {$e->cupo_disponible}";
            })
            ->join("\n");

        $system = "Eres un asistente amigable de AddedUT de la UTTEC. Ayuda a estudiantes con info sobre talleres. Talleres disponibles:\n{$eventos}\nResponde en español, breve y amigable.";

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                    'Content-Type'  => 'application/json',
                ])->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant',
                    'messages' => [
                        ['role' => 'system', 'content' => $system],
                        ['role' => 'user',   'content' => $request->mensaje],
                    ],
                    'max_tokens'  => 400,
                    'temperature' => 0.7,
                ]);

            if ($response->failed()) {
                \Log::error('Groq error: ' . $response->status() . ' - ' . $response->body());
                return response()->json(['respuesta' => 'Error: ' . $response->status()]);
            }

            $texto = $response->json()['choices'][0]['message']['content'] ?? 'Sin respuesta';
            return response()->json(['respuesta' => $texto]);

        } catch (\Exception $e) {
            \Log::error('Chatbot exception: ' . $e->getMessage());
            return response()->json(['respuesta' => 'Error: ' . $e->getMessage()]);
        }
    }
}


