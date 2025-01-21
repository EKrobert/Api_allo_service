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
            'username' => 'admin',
            'password' => bcrypt('Admin.2025'),
        ]);

        DB::table('admin')->insert([
            'username' => 'username',
            'password' => bcrypt('User.2025'),
        ]);

       
    }
}