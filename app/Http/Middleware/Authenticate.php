<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class Authenticate
{

    public function handle(Request $request, Closure $next, $from = null)
    {
        // dd($request->headers, $request);

        $bearerToken = session()->get('token');
        $response = Http::withHeaders([
            'Authorization' => "Bearer $bearerToken", // Pasar el token de autenticación
            'Accept' => "application/json",
            'Content-Type' => "application/json",
        ]);

        $response = $response->post(config('app.GATEWAY_URL') . "/api/login/checkLogin");

        // Si es privada NO está autenticado, enviamos a login
        if ($from == 'private') {
            // Verificar si la respuesta es exitosa y el usuario está autenticado
            if (!$response->successful() || empty($response['logged']) || $response['logged'] !== true) {
                session()->flush(); // Borrar sesión por seguridad

                if ($request->ajax()) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                return redirect()->route('login');
            }

        // Si es publica y No está autenticado, limpiamos la sesión
        } elseif ($from == 'public') {
            if (!$response->successful() || empty($response['logged']) || $response['logged'] !== true) {
                session()->flush();
            }
        }

        return $next($request);
    }
}
