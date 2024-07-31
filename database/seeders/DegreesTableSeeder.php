<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DegreesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $degrees = [
            ['name' => 'دبلوم'],
            ['name' => 'بكالوريوس'],
            ['name' => 'ماجستير'],
            ['name' => 'دكتوراة']
        ];

        DB::table('degrees')->insert($degrees);
    }
}
