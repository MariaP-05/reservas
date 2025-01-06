<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       /* Categoria::create([
            'denominacion' => 'Limpieza'
        ]);

        Categoria::create([
            'denominacion' => 'Reparaciones y Mantenimiento'
        ]);

        Categoria::create([
            'denominacion' => 'Lavandería'
        ]);

        Categoria::create([
            'denominacion' => 'Impuestos y Servicios'
        ]);

        Categoria::create([
            'denominacion' => 'Sueldo'
        ]);

        Categoria::create([
            'denominacion' => 'Seguros'
        ]);

        Categoria::create([
            'denominacion' => 'Equipamiento'
        ]);

        Categoria::create([
            'denominacion' => 'Otros Gastos'
        ]);*/

        Categoria::create([
            'denominacion' => 'Alquiler Cabañas'
        ]);

    }
}
