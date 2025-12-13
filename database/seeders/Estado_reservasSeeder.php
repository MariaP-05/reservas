<?php

namespace Database\Seeders;

use App\Models\Estado_reserva;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Estado_reservasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

   /*     Estado_reserva::create([
            'denominacion' => 'Pendiente',
            'icono' => 'bi bi-house-slash-fill',
            'color' => 'gray'
        ]);

        Estado_reserva::create([
            'denominacion' => 'Confirmada',
            'icono' => 'bi bi-houses-fill',
            'color' => 'Blue'

        ]);

        Estado_reserva::create([
            'denominacion' => 'Realizada',
            'icono' => 'bi bi-house-check-fill',
            'color' => 'green'
        ]);


        Estado_reserva::create([
            'denominacion' => 'Cancelada',
            'icono' => 'bi bi-house-x-fill',
            'color' => 'red'

        ]);*/

          Estado_reserva::create([
            'denominacion' => 'Pago Parcial',
            'icono' => 'bi bi-house-x-fill',
            'color' => 'yellow'

        ]);

          Estado_reserva::create([
            'denominacion' => 'Facturada',
            'icono' => 'bi bi-house-x-fill',
            'color' => 'gray'

        ]);
    }
}
