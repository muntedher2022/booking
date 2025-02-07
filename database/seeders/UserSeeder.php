<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // تأكد من استيراد نموذج User

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مستخدم جديد
        User::create([
            'id' => 4,
            'name' => 'muntedher',
            'email' => 'mun@gmail.com',
            'password' => Hash::make('12345678'), // تشفير كلمة المرور
            'plan' => 'OWNER', // يمكنك تغيير هذه القيمة حسب الحاجة
            'status' => 'active', // يمكنك تغيير هذه القيمة حسب الحاجة
            'stores_id' => 1, // يمكنك تغيير هذه القيمة حسب الحاجة
        ]);
    }
}
