<?php

namespace Tests\Feature;

use App\Models\Survey;
use App\Models\SurveyCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SurveyListTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_survey_list_shows_both_active_and_closed_surveys(): void
    {
        Carbon::setTestNow('2026-09-13 12:00:00');

        $category = SurveyCategory::create([
            'name' => 'Akademik',
            'is_active' => true,
        ]);

        $activeSurvey = Survey::create([
            'category_id' => $category->id,
            'title' => 'Survei Aktif Kepuasan',
            'description' => 'Survei yang masih berjalan',
            'start_date' => now()->subDay(),
            'end_date' => now()->addDays(5),
            'is_active' => true,
            'is_anonymous' => false,
        ]);

        $closedSurvey = Survey::create([
            'category_id' => $category->id,
            'title' => 'Survei Lama Sudah Tutup',
            'description' => 'Survei yang sudah lewat batas waktu',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDay(),
            'is_active' => true,
            'is_anonymous' => false,
        ]);

        $response = $this->get(route('surveys.index'));

        $response->assertOk();
        $response->assertSeeText('Survei Aktif Kepuasan');
        $response->assertSeeText('Survei Lama Sudah Tutup');
        $response->assertSeeText('Aktif');
        $response->assertSeeText('Sudah Ditutup');
    }

    public function test_closed_survey_details_shows_closed_notice_and_disables_start(): void
    {
        Carbon::setTestNow('2026-09-13 12:00:00');

        $category = SurveyCategory::create([
            'name' => 'Akademik',
            'is_active' => true,
        ]);

        $closedSurvey = Survey::create([
            'category_id' => $category->id,
            'title' => 'Survei Sudah Berakhir',
            'description' => 'Deskripsi survei tutup',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDay(),
            'is_active' => true,
            'is_anonymous' => false,
        ]);

        $response = $this->get(route('surveys.show', $closedSurvey));

        $response->assertOk();
        $response->assertSeeText('Survei Sudah Berakhir');
        $response->assertSeeText('Survey Sudah Ditutup');
        $response->assertDontSeeText('Mulai Isi Kuesioner');
    }

    public function test_closed_survey_start_redirects_with_error(): void
    {
        Carbon::setTestNow('2026-09-13 12:00:00');

        $category = SurveyCategory::create([
            'name' => 'Akademik',
            'is_active' => true,
        ]);

        $closedSurvey = Survey::create([
            'category_id' => $category->id,
            'title' => 'Survei Tidak Bisa Diisi',
            'description' => 'Survei tutup',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDay(),
            'is_active' => true,
            'is_anonymous' => false,
        ]);

        $user = User::factory()->mahasiswa()->create();

        $response = $this->actingAs($user)->get(route('surveys.start', $closedSurvey));

        $response->assertRedirect(route('surveys.show', $closedSurvey));
        $response->assertSessionHas('error');
    }
}
