<?php

namespace Database\Factories;

use App\Models\VaccineCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VaccineCenter>
 */
class VaccineCenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dailyLimit = $this->faker->numberBetween(1, 10);
        return [
            'name' => "Vaccine Center $dailyLimit",
            'daily_limit' => $dailyLimit,
        ];
    }
}
