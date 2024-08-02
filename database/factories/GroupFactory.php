<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Group;
use App\Models\Major;

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
