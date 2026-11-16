<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Clase;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClaseReserva>
 */
class ClaseReservaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'user_id' => User::factory(),
            'clase_id' => Clase::factory(),
        ];
    }
}
