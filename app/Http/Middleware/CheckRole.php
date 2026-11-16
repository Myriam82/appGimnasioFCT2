<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Maneja las peticiones entrantes y verifica que el usuario tenga el rol requerido.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        } else {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Verificar si el usuario tiene el rol requerido
            if ($user->rol !== $rol) {
                // Si no tiene el rol correcto, redirigir al dashboard con mensaje de error
                return redirect()->route('dashboard')
                    ->with('error', 'No tienes permisos para acceder a esta sección.');
            } else {
                // Si tiene el rol correcto, permitir que continúe la petición
                return $next($request);
            }
        }
    }
}
