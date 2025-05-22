<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['section_name' => 'مكتب المدير العام'],
            ['section_name' => 'مكتب معاون المدير العام الاداري'],
            ['section_name' => 'مكتب معاون المدير العام الفني'],
            ['section_name' => 'قسم التخطيط والمتابعة'],
            ['section_name' => 'قسم المدونة الدولية'],
            ['section_name' => 'قسم العقود'],
            ['section_name' => 'قسم التشغيل المشترك'],
            ['section_name' => 'قسم تكنلوجيا المعلومات'],
            ['section_name' => 'قسم الشؤون المالية'],
            ['section_name' => 'قسم ادارة الموارد البشرية'],
            ['section_name' => 'قسم التدقيق والرقابة الداخلية'],
            ['section_name' => 'قسم القانونية'],
            ['section_name' => 'القسم التجاري'],
            ['section_name' => 'قسم الشؤون الهندسية'],
            ['section_name' => 'قسم السلامة والاطفاء'],
            ['section_name' => 'قسم التفتيش البحري'],
            ['section_name' => 'قسم المسافن والصناعات البحرية'],
            ['section_name' => 'قسم الانقاذ البحري'],
            ['section_name' => 'قسم السيطرة والتوجيه'],
            ['section_name' => 'قسم الحفر البحري'],
            ['section_name' => 'قسم الشؤون البحرية'],
            ['section_name' => 'قسم الاتصالات والرصد البحري'],
            ['section_name' => 'شعبة العلاقات والاعلام'],
            ['section_name' => 'شعبة شؤون المواطنين'],
            ['section_name' => 'شعبة ادارة الجودة'],
            ['section_name' => 'شعبة العوائد والاجور'],
            ['section_name' => 'معهد الموانئ'],
            ['section_name' => 'ميناء ام قصر الشمالي'],
            ['section_name' => 'ميناء ام قصر الجنوبي'],
            ['section_name' => 'ميناء خور الزبير'],
            ['section_name' => 'ميناء المعقل'],
            ['section_name' => 'ميناء ابو فلوس'],
        ];

        foreach ($sections as $section) {
            DB::table('sections')->insert([
                'user_id' => 4,
                'section_name' => $section['section_name'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
