<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Clase;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clase>
 */
class ClaseFactory extends Factory
{
    public function definition(): array
    {
        // Generamos una hora de inicio aleatoria
        $horaInicio = fake()->time('H:i:s');

        // Sumamos entre 1 y 2 horas para la hora fin
        $horaFin = date('H:i:s', strtotime($horaInicio . ' + ' . rand(1, 2) . ' hours'));

        return [
            'user_id' => User::factory(),
            'nombreClase' => fake()->randomElement(['Yoga', 'Pilates', 'Crossfit', 'Zumba', 'Gap']),
            'categoria' => fake()->randomElement(['Cardio', 'Fuerza', 'Flexibilidad']),
            'diaDeLaSemana' => fake()->randomElement(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes']),
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
            'capacidad_maxima' => fake()->numberBetween(10, 30),
            'estado' => fake()->randomElement(['activa', 'inactiva']),
        ];
    }
}
