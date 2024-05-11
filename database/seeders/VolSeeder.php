<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vols')->insert([
            'leaving_from' => 1,
            'going_to'=>2,
            'departure'=> '2024-05-01 12:00:00',
            'access'=> '2024-05-01 12:30:00',
            'price'=> 20,
            'created_at' => now(),
        ]);
    }
}
