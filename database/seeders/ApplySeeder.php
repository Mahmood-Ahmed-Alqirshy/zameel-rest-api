<?php

namespace Database\Seeders;

use App\Models\Apply;
use Illuminate\Database\Seeder;

class ApplySeeder extends Seeder
{
    public function run(): void
    {
        Apply::factory(50)->create();
    }
}
