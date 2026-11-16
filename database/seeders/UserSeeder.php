<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use database\factories\UserFactory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();
        User::factory(2)->usuario()->create();
        User::factory(10)->administrador()->create();

        User::create([

            'dni' => '56566',
            'name' => 'Usuario',
            'email' => 'Usuario@usuario.com',
            'password' => Hash::make('usuario'),
            'telefono' => 'Usuario',
            'direccion' => 'Usuario',
            'rol' => User::ROLE_USUARIO,

        ]);


        User::create([

            'dni' => '88475t',
            'name' => 'Admin',
            'email' => 'Admin@usuario.com',
            'password' => Hash::make('administrador'),
            'telefono' => 'Admin',
            'direccion' => 'Admin',
            'rol' => User::ROLE_ADMINISTRADOR,

        ]);
    }
}
