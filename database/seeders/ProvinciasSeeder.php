<?php

namespace Database\Seeders;

use App\Models\Provincia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Provincia::create([
            'nombre' => 'Buenos Aires'
        ] );

        Provincia::create([
            'nombre' => 'Santa Fe'
        ] );

        
    }
}
