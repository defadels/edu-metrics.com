<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $verifiedAt = now();

        $students = [
            ['nim' => '501240012', 'name' => 'AFRIANA NUR ROHMAH'],
            ['nim' => '501240002', 'name' => 'DESTINA NUR HANIFA'],
            ['nim' => '501240001', 'name' => 'DINA NOVITA MULYAWATI'],
            ['nim' => '501240014', 'name' => 'INDRI MAULIDA PUTRI'],
            ['nim' => '501240028', 'name' => 'ISMAH PATIMATU ZAHRA'],
            ['nim' => '501240029', 'name' => 'KARIM MAULANA ADINATA'],
            ['nim' => '501240027', 'name' => 'LENI NURAIDA'],
            ['nim' => '501240011', 'name' => 'MARINI PUSPA ANDAYANI'],
            ['nim' => '501240009', 'name' => 'MUHAMMAD RIFKY RIZKIANTO'],
            ['nim' => '501240010', 'name' => 'NAZWA RAHMA NADILA'],
            ['nim' => '501240025', 'name' => 'PUTRI TIARA JULIANTI'],
            ['nim' => '501240008', 'name' => 'RAYA MEGA PRATIWI'],
            ['nim' => '501240022', 'name' => 'REFINA AGUSTIANI AINNURROHMAN'],
            ['nim' => '501240018', 'name' => 'RENDI MAULANA'],
            ['nim' => '501240013', 'name' => 'STING HAFID KALERATU'],
            ['nim' => '501240021', 'name' => 'WILDAN MULYANA'],
            ['nim' => '501240015', 'name' => 'DEWI YULIANTI'],
            ['nim' => '501240023', 'name' => 'AYU RIZKI SAFITRI'],
            ['nim' => '501240026', 'name' => 'DARA SAHDA QONITA'],
            ['nim' => '501240051', 'name' => 'FATHIYA NUR HANIFA'],
            ['nim' => '501240042', 'name' => 'FIRLI HASRI AINUN'],
            ['nim' => '501240046', 'name' => 'HILMAN ALVIANA SIDIQ'],
            ['nim' => '501240050', 'name' => 'INTAN FITRIANI'],
            ['nim' => '501240036', 'name' => 'IVANA AULIA RACHMAYANTI G'],
            ['nim' => '501240054', 'name' => 'JULIA KARTIKA SARI'],
            ['nim' => '501240044', 'name' => 'MILA RAHMADANI'],
            ['nim' => '501240043', 'name' => 'NADYA SAMROTUL AZKIA'],
            ['nim' => '501240033', 'name' => 'NURRUL NURROHMAH'],
            ['nim' => '501240055', 'name' => 'NURUL KHAERUNISA'],
            ['nim' => '501240038', 'name' => 'OKTAVINA RAMADANI'],
            ['nim' => '501240045', 'name' => 'PUTRI JUITA RAMDANI'],
            ['nim' => '501240057', 'name' => 'REVAN ARDANAPUTRA'],
            ['nim' => '501240056', 'name' => 'RINDA IKHFA NANDA MAULIDA'],
            ['nim' => '501240039', 'name' => 'SENI SELPIANI'],
            ['nim' => '501240048', 'name' => 'SITI JAMILAH'],
            ['nim' => '501240041', 'name' => 'YULINDA NURAENI'],
        ];

        $studentPassword = Hash::make('mahasiswa123');

        foreach ($students as $student) {
            User::updateOrCreate([
                'nim' => $student['nim'],
            ], [
                'name' => $student['name'],
                'email' => "{$student['nim']}@student.unibba.ac.id",
                'password' => $studentPassword,
                'role' => 'mahasiswa',
                'program_study' => null,
            ])->forceFill([
                'email_verified_at' => $verifiedAt,
            ])->save();
        }
    }
}
