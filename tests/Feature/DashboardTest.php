<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\LikertScale;
use App\Models\Question;
use App\Models\Response;
use App\Models\Survey;
use App\Models\SurveyCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_admin_can_view_an_informative_empty_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('dashboard.index'));

        $response
            ->assertOk()
            ->assertSeeText('Quality Dashboard')
            ->assertSeeText('Satisfaction data is not available yet')
            ->assertSeeText('Total Surveys')
            ->assertSeeText('Satisfaction Level Distribution')
            ->assertSeeText('Insights and Recommendations')
            ->assertSeeText('Recent Surveys')
            ->assertDontSeeText('Dashboard Mutu')
            ->assertDontSeeText('Kelola Survei')
            ->assertViewHas('stats', fn (array $stats) => $stats['surveys'] === 0
                && $stats['responses'] === 0
                && $stats['average_satisfaction'] === 0);
    }

    public function test_dashboard_aggregates_completed_likert_responses(): void
    {
        Carbon::setTestNow('2026-09-10 10:00:00');

        $admin = User::factory()->admin()->create();
        $student = User::factory()->mahasiswa()->create([
            'program_study' => 'Teknik Informatika',
        ]);
        $category = SurveyCategory::query()->create([
            'name' => 'Layanan Akademik',
            'description' => 'Evaluasi layanan akademik.',
            'is_active' => true,
        ]);
        $scale = LikertScale::query()->create([
            'name' => 'Kepuasan 1-5',
            'min_value' => 1,
            'max_value' => 5,
            'min_label' => 'Sangat Tidak Puas',
            'max_label' => 'Sangat Puas',
        ]);
        $survey = Survey::query()->create([
            'category_id' => $category->id,
            'title' => 'Survei Layanan Akademik',
            'description' => 'Evaluasi layanan akademik mahasiswa.',
            'start_date' => now()->subMonth(),
            'end_date' => now()->addMonth(),
            'is_active' => true,
            'is_anonymous' => false,
            'created_by' => $admin->id,
        ]);
        $highestQuestion = Question::query()->create([
            'survey_id' => $survey->id,
            'question_text' => 'Petugas memberikan layanan dengan ramah.',
            'question_type' => 'likert',
            'likert_scale_id' => $scale->id,
            'is_required' => true,
            'order' => 1,
        ]);
        $lowestQuestion = Question::query()->create([
            'survey_id' => $survey->id,
            'question_text' => 'Waktu tunggu layanan sudah singkat.',
            'question_type' => 'likert',
            'likert_scale_id' => $scale->id,
            'is_required' => true,
            'order' => 2,
        ]);
        $surveyResponse = Response::query()->create([
            'survey_id' => $survey->id,
            'user_id' => $student->id,
            'started_at' => now()->subMinutes(10),
            'completed_at' => now(),
            'is_completed' => true,
        ]);

        Answer::query()->create([
            'response_id' => $surveyResponse->id,
            'question_id' => $highestQuestion->id,
            'likert_value' => 5,
        ]);
        Answer::query()->create([
            'response_id' => $surveyResponse->id,
            'question_id' => $lowestQuestion->id,
            'likert_value' => 3,
        ]);

        $response = $this->actingAs($admin)->get(route('dashboard.index'));

        $response
            ->assertOk()
            ->assertSeeText('Layanan Akademik')
            ->assertSeeText('Teknik Informatika')
            ->assertSeeText('Petugas memberikan layanan dengan ramah.')
            ->assertViewHas('stats', fn (array $stats) => $stats['surveys'] === 1
                && $stats['active_surveys'] === 1
                && $stats['responses'] === 1
                && $stats['average_satisfaction'] === 4.0
                && $stats['satisfaction_percentage'] === 50.0)
            ->assertViewHas('topIndicators', fn (Collection $items) => $items->first()['question'] === $highestQuestion->question_text)
            ->assertViewHas('lowestIndicators', fn (Collection $items) => $items->first()['question'] === $lowestQuestion->question_text);
    }
}
