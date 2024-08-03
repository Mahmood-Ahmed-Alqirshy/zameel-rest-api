<?php

namespace Database\Seeders;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->insertToDataBase('roles', $this->roles);
        $this->insertToDataBase('statuses', $this->statuses);
        $this->insertToDataBase('colleges', $this->colleges);
        $this->insertToDataBase('degrees', $this->degrees);
        $this->importCsv('subjects', 'csv/subjects.csv');
        $this->importCsv('majors', 'csv/majors.csv');

        $this->call([
            FakeDataSeeder::class,
        ]);
    }
}
