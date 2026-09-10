<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\LikertScale;
use App\Models\Question;
use App\Models\Response;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $completedResponses = Response::query()->where('is_completed', true);
        $likertAnswers = Answer::query()
            ->whereNotNull('likert_value')
            ->whereHas('response', fn ($query) => $query->where('is_completed', true));

        $minLikert = (int) (LikertScale::query()->min('min_value') ?: 1);
        $maxLikert = (int) (LikertScale::query()->max('max_value') ?: 5);

        if ($maxLikert <= $minLikert) {
            $minLikert = 1;
            $maxLikert = 5;
        }

        $totalLikertAnswers = (clone $likertAnswers)->count();
        $averageSatisfaction = $totalLikertAnswers > 0
            ? round((float) (clone $likertAnswers)->avg('likert_value'), 2)
            : 0;
        $favorableThreshold = max($minLikert, $maxLikert - 1);
        $favorableAnswers = (clone $likertAnswers)
            ->where('likert_value', '>=', $favorableThreshold)
            ->count();
        $satisfactionPercentage = $totalLikertAnswers > 0
            ? round(($favorableAnswers / $totalLikertAnswers) * 100, 1)
            : 0;

        $stats = [
            'surveys' => Survey::count(),
            'active_surveys' => Survey::query()
                ->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count(),
            'responses' => (clone $completedResponses)->count(),
            'average_satisfaction' => $averageSatisfaction,
            'satisfaction_percentage' => $satisfactionPercentage,
            'program_studies' => User::query()
                ->where('role', 'mahasiswa')
                ->whereNotNull('program_study')
                ->where('program_study', '!=', '')
                ->distinct()
                ->count('program_study'),
        ];

        $distributionCounts = (clone $likertAnswers)
            ->select('likert_value', DB::raw('COUNT(*) as total'))
            ->groupBy('likert_value')
            ->pluck('total', 'likert_value');

        $distributionColors = ['#2563eb', '#16a34a', '#eab308', '#f97316', '#dc2626', '#7c3aed'];
        $satisfactionDistribution = collect(range($maxLikert, $minLikert))
            ->values()
            ->map(function (int $value, int $index) use (
                $distributionCounts,
                $distributionColors,
                $maxLikert,
                $minLikert,
                $totalLikertAnswers
            ) {
                $count = (int) ($distributionCounts[$value] ?? 0);

                return [
                    'value' => $value,
                    'label' => $this->satisfactionLabel($value, $minLikert, $maxLikert),
                    'count' => $count,
                    'percentage' => $totalLikertAnswers > 0
                        ? round(($count / $totalLikertAnswers) * 100, 1)
                        : 0,
                    'color' => $distributionColors[$index % count($distributionColors)],
                ];
            });

        $gradientPosition = 0;
        $gradientSegments = $satisfactionDistribution
            ->filter(fn (array $item) => $item['percentage'] > 0)
            ->map(function (array $item) use (&$gradientPosition) {
                $start = $gradientPosition;
                $gradientPosition += $item['percentage'];

                return "{$item['color']} {$start}% {$gradientPosition}%";
            });
        $satisfactionGradient = $gradientSegments->isEmpty()
            ? '#e2e8f0 0% 100%'
            : $gradientSegments->implode(', ');

        $categoryScores = Answer::query()
            ->join('responses', 'answers.response_id', '=', 'responses.id')
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->join('surveys', 'questions.survey_id', '=', 'surveys.id')
            ->join('survey_categories', 'surveys.category_id', '=', 'survey_categories.id')
            ->where('responses.is_completed', true)
            ->whereNotNull('answers.likert_value')
            ->select([
                'survey_categories.id',
                'survey_categories.name',
            ])
            ->selectRaw('AVG(answers.likert_value) as average_score')
            ->selectRaw('COUNT(answers.id) as answer_count')
            ->groupBy('survey_categories.id', 'survey_categories.name')
            ->orderByDesc('average_score')
            ->limit(5)
            ->get()
            ->map(function ($category) use ($maxLikert) {
                $category->average_score = round((float) $category->average_score, 2);
                $category->percentage = min(100, round(($category->average_score / $maxLikert) * 100, 1));

                return $category;
            });

        $questionScoreRows = (clone $likertAnswers)
            ->select('question_id')
            ->selectRaw('AVG(likert_value) as average_score')
            ->selectRaw('COUNT(*) as answer_count')
            ->groupBy('question_id')
            ->get();
        $questions = Question::query()
            ->with('survey:id,title')
            ->whereIn('id', $questionScoreRows->pluck('question_id'))
            ->get()
            ->keyBy('id');
        $indicatorScores = $questionScoreRows
            ->map(function ($row) use ($questions, $maxLikert) {
                $question = $questions->get($row->question_id);

                if (! $question) {
                    return null;
                }

                $average = round((float) $row->average_score, 2);

                return [
                    'id' => $question->id,
                    'question' => $question->question_text,
                    'survey' => $question->survey?->title,
                    'average' => $average,
                    'percentage' => min(100, round(($average / $maxLikert) * 100, 1)),
                    'answer_count' => (int) $row->answer_count,
                ];
            })
            ->filter();
        $topIndicators = $indicatorScores->sortByDesc('average')->take(5)->values();
        $lowestIndicators = $indicatorScores->sortBy('average')->take(5)->values();

        $programStudyDistribution = Response::query()
            ->join('users', 'responses.user_id', '=', 'users.id')
            ->where('responses.is_completed', true)
            ->whereNotNull('users.program_study')
            ->where('users.program_study', '!=', '')
            ->select('users.program_study')
            ->selectRaw('COUNT(responses.id) as total')
            ->groupBy('users.program_study')
            ->orderByDesc('total')
            ->limit(6)
            ->get();
        $largestProgramStudyTotal = max(1, (int) ($programStudyDistribution->max('total') ?? 0));
        $programStudyDistribution->each(function ($study) use ($largestProgramStudyTotal) {
            $study->percentage = round(((int) $study->total / $largestProgramStudyTotal) * 100, 1);
        });

        $trendStart = now()->startOfMonth()->subMonths(5);
        $trendAnswers = (clone $likertAnswers)
            ->where('created_at', '>=', $trendStart)
            ->get(['likert_value', 'created_at'])
            ->groupBy(fn (Answer $answer) => $answer->created_at->format('Y-m'));
        $satisfactionTrend = collect();

        for ($monthsAgo = 5; $monthsAgo >= 0; $monthsAgo--) {
            $month = now()->startOfMonth()->subMonths($monthsAgo);
            $monthAnswers = $trendAnswers->get($month->format('Y-m'), collect());

            $satisfactionTrend->push([
                'key' => $month->format('Y-m'),
                'label' => $month->locale('id')->translatedFormat('M Y'),
                'average' => $monthAnswers->isNotEmpty()
                    ? round((float) $monthAnswers->avg('likert_value'), 2)
                    : null,
            ]);
        }

        $chartRange = $maxLikert - $minLikert;
        $satisfactionTrend = $satisfactionTrend->map(function (array $item, int $index) use (
            $chartRange,
            $minLikert
        ) {
            $item['x'] = 20 + ($index * 112);
            $item['y'] = $item['average'] === null
                ? null
                : round(130 - ((($item['average'] - $minLikert) / $chartRange) * 110), 2);

            return $item;
        });
        $trendPoints = $satisfactionTrend
            ->filter(fn (array $item) => $item['y'] !== null)
            ->map(fn (array $item) => "{$item['x']},{$item['y']}")
            ->implode(' ');

        $recentSurveys = Survey::query()
            ->with('category', 'creator')
            ->withCount([
                'responses as completed_responses_count' => fn ($query) => $query->where('is_completed', true),
            ])
            ->latest()
            ->limit(5)
            ->get();

        $insight = $this->buildInsight($averageSatisfaction, $maxLikert, $lowestIndicators->first());

        return view('dashboard.index', compact(
            'stats',
            'minLikert',
            'maxLikert',
            'totalLikertAnswers',
            'satisfactionDistribution',
            'satisfactionGradient',
            'categoryScores',
            'topIndicators',
            'lowestIndicators',
            'programStudyDistribution',
            'satisfactionTrend',
            'trendPoints',
            'recentSurveys',
            'insight'
        ));
    }

    private function satisfactionLabel(int $value, int $minLikert, int $maxLikert): string
    {
        $position = ($value - $minLikert) / ($maxLikert - $minLikert);

        return match (true) {
            $position >= 0.875 => 'Sangat Puas',
            $position >= 0.625 => 'Puas',
            $position >= 0.375 => 'Cukup Puas',
            $position >= 0.125 => 'Tidak Puas',
            default => 'Sangat Tidak Puas',
        };
    }

    private function buildInsight(float $average, int $maxLikert, ?array $lowestIndicator): array
    {
        if ($average <= 0) {
            return [
                'title' => 'Data kepuasan belum tersedia',
                'summary' => 'Belum ada jawaban skala Likert dari respons yang telah selesai.',
                'recommendation' => 'Pastikan survei aktif memiliki pertanyaan Likert dan mulai kumpulkan respons mahasiswa.',
                'tone' => 'neutral',
            ];
        }

        $ratio = $average / $maxLikert;
        $title = match (true) {
            $ratio >= 0.8 => 'Kepuasan berada pada tingkat sangat baik',
            $ratio >= 0.7 => 'Kepuasan berada pada tingkat baik',
            $ratio >= 0.6 => 'Kepuasan cukup, tetapi masih perlu ditingkatkan',
            default => 'Kepuasan membutuhkan perhatian',
        };
        $tone = match (true) {
            $ratio >= 0.8 => 'positive',
            $ratio >= 0.6 => 'warning',
            default => 'critical',
        };
        $recommendation = $lowestIndicator
            ? sprintf(
                'Prioritaskan perbaikan pada indikator “%s” yang memiliki rata-rata terendah, yaitu %s.',
                $lowestIndicator['question'],
                number_format($lowestIndicator['average'], 2, ',', '.')
            )
            : 'Pertahankan pemantauan rutin dan tambahkan pertanyaan Likert agar area perbaikan dapat diidentifikasi.';

        return [
            'title' => $title,
            'summary' => sprintf(
                'Indeks kepuasan keseluruhan saat ini adalah %s dari %s.',
                number_format($average, 2, ',', '.'),
                number_format($maxLikert, 0, ',', '.')
            ),
            'recommendation' => $recommendation,
            'tone' => $tone,
        ];
    }
}
