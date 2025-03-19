<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [];
        
        for ($i = 1; $i <= 100; $i++) {
            $users[] = [
                'name' => "User $i",
                'email' => "user$i@gmail.com",
                'password' => Hash::make('123456789'),
                'verification_token' => null,
                'reset_token' => null,
                'role' => 'user',
                'email_verified_at' => now(),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('users')->insert($users);
    }
}