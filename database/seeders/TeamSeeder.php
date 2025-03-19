<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('teams')->insert([
                'name' => '3-Team ' . $i,
                'coach_name' => 'Coach ' . (20 + $i),
                'user_id' => 20 + $i, 
                'tournament_id' => 3, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
