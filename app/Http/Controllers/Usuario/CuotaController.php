<?php

namespace App\Http\Controllers\Usuario;

use App\Enums\EstadoCuota;
use App\Http\Controllers\Controller;
use App\Models\Cuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CuotaController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        $cuotas = $usuario->cuotas()
            ->withSum('pagos', 'importe')
            ->orderByDesc('fecha_vencimiento')
            ->paginate(10);

        $pendientes = $usuario->cuotas()
            ->where('estado', EstadoCuota::Pendiente)
            ->withSum('pagos', 'importe')
            ->get();

        $resumen = [
            'total_pendiente' => $pendientes->sum(fn ($c) => $c->importe - ($c->pagos_sum_importe ?? 0)),
            'vencidas'        => $usuario->cuotas()->vencidas()->count(),
        ];

        return view('usuario.cuotas.index', compact('cuotas', 'resumen'));
    }

    public function show(Cuota $cuota)
    {
        Gate::authorize('view', $cuota);

        $cuota->load('pagos');

        return view('usuario.cuotas.show', compact('cuota'));
    }
}