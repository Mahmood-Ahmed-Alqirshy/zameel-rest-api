<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'مشرف اعلى'],
            ['name' => 'إداري'],
            ['name' => 'أكاديمي'],
            ['name' => 'مندوب'],
            ['name' => 'طالب']
        ];

        DB::table('roles')->insert($roles);
    }
}
