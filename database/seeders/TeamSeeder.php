<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('teams')->insert([
                'name' => 'Team ' . $i,
                'coach_name' => 'Coach ' . $i,
                'user_id' => 1, // Gán user_id cố định
                'tournament_id' => rand(1, 9), // Giả sử bảng tournaments có 9 giải
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
