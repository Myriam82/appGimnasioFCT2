<?php

namespace Database\Seeders;
//Importa modelo User
use App\Models\User;
//Importa modelo Clase
use App\Models\Clase;
use App\Models\ClaseReserva;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ClaseReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea 10 usuarios, 10 clases, 10 reservas enlazando cada usuario con cada clase
        ClaseReserva::factory()->count(10)->create();
    }
}
