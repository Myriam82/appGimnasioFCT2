<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Clase extends Model
{
    /** @use HasFactory<\Database\Factories\ClaseFactory> */
    use HasFactory;
    // protected $table = 'clases', sería necesario si fuese a llamarlo de forma diferente;
    // Fillable indica los campos que puedo rellenar de golpe
    protected $fillable = [
        'nombreClase',
        'categoria',
        'diaDeLaSemana',
        'hora_inicio',
        'hora_fin',
        'capacidad_maxima',
        'estado',
        'user_id',
        'fecha_desde',
        'fecha_hasta',

    ];

    //Relaciones entre tablas hasMany 1:N, belongsToMany N:N

    public function reservas()
    {
        return $this->hasMany(ClaseReserva::class, 'clase_id');
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'clase_reservas', 'clase_id', 'user_id');
    }
    protected static function booted()
    {
        static::saving(function ($clase) {
            $clase->diaDeLaSemana = strtolower(str_replace(
                ['á', 'é', 'í', 'ó', 'ú'],
                ['a', 'e', 'i', 'o', 'u'],
                trim($clase->diaDeLaSemana)
            ));
        });
    }
}
