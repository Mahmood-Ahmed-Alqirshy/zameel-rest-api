<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'group_id' => Group::inRandomOrder()->first()->id,
            'isRepresenter' => fake()->boolean(),
        ];
    }
}
