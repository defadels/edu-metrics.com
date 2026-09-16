<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Survey;
use App\Models\SurveyCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurveyCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private SurveyCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();

        $this->category = SurveyCategory::create([
            'name' => 'Akademik',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_update_survey_dates_and_attributes(): void
    {
        $survey = Survey::create([
            'category_id' => $this->category->id,
            'title' => 'Aspek Proses Pendidikan',
            'description' => 'Deskripsi survei awal',
            'start_date' => '2026-08-04 14:34:00',
            'end_date' => '2026-08-05 14:34:00',
            'is_active' => true,
            'is_anonymous' => false,
            'created_by' => $this->admin->id,
        ]);

        $newStartDate = '2026-08-04 14:34';
        $newEndDate = '2026-09-17 14:34';

        $response = $this->actingAs($this->admin)->put(route('dashboard.surveys.update', $survey), [
            'category_id' => $this->category->id,
            'title' => 'Aspek Proses Pendidikan Diperbarui',
            'description' => 'Deskripsi survei diperbarui',
            'start_date' => $newStartDate,
            'end_date' => $newEndDate,
            'is_active' => '1',
            'is_anonymous' => '1',
        ]);

        $response->assertRedirect(route('dashboard.surveys.index'));
        $response->assertSessionHas('success', 'Survey updated successfully.');

        $survey->refresh();

        $this->assertEquals('Aspek Proses Pendidikan Diperbarui', $survey->title);
        $this->assertEquals('Deskripsi survei diperbarui', $survey->description);
        $this->assertEquals('2026-08-04 14:34', $survey->start_date->format('Y-m-d H:i'));
        $this->assertEquals('2026-09-17 14:34', $survey->end_date->format('Y-m-d H:i'));
        $this->assertTrue($survey->is_active);
        $this->assertTrue($survey->is_anonymous);
    }

    public function test_admin_can_uncheck_active_and_anonymous_when_updating(): void
    {
        $survey = Survey::create([
            'category_id' => $this->category->id,
            'title' => 'Survei Tes Status',
            'description' => 'Deskripsi survei',
            'start_date' => '2026-08-04 14:34:00',
            'end_date' => '2026-08-05 14:34:00',
            'is_active' => true,
            'is_anonymous' => true,
            'created_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)->put(route('dashboard.surveys.update', $survey), [
            'category_id' => $this->category->id,
            'title' => 'Survei Tes Status Nonaktif',
            'start_date' => '2026-08-04 14:34',
            'end_date' => '2026-08-05 14:34',
            // is_active and is_anonymous omitted (unchecked checkboxes)
        ]);

        $response->assertRedirect(route('dashboard.surveys.index'));

        $survey->refresh();

        $this->assertFalse($survey->is_active);
        $this->assertFalse($survey->is_anonymous);
    }
}
