<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /** constantes */
    const ROLE_USUARIO = 'usuario';
    const ROLE_ADMINISTRADOR = 'administrador';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';
    /* Fillable indica los campos que puedo rellenar de golpe*/
    protected $fillable = [

        'dni',
        'name',
        'email',
        'password',
        'telefono',
        'direccion',
        'rol',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Relaciones entre tablas
    public function reservas()
    {
        return $this->hasMany(ClaseReserva::class, 'user_id');
    }
    public function clasesReservadas()
    {

        return $this->belongsToMany(Clase::class, 'clase_reservas', 'user_id', 'clase_id');
    }

    public function isAdmin(): bool
    {
        return $this->rol === self::ROLE_ADMINISTRADOR;
    }
    public function isUsuario(): bool
    {
        return $this->rol === self::ROLE_USUARIO;
    }
    // En User.php y en Cuota.php


public function pagos(): HasManyThrough
{
    return $this->hasManyThrough(Pago::class, Cuota::class, 'user_id', 'cuota_id');
}



public function cuotas(): HasMany
{
    return $this->hasMany(Cuota::class, 'user_id');
}
}
