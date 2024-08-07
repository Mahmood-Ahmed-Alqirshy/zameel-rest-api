<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(DatabaseSeeder::class);

        User::create([
            'name' => 'Mahmoud',
            'email' => 'Mahmoud@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);
    }
}
