<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TournamentSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 9; $i++) {
            DB::table('tournaments')->insert([
                'user_id' => 1, // Gán cố định user_id = 1
                'name' => 'Tournament ' . $i,
                'start_date' => now()->addDays(rand(1, 30)),
                'end_date' => now()->addDays(rand(31, 60)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
