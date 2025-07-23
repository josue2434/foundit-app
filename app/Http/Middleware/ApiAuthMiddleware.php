<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado via sesión
        if (!$request->session()->has('authenticated') || !$request->session()->get('authenticated')) {
            return redirect()->route('login'); //redirigir al login si no está autenticado
        }

        // Verificar que tengamos datos del usuario
        if (!$request->session()->has('user')) { // si no hay datos del usuario en la sesión, redirigir al login
            return redirect()->route('login');
        }

        return $next($request); // continuar con la solicitud si todo está bien
    }
}
