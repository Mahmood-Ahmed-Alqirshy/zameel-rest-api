<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubjectUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role_id', 3)->get();
        foreach ($users as $user) {
            $subjectsIds = Subject::inRandomOrder()->limit(rand(1,8))->pluck('id')->toArray();
            $user->subjects()->sync($subjectsIds);
        }
    }
}
