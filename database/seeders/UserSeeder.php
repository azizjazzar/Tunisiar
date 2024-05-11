<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => "Maroua Admin",
            'email' => "marouayed1992@gmail.com",
            'password' => bcrypt('123456789'),
            'created_at' => now(),
        ]);
    }
}
