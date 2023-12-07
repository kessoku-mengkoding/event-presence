<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('users')->insert(
        [
            [
                'id' => Str::uuid(),
                'username' => $faker->userName,
                'email' => 'admin@admin.com',
                'password' => Hash::make('testtest'),
                'is_verified' => true,
                'is_admin' => true,
            ],
            [
                'id' => Str::uuid(),
                'username' => $faker->userName,
                'email' => 'test@test.com',
                'password' => Hash::make('testtest'),
                'is_verified' => true,
                'is_admin' => false,
            ],
        ]);
    }
}
