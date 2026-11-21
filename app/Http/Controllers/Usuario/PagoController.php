<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $pagos = $request->user()->pagos()
            ->with('cuota')
            ->orderByDesc('pagos.fecha_pago')
            ->paginate(10);

        return view('usuario.pagos.index', compact('pagos'));
    }
}