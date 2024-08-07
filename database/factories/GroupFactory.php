<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Major;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'join_year' => fake()->numberBetween(2015, 2024),
            'major_id' => Major::inRandomOrder()->first()->id,
        ];
    }
}
