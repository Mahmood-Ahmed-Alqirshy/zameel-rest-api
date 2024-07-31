<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            ['name' => 'هندسة مدنية', 'college_id' => 2, 'degree_id' => 2, 'years' => 5],
            ['name' => 'هندسة كهربائية', 'college_id' => 2, 'degree_id' => 2, 'years' => 5],
            ['name' => 'طب عام', 'college_id' => 1, 'degree_id' => 2, 'years' => 6],
            ['name' => 'علوم الحاسب', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'هندسة ميكانيكية', 'college_id' => 2, 'degree_id' => 2, 'years' => 5],
            ['name' => 'هندسة معمارية', 'college_id' => 2, 'degree_id' => 2, 'years' => 5],
            ['name' => 'تمريض', 'college_id' => 1, 'degree_id' => 2, 'years' => 4],
            ['name' => 'صيدلة', 'college_id' => 1, 'degree_id' => 2, 'years' => 5],
            ['name' => 'طب أسنان', 'college_id' => 1, 'degree_id' => 2, 'years' => 5],
            ['name' => 'هندسة الحاسوب', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'هندسة الطيران', 'college_id' => 2, 'degree_id' => 2, 'years' => 5],
            ['name' => 'إدارة الأعمال', 'college_id' => 3, 'degree_id' => 2, 'years' => 4],
            ['name' => 'تسويق', 'college_id' => 3, 'degree_id' => 2, 'years' => 4],
            ['name' => 'محاسبة', 'college_id' => 3, 'degree_id' => 2, 'years' => 4],
            ['name' => 'إدارة الموارد البشرية', 'college_id' => 3, 'degree_id' => 2, 'years' => 4],
            ['name' => 'اقتصاد', 'college_id' => 3, 'degree_id' => 2, 'years' => 4],
            ['name' => 'مالية', 'college_id' => 3, 'degree_id' => 2, 'years' => 4],
            ['name' => 'نظم المعلومات الإدارية', 'college_id' => 3, 'degree_id' => 2, 'years' => 4],
            ['name' => 'قانون', 'college_id' => 3, 'degree_id' => 2, 'years' => 4],
            ['name' => 'دبلوم إدارة الأعمال', 'college_id' => 3, 'degree_id' => 1, 'years' => 2],
            ['name' => 'دبلوم تقنية المعلومات', 'college_id' => 2, 'degree_id' => 1, 'years' => 2],
            ['name' => 'ماجستير إدارة الأعمال', 'college_id' => 3, 'degree_id' => 3, 'years' => 2],
            ['name' => 'ماجستير في علوم الحاسب', 'college_id' => 2, 'degree_id' => 3, 'years' => 2],
            ['name' => 'دكتوراة في الطب', 'college_id' => 1, 'degree_id' => 4, 'years' => 3],
            ['name' => 'دكتوراة في الهندسة المعمارية', 'college_id' => 2, 'degree_id' => 4, 'years' => 3],
            ['name' => 'دبلوم تسويق', 'college_id' => 3, 'degree_id' => 1, 'years' => 2],
            ['name' => 'دبلوم محاسبة', 'college_id' => 3, 'degree_id' => 1, 'years' => 2],
            ['name' => 'ماجستير في الهندسة المدنية', 'college_id' => 2, 'degree_id' => 3, 'years' => 2],
            ['name' => 'ماجستير في الهندسة الكهربائية', 'college_id' => 2, 'degree_id' => 3, 'years' => 2],
            ['name' => 'ماجستير في إدارة الموارد البشرية', 'college_id' => 3, 'degree_id' => 3, 'years' => 2],
            ['name' => 'ماجستير في التسويق', 'college_id' => 3, 'degree_id' => 3, 'years' => 2],
            ['name' => 'دكتوراة في علوم الحاسب', 'college_id' => 2, 'degree_id' => 4, 'years' => 3],
            ['name' => 'دكتوراة في الهندسة الميكانيكية', 'college_id' => 2, 'degree_id' => 4, 'years' => 3],
            ['name' => 'دكتوراة في إدارة الأعمال', 'college_id' => 3, 'degree_id' => 4, 'years' => 3],
            ['name' => 'دكتوراة في المحاسبة', 'college_id' => 3, 'degree_id' => 4, 'years' => 3],
            ['name' => 'هندسة كيميائية', 'college_id' => 2, 'degree_id' => 2, 'years' => 5],
            ['name' => 'هندسة بيئية', 'college_id' => 2, 'degree_id' => 2, 'years' => 5],
            ['name' => 'تقنية المعلومات', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'علم النفس', 'college_id' => 3, 'degree_id' => 2, 'years' => 4],
            ['name' => 'علم الاجتماع', 'college_id' => 3, 'degree_id' => 2, 'years' => 4],
            ['name' => 'الفيزياء', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'الكيمياء', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'الأحياء', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'رياضيات', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'إحصاء', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'علوم الأرض', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'علوم البحار', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'هندسة الشبكات', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'هندسة البرمجيات', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
            ['name' => 'الذكاء الاصطناعي', 'college_id' => 2, 'degree_id' => 2, 'years' => 4],
        ];

        DB::table('majors')->insert($majors);
    }
}
