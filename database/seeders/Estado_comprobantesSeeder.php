<?php

namespace Database\Seeders;

use App\Models\Estado_comprobante;
use App\Models\Tipo_comprobante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Estado_comprobantesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Estado_comprobante::create([
            'denominacion' => 'Pendiente',
            'icono' => 'bi bi-house-slash-fill',
            'color' => 'gray'
        ]);
         Estado_comprobante::create(
        [
            'denominacion' => 'Facturado',
            'icono' => 'bi bi-houses-fill',
            'color' => 'Blue'

        ]);
        Estado_comprobante::create([
            'denominacion' => 'Cobrado',
            'icono' => 'bi bi-house-check-fill',
            'color' => 'green'
        ]);
        Estado_comprobante::create([
            'denominacion' => 'En Espera',
            'icono' => 'bi bi-house-x-fill',
            'color' => 'orange'

        ]);
        Estado_comprobante::create([
            'denominacion' => 'Cancelado',
            'icono' => 'bi bi-house-x-fill',
            'color' => 'red'

        ]
        
        );

        Tipo_comprobante::create([
            
            'denominacion' => 'Factura A',
            'codigo' => '1' 

        ]);
         Tipo_comprobante::create([
            'denominacion' => 'Nota de débito A',
            'codigo' => '2' 
        ]);
         Tipo_comprobante::create([
            'denominacion' => 'Nota de crédito A',
            'codigo' => '3' 
        ]);
            Tipo_comprobante::create([
                'denominacion' => 'Recibo A',
                'codigo' => '4'
            ]);
         Tipo_comprobante::create([
            'denominacion' => 'Nota de venta al contado A',
            'codigo' => '5' 

        ]);
         Tipo_comprobante::create([
            'denominacion' => 'Factura B',
            'codigo' => '6' 

        ]);
         Tipo_comprobante::create([
            'denominacion' => 'Nota de débito B',
            'codigo' => '7' 

        ]);
         Tipo_comprobante::create([
            'denominacion' => 'Nota de crédito B',
            'codigo' => '8' 

        ]);
         Tipo_comprobante::create([
            'denominacion' => 'Recibo B',
            'codigo' => '9' 

        ]);
         Tipo_comprobante::create([
            'denominacion' => 'Nota de venta al contado B',
            'codigo' => '10' 

        ] 
        );
         
    }
}