<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profesion;

class ProfesionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profesion::insert([
            [
                'nombre' => 'Alergólogos/inmunólogos',
                'activo' => 1
            ],
            [
                'nombre' => 'Audiólogos',
                'activo' => 1
            ],
            [
                'nombre' => 'Cardiólogos',
                'activo' => 1
            ],
            [
                'nombre' => 'Cirujanos cardiotorácicos',
                'activo' => 1
            ],
            [
                'nombre' => 'Cirujanos plásticos',
                'activo' => 1
            ],
            [
                'nombre' => 'Dentistas',
                'activo' => 1
            ],
            [
                'nombre' => 'Dermatólogos',
                'activo' => 1
            ],
            [
                'nombre' => 'Fisioterapeutas',
                'activo' => 1
            ],
            [
                'nombre' => 'Neurocirujanos',
                'activo' => 1
            ],
            [
                'nombre' => 'Neurólogos',
                'activo' => 1
            ],
            [
                'nombre' => 'Obstetricia y la ginecología',
                'activo' => 1
            ],
            [
                'nombre' => 'Pediatras',
                'activo' => 1
            ],
            [
                'nombre' => 'Radiólogos',
                'activo' => 1
            ],
            [
                'nombre' => 'Trabajadores sociales',
                'activo' => 1
            ],
            [
                'nombre' => 'Traumatólogos',
                'activo' => 1
            ]
        ]);
    }
}
