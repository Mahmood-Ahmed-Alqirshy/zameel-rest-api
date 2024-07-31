<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all subject and user IDs
        $subjectIds = Subject::all()->pluck('id')->toArray();
        $userIds = User::where('role_id', 3)->pluck('id')->toArray();
        $SubjectUserPairs = [];

        for ($i = 0; $i < 50; $i++) {
            // Randomly pick subject and user IDs
            $subjectId = $subjectIds[array_rand($subjectIds)];
            $userId = $userIds[array_rand($userIds)];

            // Ensure unique pairs if needed
            $pairKey = $subjectId . '-' . $userId;
            if (!isset($SubjectUserPairs[$pairKey])) {
                $SubjectUserPairs[$pairKey] = ['subject_id' => $subjectId, 'user_id' => $userId];
            }

            // Insert unique pairs into the pivot table
            DB::table('subject_user')->insert(array_values($SubjectUserPairs));
        }
    }
}
