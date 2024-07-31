<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\File;
use App\Models\Post;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $fileTypes = [
            'pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg',
            'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
            'mp3', 'wav', 'ogg', 'flac', 'aac',
            'mp4', 'avi', 'mov', 'mkv', 'webm',
            'zip', 'rar', 'tar', 'gz', '7z'
        ];

        return [
            'type' => fake()->randomElement($fileTypes),
            'url' => fake()->url(),
            'post_id' => Post::inRandomOrder()->first()->id,
        ];
    }
}