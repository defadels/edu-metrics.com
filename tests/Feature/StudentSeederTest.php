<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\StudentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_the_students_idempotently(): void
    {
        $expectedNims = [
            '501240001',
            '501240002',
            '501240008',
            '501240009',
            '501240010',
            '501240011',
            '501240012',
            '501240013',
            '501240014',
            '501240015',
            '501240018',
            '501240021',
            '501240022',
            '501240023',
            '501240025',
            '501240026',
            '501240027',
            '501240028',
            '501240029',
            '501240033',
            '501240036',
            '501240038',
            '501240039',
            '501240041',
            '501240042',
            '501240043',
            '501240044',
            '501240045',
            '501240046',
            '501240048',
            '501240050',
            '501240051',
            '501240054',
            '501240055',
            '501240056',
            '501240057',
        ];

        $this->seed(StudentSeeder::class);

        $this->assertDatabaseCount('users', 36);
        $this->assertSame(
            $expectedNims,
            User::query()
                ->where('role', 'mahasiswa')
                ->orderBy('nim')
                ->pluck('nim')
                ->all()
        );

        $student = User::query()->where('nim', '501240012')->firstOrFail();

        $this->assertSame('AFRIANA NUR ROHMAH', $student->name);
        $this->assertSame('501240012@student.unibba.ac.id', $student->email);
        $this->assertTrue(Hash::check('mahasiswa123', $student->password));
        $this->assertNotNull($student->email_verified_at);

        $this->seed(StudentSeeder::class);

        $this->assertDatabaseCount('users', 36);
    }

    public function test_it_can_run_student_seeder_via_route(): void
    {
        $response = $this->get('/seeder/students');

        $response->assertOk();
        $this->assertDatabaseCount('users', 36);
    }
}
