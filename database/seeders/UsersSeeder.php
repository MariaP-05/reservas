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
       /* User::create([
            'name' => 'Guadalupe',
            'email' => 'guadif.arroyo@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('altos123')
        ]);

        User::create([
            'name' => 'Roxana',
            'email' => 'petrocelliiglesias@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('altos123')
        ]);*/

        User::create([
            'name' => 'Federico',
            'email' => 'fedepistoni93@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('altos123')
        ]);

        User::create([
            'name' => 'Rodrigo',
            'email' => 'roy.fernandez127@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('altos123')
        ]);
    }
}
