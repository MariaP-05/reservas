<?php

namespace Database\Seeders;

use App\Models\Forma_pago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormasPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Forma_pago::create([
            'denominacion' => 'Transferencias'
        ] );

        Forma_pago::create([
            'denominacion' => 'Debito Tarjeta'
        ] );

        Forma_pago::create([
            'denominacion' => 'Efectivo'
        ] );

        Forma_pago::create([
            'denominacion' => 'Debito CBU'
        ] );

        Forma_pago::create([
            'denominacion' => 'Crédito Tarjeta'
        ] );
       
    }
}
