<?php

namespace Database\Seeders;

use App\Models\Seccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Seccion::create([
            'denominacion' => 'Automotores'
        ] );

        Seccion::create([
            'denominacion' => 'Accidentes Personales'
        ] );

        Seccion::create([
            'denominacion' => 'Combinado Familiar'
        ] );
        Seccion::create([
            'denominacion' => 'Integral Comercio'
        ] );

        Seccion::create([
            'denominacion' => 'Integral Consorcio'
        ] );

        Seccion::create([
            'denominacion' => 'Caucion'
        ] );

        Seccion::create([
            'denominacion' => 'Vida Obligatorio'
        ] );

        Seccion::create([
            'denominacion' => 'Vida Colectivo'
        ] );

        Seccion::create([
            'denominacion' => 'Responsabilidad Civil'
        ] );

        

        Seccion::create([
            'denominacion' => 'Cascos'
        ] );
        Seccion::create([
            'denominacion' => 'Transporte'
        ] );
        Seccion::create([
            'denominacion' => 'Robo'
        ] );
        Seccion::create([
            'denominacion' => 'Incendio'
        ] );
        Seccion::create([
            'denominacion' => 'Mala Praxis'
        ] );
    }
}
