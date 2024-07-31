<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
