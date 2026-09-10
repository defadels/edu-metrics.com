<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NewUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $verifiedAt = now();

        User::updateOrCreate([
            'email' => 'admin@unibba.ac.id',
        ], [
            'name' => 'Administrator UNIBBA',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'nim' => null,
            'program_study' => null,
        ])->forceFill([
            'email_verified_at' => $verifiedAt,
        ])->save();
    }
}
