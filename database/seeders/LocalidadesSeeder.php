<?php

namespace Database\Seeders;

use App\Models\Localidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Localidad::create([
            'denominacion' => 'San Nicolás de los Arroyos',
            'cod_postal' => '2900',
            'provincia_id' => '1'
        ] );

        Localidad::create([
            'denominacion' => 'Ramallo',
            'cod_postal' => '2915',
            'provincia_id' => '1'
        ] );

        Localidad::create([
            'denominacion' => 'San Pedro',
            'cod_postal' => '2930',
            'provincia_id' => '1'
        ] );

        Localidad::create([
            'denominacion' => 'Baradero',
            'cod_postal' => '2942',
            'provincia_id' => '1'
        ] );

        Localidad::create([
            'denominacion' => 'San Antonio de Areco',
            'cod_postal' => '2760',
            'provincia_id' => '1'
        ] );

        Localidad::create([
            'denominacion' => 'Junin',
            'cod_postal' => '6000',
            'provincia_id' => '1'
        ] );

        Localidad::create([
            'denominacion' => 'Pergamino',
            'cod_postal' => '2700',
            'provincia_id' => '1'
        ] );

        Localidad::create([
            'denominacion' => 'Rosario',
            'cod_postal' => '2000',
            'provincia_id' => '2'
        ] );

        Localidad::create([
            'denominacion' => 'Santa Fe',
            'cod_postal' => '3000',
            'provincia_id' => '2'
        ] );

        Localidad::create([
            'denominacion' => 'Alcorta',
            'cod_postal' => '2117',
            'provincia_id' => '2'
        ] );
       
        Localidad::create([
            'denominacion' => 'Venado Tuerto',
            'cod_postal' => '2600',
            'provincia_id' => '2'
        ] );
    }
}
