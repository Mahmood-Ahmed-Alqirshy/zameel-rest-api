<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseSeeder extends Seeder
{
    protected $roles = [
        ['name' => 'مشرف اعلى'],
        ['name' => 'إداري'],
        ['name' => 'أكاديمي'],
        ['name' => 'مندوب'],
        ['name' => 'طالب'],
    ];

    protected $statuses = [
        ['name' => 'مقبول'],
        ['name' => 'معلق'],
        ['name' => 'مرفوض'],
    ];

    protected $colleges = [
        ['name' => 'كلية الطب والعلوم الصحية'],
        ['name' => 'كلية الهندسة والحاسبات'],
        ['name' => 'كلية العلوم الإدارية والإنسانية'],
    ];

    protected $degrees = [
        ['name' => 'دبلوم'],
        ['name' => 'بكالوريوس'],
        ['name' => 'ماجستير'],
        ['name' => 'دكتوراة'],
    ];

    protected function insertToDataBase($table, $data)
    {
        DB::table($table)->insert($data);
    }

    protected function importCsv($table, $csvFilePath)
    {
        $filePath = database_path($csvFilePath);

        $handle = fopen($filePath, 'r');
        if ($handle !== false) {
            // Get the first row, which contains the column headers
            $header = fgetcsv($handle, 0, ',');

            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                $data = array_combine($header, $row);
                $this->insertToDataBase($table, $data);
            }
            fclose($handle);
        }
    }
}
