<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;


class ClaseReserva extends Model
{
    /** @use HasFactory<\Database\Factories\ClaseReservaFactory> */
    use HasFactory;
    protected $table = 'clase_reservas';
    /* Fillable indica los campos que puedo rellenar de golpe*/
    protected $fillable = [
        'user_id',
        'clase_id',
        'fecha_clase',
    ];
    public function usuario()
    {

        return $this->belongsTo(User::class, 'user_id');
    }
    /* public function clase()
    {

        return $this->belongsTo(Clase::class, 'clase_id');
    }*/
    public function clase()
    {
        return $this->belongsTo(Clase::class, 'clase_id');
    }
}
