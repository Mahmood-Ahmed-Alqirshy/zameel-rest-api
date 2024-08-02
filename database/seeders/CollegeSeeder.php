<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegeSeeder extends Seeder
{
    public function run(): void
    {
        $colleges = [
            ['name' => 'كلية الطب والعلوم الصحية'],
            ['name' => 'كلية الهندسة والحاسبات'],
            ['name' => 'كلية العلوم الإدارية والإنسانية'],
        ];

        DB::table('colleges')->insert($colleges);
    }
}
