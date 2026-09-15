<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_email(): void
    {
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => 'testuser@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('home', absolute: false));
    }

    public function test_users_can_authenticate_using_legacy_email_field(): void
    {
        $user = User::factory()->create([
            'email' => 'legacy@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'legacy@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('home', absolute: false));
    }

    public function test_users_can_authenticate_using_nim(): void
    {
        $user = User::factory()->create([
            'nim' => '501240099',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => '501240099',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('home', absolute: false));
    }

    public function test_users_can_authenticate_using_username_name(): void
    {
        $user = User::factory()->create([
            'name' => 'admin_super',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => 'admin_super',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('home', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'email' => 'wrongpass@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->post('/login', [
            'login' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_non_existent_account(): void
    {
        $this->post('/login', [
            'login' => 'nonexistent_account',
            'password' => 'password123',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }
}
