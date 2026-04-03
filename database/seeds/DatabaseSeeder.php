<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default super admin user
        DB::table('users')->insertOrIgnore([
            'name'       => 'Administrator',
            'username'   => 'admin',
            'email'      => 'admin@lipakodi.co.ke',
            'password'   => Hash::make('Admin@1234'),
            'is_super'   => 1,
            'is_admin'   => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
