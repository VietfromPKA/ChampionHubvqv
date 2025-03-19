<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StadiumSeeder extends Seeder
{
    public function run()
    {
        $stadiums = [];

        for ($i = 1; $i <= 10; $i++) {
            $stadiums[] = [
                'name' => "Stadium $i",
                'phone' => "123-456-789$i",
                'description' => "Description for Stadium $i",
                'location' => "Location $i",
                'price_per_hour' => rand(100, 500),
                'field_count' => rand(1, 5),
                'encrypted_image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('stadiums')->insert($stadiums);
    }
}