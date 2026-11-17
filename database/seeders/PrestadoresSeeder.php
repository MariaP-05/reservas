<?php

namespace Database\Seeders;

use App\Models\CotizacionMoneda;
use App\Models\Estado_reserva;
use App\Models\Prestador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrestadoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        
       /*  Prestador::create([
            'nombre' => 'Guadalupe Fernandez Arroyo',
            'razon_social' => 'Alto de Las Pampas',
            'domicilio' => 'J.B JUSTO 59 - San Nicolas - Buenos Aires',
            'cuit' => '27382923427',
            'cert' => 'certtest',
            'key' => 'keytest',
            'token' => 'WwUZ9RsPtwVWLj402lIy8GggVTkah4khTmfWbGjnLGEYjxSxiTOqREbR4ocTRWCi',
            'iva' => 6,
            'iva_denominacion' => 'Responsable Monotributo',
            'fecha_inicio_actividad' => '2021-10-14',
        ]);
CotizacionMoneda::create([
            'fecha' => '2026-01-01',
            'usd' => 1300,
        ]);*/
         
          

     Prestador::create([
            'nombre' => 'Rodrigo Fernandez Arroyo',
            'razon_social' => 'Alto de Las Pampas',
            'domicilio' => 'J.B JUSTO 59 - San Nicolas - Buenos Aires',
            'cuit' => '20368934276',
            'cert' => 'certprdrodri',
            'key' => 'keyprd',
            'token' => 'WwUZ9RsPtwVWLj402lIy8GggVTkah4khTmfWbGjnLGEYjxSxiTOqREbR4ocTRWCi',
            'iva' => 6,
            'iva_denominacion' => 'Responsable Monotributo',
            'fecha_inicio_actividad' => '2023-11-01',
            //fsk_prod_b2Tbl2JpDH6yfIrAYfzuusC0MH8Jk33I14HpwSoH
        ]); 
    }
}
