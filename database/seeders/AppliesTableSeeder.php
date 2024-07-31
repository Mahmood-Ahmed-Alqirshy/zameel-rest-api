<?php

namespace Database\Seeders;

use App\Models\Apply;
use Illuminate\Database\Seeder;

class AppliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Apply::factory(50)->create();
    }
}
