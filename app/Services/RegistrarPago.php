<?php

namespace App\Services;

use App\Enums\EstadoCuota;
use App\Models\Cuota;
use App\Models\Pago;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrarPago
{
    public function __invoke(Cuota $cuota, array $datos, int $adminId): Pago
    {
        return DB::transaction(function () use ($cuota, $datos, $adminId) {
            $cuota = Cuota::lockForUpdate()->findOrFail($cuota->id);

            $pendiente = (int) round(($cuota->importe - $cuota->pagos()->sum('importe')) * 100);
            $importe   = (int) round($datos['importe'] * 100);

            if ($cuota->estado === EstadoCuota::Pagada || $importe > $pendiente) {
                throw ValidationException::withMessages([
                    'importe' => 'El importe supera lo pendiente de esta cuota.',
                ]);
            }

            $pago = $cuota->pagos()->create($datos + ['registrado_por' => $adminId]);

            if ($importe === $pendiente) {
                $cuota->update(['estado' => EstadoCuota::Pagada]);
            }

            return $pago;
        });
    }
}