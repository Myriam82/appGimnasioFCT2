<?php

namespace Database\Seeders;

use App\Models\Clase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ClaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Laravel carga ClaseFactory y carga sus valores por defecto
        Clase::factory()->create([
            'nombreClase' => 'Gap',
            'hora' => '18:00:00',
        ]);
    }
}
