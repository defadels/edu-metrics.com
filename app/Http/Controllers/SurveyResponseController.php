<?php

namespace App\Http\Controllers;

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

        return view('dashboard.surveys.responses.index', compact('survey', 'responses'));
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
