<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Perintah ini memberi tahu 'db:seed' untuk
        // menjalankan seeder admin kita
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}
