<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardEnglishInterfaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_sidebar_uses_the_requested_english_order(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('dashboard.respondents.index'));

        $response->assertOk();

        $content = $response->getContent();
        $menuLabels = [
            'Dashboard',
            'Survey Categories',
            'Edit Questionnaire',
            'Survey Findings',
            'Respondent Data',
            'User Management',
        ];

        $previousPosition = -1;

        foreach ($menuLabels as $label) {
            $position = strpos($content, ">{$label}</span>");

            $this->assertNotFalse($position, "The sidebar label '{$label}' was not rendered.");
            $this->assertGreaterThan($previousPosition, $position, "The sidebar label '{$label}' is out of order.");

            $previousPosition = $position;
        }

        $response
            ->assertDontSeeText('Kategori Survei')
            ->assertDontSeeText('Data Responden')
            ->assertDontSeeText('Data Pengguna')
            ->assertDontSeeText('Skala Likert');
    }

    public function test_respondent_and_user_management_pages_use_english_content(): void
    {
        $admin = User::factory()->admin()->create();
        $student = User::factory()->mahasiswa()->create([
            'program_study' => 'Teknik Informatika',
        ]);

        $this->actingAs($admin)
            ->get(route('dashboard.respondents.index'))
            ->assertOk()
            ->assertSeeText('Respondent List')
            ->assertSeeText('Completed Questionnaires')
            ->assertSeeText('View Profile');

        $this->get(route('dashboard.respondents.show', $student))
            ->assertOk()
            ->assertSeeText('Respondent Details')
            ->assertSeeText('Additional Information')
            ->assertSeeText('Questionnaire History');

        $this->get(route('dashboard.users.index'))
            ->assertOk()
            ->assertSeeText('User Management')
            ->assertSeeText('Total Users')
            ->assertSeeText('Add User');

        $this->get(route('dashboard.users.create'))
            ->assertOk()
            ->assertSeeText('Add New User')
            ->assertSeeText('Save User');

        $this->get(route('dashboard.users.edit', $student))
            ->assertOk()
            ->assertSeeText('Edit User')
            ->assertSeeText('Update User');

        $this->get(route('dashboard.users.show', $student))
            ->assertOk()
            ->assertSeeText('User Details')
            ->assertSeeText('Study Program')
            ->assertSeeText('Questionnaire History');
    }
}
