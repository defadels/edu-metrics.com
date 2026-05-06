<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class NewUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            'name' => 'Administrator UNIBBA',
            'email' => 'admin@unibba.ac.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'nim' => null,
            'email_verified_at' => now(),
        ]);
    }
}
