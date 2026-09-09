<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Response;
use App\Models\Survey;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class SurveyResponseController extends Controller
{
    public function index(Survey $survey): View
    {
        $responses = Response::where('survey_id', $survey->id)
            ->where('is_completed', true)
            ->with(['user'])
            ->latest('completed_at')
            ->paginate(15);

        $analytics = $this->getSurveyAnalytics($survey);

        return view('dashboard.surveys.responses.index', array_merge([
            'survey' => $survey,
            'responses' => $responses,
        ], $analytics));
    }

    public function show(Survey $survey, Response $response): View
    {
        if ($response->survey_id != $survey->id) {
            abort(404, 'Response not found for this survey');
        }

        $response->load([
            'user',
            'answers.selectedOption',
            'answers.question.options',
            'answers.question.likertScale.options'
        ]);

        $survey->load([
            'questions.options',
            'questions.likertScale.options'
        ]);

        return view('dashboard.surveys.responses.show', compact('survey', 'response'));
    }

    /**
     * Export all completed survey responses to Excel format (.xls)
     */
    public function exportExcel(Survey $survey): HttpResponse
    {
        $survey->load(['category', 'creator']);

        $questions = $survey->questions()
            ->with(['options', 'likertScale.options'])
            ->orderBy('order')
            ->get();

        $responses = Response::where('survey_id', $survey->id)
            ->where('is_completed', true)
            ->with([
                'user',
                'answers.selectedOption',
                'answers.question.likertScale.options'
            ])
            ->latest('completed_at')
            ->get();

        $analytics = $this->getSurveyAnalytics($survey);

        $filename = 'laporan_respon_' . Str::slug($survey->title) . '_' . date('Ymd_His') . '.xls';

        $content = view('dashboard.surveys.responses.excel', array_merge([
            'survey' => $survey,
            'questions' => $questions,
            'responses' => $responses,
        ], $analytics))->render();

        return response($content, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * Export survey summary & responses to PDF format
     */
    public function exportPdf(Survey $survey): HttpResponse
    {
        $survey->load(['category', 'creator']);

        $questions = $survey->questions()
            ->with(['options', 'likertScale.options'])
            ->orderBy('order')
            ->get();

        $responses = Response::where('survey_id', $survey->id)
            ->where('is_completed', true)
            ->with([
                'user',
                'answers.selectedOption',
                'answers.question.likertScale.options'
            ])
            ->latest('completed_at')
            ->get();

        $analytics = $this->getSurveyAnalytics($survey);

        $filename = 'laporan_hasil_survei_' . Str::slug($survey->title) . '_' . date('Ymd_His') . '.pdf';

        $pdf = Pdf::loadView('dashboard.surveys.responses.pdf', array_merge([
            'survey' => $survey,
            'questions' => $questions,
            'responses' => $responses,
        ], $analytics));

        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);

        return $pdf->download($filename);
    }

    /**
     * Helper to compute survey aggregations and distributions
     */
    private function getSurveyAnalytics(Survey $survey): array
    {
        $totalResponses = Response::where('survey_id', $survey->id)
            ->where('is_completed', true)
            ->count();

        $questions = $survey->questions()
            ->with(['options', 'likertScale.options'])
            ->orderBy('order')
            ->get();

        $questionStats = [];
        $overallLikertDistribution = [];
        $totalLikertAnswers = 0;
        $likertTotal = 0;
        $likertCount = 0;

        if ($totalResponses > 0) {
            $answers = Answer::whereIn('response_id', function ($query) use ($survey) {
                $query->select('id')
                    ->from('responses')
                    ->where('survey_id', $survey->id)
                    ->where('is_completed', true);
            })
            ->with(['response.user', 'selectedOption', 'question.likertScale.options'])
            ->get()
            ->groupBy('question_id');

            foreach ($questions as $question) {
                $stats = [
                    'question' => $question,
                    'total_answers' => 0,
                    'options' => []
                ];

                $questionAnswers = $answers->get($question->id, collect());
                $stats['total_answers'] = $questionAnswers->count();

                if ($question->question_type === 'likert' && $question->likertScale) {
                    $scaleOptions = $question->likertScale->options->sortBy('value');
                    foreach ($scaleOptions as $opt) {
                        $count = $questionAnswers->where('likert_value', $opt->value)->count();
                        $percentage = $stats['total_answers'] > 0 ? round(($count / $stats['total_answers']) * 100, 1) : 0;
                        
                        $stats['options'][] = [
                            'label' => $opt->label,
                            'value' => $opt->value,
                            'count' => $count,
                            'percentage' => $percentage
                        ];

                        if (!isset($overallLikertDistribution[$opt->value])) {
                            $overallLikertDistribution[$opt->value] = [
                                'label' => $opt->label,
                                'count' => 0,
                                'percentage' => 0
                            ];
                        }
                        $overallLikertDistribution[$opt->value]['count'] += $count;
                        $totalLikertAnswers += $count;
                        $likertTotal += $opt->value * $count;
                        $likertCount += $count;
                    }
                } elseif ($question->question_type === 'multiple_choice') {
                    foreach ($question->options as $opt) {
                        $count = $questionAnswers->where('selected_option_id', $opt->id)->count();
                        $percentage = $stats['total_answers'] > 0 ? round(($count / $stats['total_answers']) * 100, 1) : 0;
                        
                        $stats['options'][] = [
                            'label' => $opt->option_text,
                            'id' => $opt->id,
                            'count' => $count,
                            'percentage' => $percentage
                        ];
                    }
                } elseif ($question->question_type === 'text') {
                    $stats['text_responses'] = $questionAnswers->whereNotNull('text_value')
                        ->map(function ($ans) use ($survey) {
                            $respondentName = 'Anonymous';
                            if (!$survey->is_anonymous && $ans->response) {
                                $respondentName = $ans->response->user->name ?? $ans->response->respondent_name ?? 'Anonymous';
                            }
                            return [
                                'text' => $ans->text_value,
                                'respondent' => $respondentName,
                                'date' => $ans->created_at ? $ans->created_at->format('d M Y, H:i') : null
                            ];
                        })->toArray();
                }

                $questionStats[$question->id] = $stats;
            }
        }

        ksort($overallLikertDistribution);
        if ($totalLikertAnswers > 0) {
            foreach ($overallLikertDistribution as $val => &$data) {
                $data['percentage'] = round(($data['count'] / $totalLikertAnswers) * 100, 1);
            }
        }

        $avgLikert = $likertCount > 0 ? round($likertTotal / $likertCount, 2) : 0;

        return [
            'totalResponses' => $totalResponses,
            'questions' => $questions,
            'questionStats' => $questionStats,
            'overallLikertDistribution' => $overallLikertDistribution,
            'totalLikertAnswers' => $totalLikertAnswers,
            'avgLikert' => $avgLikert,
        ];
    }
}
