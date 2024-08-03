<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
}
