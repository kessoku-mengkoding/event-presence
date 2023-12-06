<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
        [
            [
                'id' => Str::uuid(),
                'username' => Str::random(10),
                'email' => 'admin@admin.com',
                'password' => Hash::make('testtest'),
                'is_verified' => true,
                'is_admin' => true,
            ],
            [
                'id' => Str::uuid(),
                'username' => Str::random(10),
                'email' => 'test@test.com',
                'password' => Hash::make('testtest'),
                'is_verified' => true,
                'is_admin' => false,
            ],
            [
                'id' => Str::uuid(),
                'username' => Str::random(10),
                'email' => 'test2@test.com',
                'password' => Hash::make('testtest'),
                'is_verified' => true,
                'is_admin' => false,
            ]
        ]);
    }
}
