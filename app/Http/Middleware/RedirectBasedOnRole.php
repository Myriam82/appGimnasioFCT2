<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request):
     * (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ?string $rol = null): Response
    {
        // Si llegamos a la ruta 'dashboard', redirigimos según el rol
        if ($request->routeIs('dashboard') && Auth::check()) {
            if (Auth::user()->rol === 'usuario') {
                return redirect()->route('usuario.dashboard');
            } else {
                return redirect()->route('administrador.dashboard');
            }
        }
        // Si se especificó un rol requerido, verificamos que el usuario vaya a la página de
        //su rol
        if ($rol !== null && Auth::check() && Auth::user()->rol !== $rol) {
            // Redirigir al dashboard correspondiente al rol del usuario
            return redirect()->route(Auth::user()->rol . '.dashboard');
        }
        return $next($request);
    }
}
