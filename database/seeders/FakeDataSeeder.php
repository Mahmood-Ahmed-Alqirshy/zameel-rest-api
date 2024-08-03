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
        $this->userSeeder();
        $this->subjectUserSeeder();
        $this->groupSeeder();
        $this->memberSeeder();
        $this->applySeeder();
        $this->postSeeder();
        $this->fileSeeder();
    }

    private function majorSubjectSeeder()
    {
        $majors = Major::all();
        foreach ($majors as $major) {
            $subjectsIds = Subject::inRandomOrder()->limit(5)->pluck('id')->toArray();
            $major->subjects()->sync($subjectsIds);
        }
    }

    private function userSeeder()
    {
        User::factory(100)->create();
    }

    private function subjectUserSeeder()
    {
        $users = User::where('role_id', 3)->get();
        foreach ($users as $user) {
            $subjectsIds = Subject::inRandomOrder()->limit(rand(1, 8))->pluck('id')->toArray();
            $user->subjects()->sync($subjectsIds);
        }
    }

    private function groupSeeder()
    {
        Group::factory(20)->create();
    }

    private function memberSeeder()
    {
        Member::factory(50)->create();
    }

    private function applySeeder()
    {
        Apply::factory(50)->create();
    }

    private function postSeeder()
    {
        Post::factory(50)->create();
    }

    private function fileSeeder()
    {
        File::factory(100)->create();
    }
}
