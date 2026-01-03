<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@stkip-pasundan.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'nim' => null,
            'email_verified_at' => now(),
        ]);

        // Create Additional Admin User
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@edumetrics.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'nim' => null,
            'email_verified_at' => now(),
        ]);

        // Create Mahasiswa Users
        $mahasiswaData = [
            [
                'name' => 'Ahmad Fadhil',
                'email' => 'fadhil@student.stkip-pasundan.ac.id',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'nim' => '2021001',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@student.stkip-pasundan.ac.id',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'nim' => '2021002',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@student.stkip-pasundan.ac.id',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'nim' => '2021003',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@student.stkip-pasundan.ac.id',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'nim' => '2021004',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Rizki Pratama',
                'email' => 'rizki@student.stkip-pasundan.ac.id',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'nim' => '2021005',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($mahasiswaData as $data) {
            User::create($data);
        }

        // Create additional random mahasiswa users using factory
        User::factory()
            ->count(10)
            ->mahasiswa()
            ->create();
    }
}
