<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => 3,
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'dob' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'chart_number' => fake()->randomNumber(),
        ];
    }
}
