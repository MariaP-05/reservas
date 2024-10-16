<?php

namespace Database\Seeders;

use App\Models\Estado_poliza;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Estado_polizasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        Estado_poliza::create([
            'denominacion' => 'Vigente',
            'icono' => 'bi bi-house-check-fill',
            'color' => 'green',
            
        ] );

        Estado_poliza::create([
            'denominacion' => 'Cancelada',
            'icono' => 'bi bi-house-x-fill',
            'color' => 'red',
            
        ] );
        

        Estado_poliza::create([
            'denominacion' => 'Renovada',
            'icono' => 'bi bi-houses-fill',
            'color' => 'Blue',
           
        ] );


        Estado_poliza::create([
            'denominacion' => 'Vencida',
            'icono' => 'bi bi-house-slash-fill',
            'color' => 'Yellow',

        ] );
    }
}
