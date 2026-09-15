<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Response;
use App\Models\Survey;
use App\Models\SurveyCategory;
use App\Models\User;
use Database\Seeders\NewUserSeeder;
use Database\Seeders\StudentSeeder;
use Database\Seeders\SurveySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurveySeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_surveys_questions_and_student_responses_idempotently(): void
    {
        $this->seed(NewUserSeeder::class);
        $this->seed(StudentSeeder::class);
        $this->seed(SurveySeeder::class);

        // Verify Surveys
        $this->assertGreaterThanOrEqual(3, Survey::count());
        $this->assertGreaterThanOrEqual(3, SurveyCategory::count());
        $this->assertGreaterThanOrEqual(15, Question::count());

        // Verify Responses by Students
        $studentsCount = User::query()->where('role', 'mahasiswa')->count();
        $this->assertSame(36, $studentsCount);

        $completedResponses = Response::query()->where('is_completed', true)->count();
        $this->assertGreaterThanOrEqual(36, $completedResponses);

        // Verify that answers exist for responses
        $totalAnswers = Answer::count();
        $this->assertGreaterThan(0, $totalAnswers);

        // Verify that Likert, Text, and Multiple Choice answers exist
        $likertAnswers = Answer::query()->whereNotNull('likert_value')->count();
        $textAnswers = Answer::query()->whereNotNull('text_value')->count();
        $mcAnswers = Answer::query()->whereNotNull('selected_option_id')->count();

        $this->assertGreaterThan(0, $likertAnswers);
        $this->assertGreaterThan(0, $textAnswers);
        $this->assertGreaterThan(0, $mcAnswers);

        // Re-run seeder to verify idempotency
        $this->seed(SurveySeeder::class);

        $this->assertGreaterThanOrEqual(3, Survey::count());
        $this->assertGreaterThanOrEqual(36, Response::query()->where('is_completed', true)->count());
    }

    public function test_it_can_run_survey_seeder_via_route(): void
    {
        $this->seed(NewUserSeeder::class);
        $this->seed(StudentSeeder::class);

        $response = $this->get('/seeder/surveys');

        $response->assertOk();
        $this->assertGreaterThanOrEqual(3, Survey::count());
        $this->assertGreaterThanOrEqual(36, Response::count());
    }
}
