<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuota extends Model
{
    // Una cuota tiene muchos pagos (1:N)
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'cuota_id');
    }
}