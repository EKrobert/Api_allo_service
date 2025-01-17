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
        // Créer un utilisateur
        User::create([
            'firstname' => 'Robert',
            'lastname' => 'EZIAN',
            'phone' => '+2120781164633',
            'email' => 'robert@gmail.com',
            'username' => 'robert',
            'password' => Hash::make('Robert@'),
        ]);
    }
}
