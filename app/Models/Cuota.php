<?php

namespace App\Models;

use App\Enums\EstadoCuota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuota extends Model
{
    protected $fillable = [
        'user_id',
        'concepto',
        'importe',
        'fecha_vencimiento',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'importe' => 'decimal:2',
            'fecha_vencimiento' => 'date',
            'estado' => EstadoCuota::class,
        ];
    }

    // Una cuota pertenece a un usuario (N:1)
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Una cuota tiene muchos pagos (1:N)
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'cuota_id');
    }

    // Cuotas pendientes cuya fecha ya pasó
    public function scopeVencidas($query)
    {
        return $query->where('estado', EstadoCuota::Pendiente)
                     ->whereDate('fecha_vencimiento', '<', today());
    }

    public function getTotalPagadoAttribute(): string
    {
        return number_format($this->pagos->sum('importe'), 2, '.', '');
    }

    public function getPendienteAttribute(): string
    {
        return number_format($this->importe - $this->pagos->sum('importe'), 2, '.', '');
    }

    public function getEstaVencidaAttribute(): bool
    {
        return $this->estado === EstadoCuota::Pendiente && $this->fecha_vencimiento->isPast();
    }
}