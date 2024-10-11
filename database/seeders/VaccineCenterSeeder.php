<?php

namespace Database\Seeders;

use App\Models\VaccineCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VaccineCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\VaccineCenter::factory(10)->create();

        for ($i = 0; $i < 10; $i++) {
            VaccineCenter::create([
                'name' => "Vaccine Center $i",
                'daily_limit' => $i,
            ]);
        }
    }
}
