<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Degree;
use App\Models\Major;
use App\Models\Role;
use App\Models\Status;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        Role::insert($this->roles);

        Status::insert($this->statuses);

        College::insert($this->colleges);

        Degree::insert($this->degrees);

        Subject::insert(CSV('subjects'));

        Major::insert(CSV('majors'));

        if(DB::connection()->getName() !== 'testing' && app()->environment('local'))
            $this->call(FakeDataSeeder::class);
    }
}
