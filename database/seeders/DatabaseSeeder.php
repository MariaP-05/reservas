<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Estado_tarea;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      //  $this->call(UsersSeeder::class);
      $this->call(Estado_tareasSeeder::class);
      //  $this->call(CategoriasSeeder::class);
      //  $this->call(FormasPagoSeeder::class);
      // $this->call(ProvinciasSeeder::class);
      // $this->call(LocalidadesSeeder::class);
      // $this->call(Estado_reservasSeeder::class);
    }
}
