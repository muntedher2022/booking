<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sections\Section;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // ...existing seeders...
            SectionSeeder::class,
        ]);
    }
}
