<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CollegeSeeder::class,
            DegreeSeeder::class,
            MajorSeeder::class,
            SubjectSeeder::class,
            MajorSubjectSeeder::class,
            RoleSeeder::class,
            StatusSeeder::class,
            UserSeeder::class,
            SubjectUserSeeder::class,
            GroupSeeder::class,
            MemberSeeder::class,
            ApplySeeder::class,
            PostSeeder::class,
            FileSeeder::class
        ]);
    }
}
