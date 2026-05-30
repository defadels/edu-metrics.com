<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Response;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SurveyResponseController extends Controller
{
    public function index(Survey $survey): View
    {
        $responses = Response::where('survey_id', $survey->id)
            ->where('is_completed', true)
            ->with(['user'])
            ->latest('completed_at')
            ->paginate(15);

        // Hitung total responden yang sudah menyelesaikan survei
        $totalResponses = Response::where('survey_id', $survey->id)
            ->where('is_completed', true)
            ->count();

        // Dapatkan pertanyaan beserta opsinya secara eager
        $questions = $survey->questions()
            ->with(['options', 'likertScale.options'])
            ->orderBy('order')
            ->get();

        $questionStats = [];
        $overallLikertDistribution = [];
        $totalLikertAnswers = 0;

        if ($totalResponses > 0) {
            // Ambil semua jawaban untuk respon yang selesai dengan eager loading
            $answers = Answer::whereIn('response_id', function ($query) use ($survey) {
                $query->select('id')
                    ->from('responses')
                    ->where('survey_id', $survey->id)
                    ->where('is_completed', true);
            })
            ->with(['response.user'])
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

                        // Kumpulkan untuk distribusi Likert keseluruhan
                        if (!isset($overallLikertDistribution[$opt->value])) {
                            $overallLikertDistribution[$opt->value] = [
                                'label' => $opt->label,
                                'count' => 0,
                                'percentage' => 0
                            ];
                        }
                        $overallLikertDistribution[$opt->value]['count'] += $count;
                        $totalLikertAnswers += $count;
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

        // Urutkan & hitung persentase Likert keseluruhan
        ksort($overallLikertDistribution);
        if ($totalLikertAnswers > 0) {
            foreach ($overallLikertDistribution as $val => &$data) {
                $data['percentage'] = round(($data['count'] / $totalLikertAnswers) * 100, 1);
            }
        }

        return view('dashboard.surveys.responses.index', compact(
            'survey', 
            'responses', 
            'totalResponses', 
            'questionStats', 
            'overallLikertDistribution',
            'totalLikertAnswers'
        ));
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
}
