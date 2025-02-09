<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;

class IncomingBooksTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // مسار الملف الذي سيحفظ آخر رقم كتاب
        $filePath = storage_path('app/last_book_number.txt');

        // قراءة آخر رقم كتاب من الملف (إذا كان الملف موجودًا)
        $lastBookNumber = 0;
        if (file_exists($filePath)) {
            $lastBookNumber = (int) file_get_contents($filePath);
        }

        // إنشاء 500 سجل وهمي
        for ($i = $lastBookNumber + 1; $i <= $lastBookNumber + 500; $i++) {
            // إنشاء مصفوفة sender_id تحتوي على قيمتين عشوائيتين
            $senderIds = [
                $faker->numberBetween(1, 30),
                $faker->numberBetween(1, 30)
            ];
            $senderIdsJson = json_encode($senderIds);

            // إنشاء رقم كتاب فريد
            $bookNumber = 'BOOK-' . str_pad($i, 3, '0', STR_PAD_LEFT);

            DB::table('incomingbooks')->insert([
                'user_id' => 4,
                'book_number' => $bookNumber, // رقم الكتاب الفريد
                'book_date' => $faker->date(),
                'subject' => $faker->sentence(5),
                'content' => $faker->sentence(5),
                'keywords' => implode(', ', $faker->words(3)),
                'related_book_id' => null,
                'sender_type' => $faker->randomElement(['داخلي', 'خارجي']),
                'sender_id' => $senderIdsJson,
                'attachment' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // حفظ آخر رقم كتاب في الملف
        file_put_contents($filePath, $lastBookNumber + 500);
    }
}
