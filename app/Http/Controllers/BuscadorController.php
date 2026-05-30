<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BuscadorController extends Controller
{
    // Muestra la vista del buscador
    public function index()
    {
        return view('cpanel/buscador/indexbuscador'); 
    }

    // Procesa la petición a SerpApi
    public function buscar(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query) {
            return response()->json(['error' => 'No se proporcionó término de búsqueda'], 400);
        }

        $apiKey = '6e85ade412e39c7bed001364f097ea5ebad36aac87762c672435545bfcc9828b';
        
        $response = Http::get('https://serpapi.com/search.json', [
            'engine'  => 'google',
            'q'       => $query,
            'api_key' => $apiKey,
            'hl'      => 'es', // Idioma español
            'gl'      => 'mx'  // Geolocalización México
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json(['error' => 'Error al conectar con el servidor de búsqueda'], 500);
    }
}
