<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genero;

class GenerosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genero::insert([
            [
                'nombre' => 'Masculino',
                'activo' => 1
            ],
            [
                'nombre' => 'Femenino',
                'activo' => 1
            ],
            [
                'nombre' => 'Otro',
                'activo' => 1
            ]
        ]);
    }
}
