<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('destinations')->insert([
            'name' => "Tunisie",
            'abbreviation_name' => "TUN",
            'created_at' => now(),
        ]);

        DB::table('destinations')->insert([
            'name' => "Roma",
            'abbreviation_name' => "ROM",
            'created_at' => now(),
        ]);
    }
}
