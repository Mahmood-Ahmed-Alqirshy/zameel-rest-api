<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class MajorSubjectSeeder extends Seeder
{
    public function run(): void
    {
        $majors = Major::all();
        foreach ($majors as $major) {
            $subjectsIds = Subject::inRandomOrder()->limit(5)->pluck('id')->toArray();
            $major->subjects()->sync($subjectsIds);
        }
    }
}
