<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    protected $fillable = ['cuota_id', 'importe', 'fecha_pago', 'metodo', 'registrado_por'];

    protected function casts(): array
    {
        return [
            'importe' => 'decimal:2',
            'fecha_pago' => 'date',
        ];
    }

    public function cuota(): BelongsTo
    {
        return $this->belongsTo(Cuota::class, 'cuota_id');
    }

    public function registrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}