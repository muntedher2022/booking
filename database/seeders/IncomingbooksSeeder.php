<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Incomingbooks\Incomingbooks;

class IncomingbooksSeeder extends Seeder
{
    public function run(): void
    {
        // حذف البيانات القديمة أولاً
        Incomingbooks::truncate();

        $users = User::pluck('id')->toArray();
        $importanceTypes = ['عادي', 'سري', 'عاجل'];
        $bookTypes = ['وارد', 'صادر'];
        $senderTypes = ['داخلي', 'خارجي'];
        $senderIds = range(1, 50);

        // إنشاء مصفوفة من الأرقام العشوائية
        $randomNumbers = range(1, 999999);
        shuffle($randomNumbers);

        for ($i = 0; $i < 200; $i++) {
            $selectedIds = array_rand(array_flip($senderIds), 2);
            $randomNumber = $randomNumbers[$i];

            Incomingbooks::create([
                'user_id' => $users[array_rand($users)],
                'book_number' => 'BOOK-' . str_pad($randomNumber, 6, '0', STR_PAD_LEFT),
                'book_date' => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d'),
                'subject' => 'موضوع الكتاب رقم ' . ($i + 1) . ' - ' . fake()->realText(50),
                'content' => fake()->realText(200),
                'keywords' => implode(', ', fake()->words(5)),
                'sender_type' => $senderTypes[array_rand($senderTypes)],
                'book_type' => $bookTypes[array_rand($bookTypes)],
                'importance' => $importanceTypes[array_rand($importanceTypes)],
                'sender_id' => json_encode($selectedIds),
                'created_at' => Carbon::now()->subDays(rand(0, 6))->addHours(rand(0, 23))->addMinutes(rand(0, 59)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
