<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'pau.civill@gmail.com',
            'name' => 'Pau',
            'password' => Hash::make('password'), // es lo mismo que poner bcrypt('password), pero podría dejar de funcionar si Laravel cambiara la manera de gestionar las contraseñas.
        ]);
    }
}
