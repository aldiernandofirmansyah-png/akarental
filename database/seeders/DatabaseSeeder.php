<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun Admin
        User::create([
            'name' => 'Admin AKA Rental',
            'username' => 'admin',
            'email' => 'admin@akarental.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Buat akun Pelanggan
        User::create([
            'name' => 'Pelanggan AKA',
            'username' => 'pelanggan',
            'email' => 'pelanggan@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('pelanggan123'),
            'role' => 'pelanggan',
        ]);

        $this->call([
            BarangSeeder::class,
        ]);
    }
}
