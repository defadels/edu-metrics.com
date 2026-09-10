<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\NewUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class NewUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_the_admin_user_idempotently(): void
    {
        $this->seed(NewUserSeeder::class);

        $this->assertDatabaseCount('users', 1);

        $admin = User::query()->where('email', 'admin@unibba.ac.id')->firstOrFail();

        $this->assertSame('Administrator UNIBBA', $admin->name);
        $this->assertSame('admin', $admin->role);
        $this->assertNull($admin->nim);
        $this->assertNull($admin->program_study);
        $this->assertTrue(Hash::check('admin123', $admin->password));
        $this->assertNotNull($admin->email_verified_at);

        $this->seed(NewUserSeeder::class);

        $this->assertDatabaseCount('users', 1);
    }
}
