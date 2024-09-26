<?php

namespace Database\Factories;

use App\Models\College;
use App\Models\Degree;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Major>
 */
class MajorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'college_id' => College::inRandomOrder()->first()->id,
            'degree_id' => Degree::inRandomOrder()->first()->id,
            'years' => 4,
        ];
    }
}
