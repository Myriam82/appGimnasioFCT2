<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ClaseReserva;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clases_reserva>
 */
class ClasesReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => UserFactory::factory(),
            'clase_id' => ClaseFactory::factory(),
        ];
    }
}
