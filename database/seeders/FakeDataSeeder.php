<?php

namespace Database\Seeders;

use App\Models\Apply;
use App\Models\File;
use App\Models\Group;
use App\Models\Member;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FakeDataSeeder extends BaseSeeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);

        User::factory(100)->create();

        Group::factory(20)->create();

        Member::factory(50)->create();

        Apply::factory(50)->create();

        Post::factory(50)->create();

        File::factory(100)->create();
    }
}
