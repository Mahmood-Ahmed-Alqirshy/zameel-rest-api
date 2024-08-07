<?php

namespace Database\Seeders;

use App\Models\Apply;
use App\Models\File;
use App\Models\Group;
use App\Models\Major;
use App\Models\Member;
use App\Models\Post;
use App\Models\Subject;
use App\Models\User;

class FakeDataSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->majorSubjectSeeder();

        User::factory(100)->create();

        $this->subjectUserSeeder();

        Group::factory(20)->create();

        Member::factory(50)->create();

        Apply::factory(50)->create();

        Post::factory(50)->create();

        File::factory(100)->create();
    }

    private function majorSubjectSeeder()
    {
        $majors = Major::all();
        foreach ($majors as $major) {
            $subjectsIds = Subject::inRandomOrder()->limit(5)->pluck('id')->toArray();
            $major->subjects()->sync($subjectsIds);
        }
    }

    private function subjectUserSeeder()
    {
        $users = User::where('role_id', 3)->get();
        foreach ($users as $user) {
            $subjectsIds = Subject::inRandomOrder()->limit(rand(1, 8))->pluck('id')->toArray();
            $user->subjects()->sync($subjectsIds);
        }
    }
}
