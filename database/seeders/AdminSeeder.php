<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('admin')->insert([
            'username' => 'Admin',
            'password' => bcrypt('Admin0.2024'),
        ]);

        DB::table('admin')->insert([
            'username' => 'moi',
            'password' => bcrypt('Admin.2024'),
        ]);

       
    }
}