<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TransitController extends Controller
{
    public function someApiEndpoint(Request $request)
    {
        // Verificar la autenticación
        if (!$request->user()) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Verificar la autorización (puedes personalizar esto según tus roles/permisos)
        if (!$request->user()->hasRole('transit_user')) {
            return response()->json(['error' => 'No autorizado para acceder a este recurso'], 403);
        }

        // Puedes usar el token para hacer solicitudes a la API de Almacén
        $response = Http::withToken($request->user()->token)->get('http://api-store.example.com/some-endpoint');

        return response()->json(['data' => $response->json()]);
    }
}
