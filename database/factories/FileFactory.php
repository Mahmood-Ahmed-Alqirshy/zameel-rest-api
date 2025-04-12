<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition(): array
    {
        $imageTypes = [
            'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg',
        ];
        $fileTypes = [
            'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
            'mp3', 'wav', 'ogg', 'flac', 'aac',
            'mp4', 'avi', 'mov', 'mkv', 'webm',
            'zip', 'rar', 'tar', 'gz', '7z',
        ];

        $types = [$imageTypes, $fileTypes];
        $typeNumber = fake()->numberBetween(0, 1);
        $ext = fake()->randomElement($types[$typeNumber]);

        return [
            'type' => ['image', 'file'][$typeNumber],
            'ext' => $ext,
            'name' => fake()->name().'.'.$ext,
            'url' => fake()->url(),
            'post_id' => Post::inRandomOrder()->first()->id,
        ];
    }
}
