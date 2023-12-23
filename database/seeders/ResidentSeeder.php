<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $residents = [];

        for ($i = 0; $i < 20; $i++) {
            $residents[] = [
                'id' => $faker->uuid,
                'full_name' => $faker->name,
                'nik' => $faker->numerify('##############'), // 16-digit numeric value
                'kk' => $faker->numerify('##############'), // 16-digit numeric value
                'address' => $faker->address,
            ];
        }

        DB::table('residents')->insert($residents);
    }
}
