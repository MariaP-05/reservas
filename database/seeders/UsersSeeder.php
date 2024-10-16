<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Gustavo',
            'email' => 'Gustavo@Veiga.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('0501')
        ]);

        User::create([
            'name' => 'Roberto',
            'email' => 'Roberto@Cordoba.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('0501')
        ]);
    }
}
