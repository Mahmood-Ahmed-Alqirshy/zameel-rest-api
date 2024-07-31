<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all major and subject IDs
        $majorIds = Major::all()->pluck('id')->toArray();
        $subjectIds = Subject::all()->pluck('id')->toArray();

        $majorSubjectPairs = [];

        for ($i = 0; $i < 100; $i++) {
            // Randomly pick major and subject IDs
            $majorId = $majorIds[array_rand($majorIds)];
            $subjectId = $subjectIds[array_rand($subjectIds)];

            // Ensure unique pairs if needed
            $pairKey = $majorId . '-' . $subjectId;
            if (!isset($majorSubjectPairs[$pairKey])) {
                $majorSubjectPairs[$pairKey] = ['major_id' => $majorId, 'subject_id' => $subjectId];
            }
        }

        // Insert unique pairs into the pivot table
        DB::table('major_subject')->insert(array_values($majorSubjectPairs));
    }
}
