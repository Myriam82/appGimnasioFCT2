<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Clase;
use App\Models\ClaseReserva;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
        $totalClases = Clase::count();
        $totalReservas = ClaseReserva::count();
        return view('administrador.dashboard', compact('totalUsuarios', 'totalClases', 'totalReservas'));
    }
}
