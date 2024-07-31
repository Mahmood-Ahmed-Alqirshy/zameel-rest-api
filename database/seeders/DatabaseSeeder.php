<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CollegesTableSeeder::class,
            DegreesTableSeeder::class,
            MajorsTableSeeder::class,
            SubjectsTableSeeder::class,
            MajorSubjectTableSeeder::class,
            RolesTableSeeder::class,
            StatusesTableSeeder::class,
            UsersTableSeeder::class,
            SubjectUserTableSeeder::class,
            GroupsTableSeeder::class,
            MembersTableSeeder::class,
            AppliesTableSeeder::class,
            PostsTableSeeder::class,
            FilesTableSeeder::class
        ]);
    }
}
