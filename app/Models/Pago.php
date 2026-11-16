<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    /** @use HasFactory<\Database\Factories\PagoFactory> */
    use HasFactory;

    // Campos que se pueden rellenar de golpe (mass assignment)
    protected $fillable = [
        'categoria',
        'usuario_id',
        'cuota_id',
        'importe',
        'fecha_pago',
        'metodo_pago',
        'referencia',
        'fecha_desde',
        'fecha_hasta',
    ];

    protected $casts = [
        'importe'     => 'decimal:2',
        'fecha_pago'  => 'date',
        'fecha_desde' => 'date',
        'fecha_hasta' => 'date',
    ];

    // Relaciones: un pago pertenece a un usuario y a una cuota (N:1)
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function cuota(): BelongsTo
    {
        return $this->belongsTo(Cuota::class, 'cuota_id');
    }
    
}
