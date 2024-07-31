<?php

namespace Database\Factories;

use App\Models\College;
use App\Models\Group;
use App\Models\Major;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\Subject;
use App\Models\User;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Randomly select one of the taggable types
        $taggableType = fake()->randomElement([Group::class, Major::class, College::class, Subject::class, null]);

        // Determine the taggable ID based on the selected taggable type
        $taggableId = null;

        if ($taggableType) {
            $taggableModel = app($taggableType); // This will create an instance of App\Models\College
            $taggableId = $taggableModel->inRandomOrder()->first()->id;
        } else {
            $taggableType = 'General';
            $taggableId = 0;
        }

        return [
            'publisher_id' => User::inRandomOrder()->first()->id,
            'taggable_id' => $taggableId,
            'taggable_type' => $taggableType,
            'content' => fake()->paragraph(),
            'has_attachment' => fake()->boolean(),
        ];
    }
}
