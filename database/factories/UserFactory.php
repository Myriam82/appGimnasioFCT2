<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dni' => fake()->regexify('[0-9]{8}[A-Z]'),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'telefono' => fake()->numerify('#########'),
            'direccion' => fake()->address(),
            'rol'       => User::ROLE_USUARIO,
            'remember_token' => Str::random(10),
        ];
    }

    public function usuario(): static
{
    return $this->state(fn (array $attributes) => [
        'rol' => User::ROLE_USUARIO,
    ]);
}

public function administrador(): static
{
    return $this->state(fn (array $attributes) => [
        'rol' => User::ROLE_ADMINISTRADOR,
    ]);
}
}
