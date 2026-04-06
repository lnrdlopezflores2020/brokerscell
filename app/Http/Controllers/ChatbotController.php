<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('cpanel/Chatbot/Chatbot');
    }

    public function sendMessage(Request $request)
    {
        try {
            $mensajeUsuario = $request->input('message');
            $apiKey = env('GEMINI_API_KEY');

            if(empty($apiKey)) {
                return response()->json(['reply' => 'Error: No hay API Key configurada en .env'], 500);
            }

            // AGREGAMOS 'withoutVerifying()' PARA EVITAR ERROR DE CERTIFICADO EN XAMPP
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            // Tu contexto (resumido aquí por espacio, úsalo completo)
                            ['text' => "Eres 'SoluxBot', el asistente virtual experto de SoluxMovil.
                                        Tu tono es: Amable, profesional y breve. Usas emojis ocasionalmente.

                                        Tus instrucciones:
                                        1. Solo respondes sobre reparaciones de celulares. Si te hablan de otra cosa, diles amablemente que solo sabes de tecnología.
                                        2. Si el cliente pregunta por un precio, búsucalo en la SIGUIENTE LISTA. Si no está, diles que necesitan revisión técnica (costo $100).

                                        LISTA DE PRECIOS BASE (Mano de obra + Pieza):
                                        - Cambio de Pantalla iPhone X/11/12: $1,500
                                        - Cambio de Pantalla Samsung Serie A: $1,200
                                        - Cambio de Batería General: $800
                                        - Centro de Carga (Soldadura): $500
                                        - Mantenimiento/Limpieza (Mojados): $600
                                        - Revisión General: $100 (Se abona si reparan).

                                        IMPORTANTE:
                                        - Siempre menciona que el precio es estimado y sujeto a revisión física.
                                        - Al final, invita al cliente a ir al taller o agendar cita. \n\n Pregunta: " . $mensajeUsuario]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'La IA respondió vacío.';
                return response()->json(['reply' => nl2br($botReply)]);
            } else {
                // ESTO NOS DIRÁ EL ERROR REAL DE GOOGLE EN LA CONSOLA
                return response()->json(['reply' => 'Error API: ' . $response->body()], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['reply' => 'Error del Servidor: ' . $e->getMessage()], 500);
        }
    }
}
