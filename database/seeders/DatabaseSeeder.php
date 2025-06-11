<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed users
        $users = [
            [
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'name' => 'Admin User',
                'role' => 'admin',
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'email' => 'manager@example.com',
                'password' => Hash::make('password123'),
                'name' => 'Manager User',
                'role' => 'manager',
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'email' => 'user@example.com',
                'password' => Hash::make('password123'),
                'name' => 'Regular User',
                'role' => 'user',
                'active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('users')->insert($users);

        // Seed orders (random orders for each user)
        foreach (DB::table('users')->get() as $user) {
            DB::table('orders')->insert([
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
