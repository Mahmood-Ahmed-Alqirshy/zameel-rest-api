<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'مقبول'],
            ['name' => 'معلق'],
            ['name' => 'مرفوض']
        ];

        DB::table('statuses')->insert($statuses);
    }
}
