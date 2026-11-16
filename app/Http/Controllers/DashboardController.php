<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(Request $request) //:View|RedirectResponse
    {
        //Obtiene el usuario que ha iniciado sesión, es el equivalente a auth()->user().
        $user = $request->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.user.index');
            //Este pertenece al web.php en resource que vaya al index admin.user.index o cliente.pedidos.index, son alias a los 
            //que me llevan y tienen que estar definidos en web.php
            //return view('administrador.dashboard');
        }

        if ($user->isUsuario()) {
            $proximasClases = $user->clasesReservadas()
                ->where('clases.hora_inicio', '>=', now())
                ->orderBy('clases.hora_inicio', 'asc')
                ->take(5)
                ->get();

            return view('usuario.dashboard', [
                'proximasClases' => $proximasClases,
            ]);
        }
        return redirect()->route('login')->with('error', 'Rol de usuario no válido');
    }
}
