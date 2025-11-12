<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // <-- IMPORT MODEL USER
use Illuminate\Support\Facades\Hash; // <-- IMPORT HASHING

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus pengguna lama jika ada (opsional, tapi bersih)
        User::truncate();

        // Buat Admin Baru
        User::create([
            'name' => 'Admin Invoice',
            'email' => 'admin@invoice.com',
            'email_verified_at' => now(), // Langsung verifikasi email
            'password' => Hash::make('admin123'), // Ganti 'password123' jika Anda mau
        ]);
    }
}
