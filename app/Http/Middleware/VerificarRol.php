<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        // Comprobar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Obtener el usuario autenticado
        $usuario = Auth::user();

        // Comprobar si tiene el rol requerido
        if (strtolower($usuario->rol?->nombre ?? '') !== strtolower($rol)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        // Permitir el acceso
        return $next($request);
    }
}
