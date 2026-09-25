<?php

namespace Database\Seeders;

use App\Models\Estado_tarea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Estado_tareasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Estado_tarea::create([
            'denominacion' => 'Pendiente',
            'icono' => 'bi bi-house-slash-fill',
            'color' => 'gray'
        ]);

        Estado_tarea::create([
            'denominacion' => 'En Proceso',
            'icono' => 'bi bi-houses-fill',
            'color' => 'Blue'

        ]);

        Estado_tarea::create([
            'denominacion' => 'Realizada',
            'icono' => 'bi bi-house-check-fill',
            'color' => 'green'
        ]);

        Estado_tarea::create([
            'denominacion' => 'En Espera',
            'icono' => 'bi bi-house-x-fill',
            'color' => 'orange'

        ]);

        Estado_tarea::create([
            'denominacion' => 'Cancelada',
            'icono' => 'bi bi-house-x-fill',
            'color' => 'red'

        ]);

    }
}