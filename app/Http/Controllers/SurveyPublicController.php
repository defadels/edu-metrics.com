<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Response;
use App\Models\Survey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SurveyPublicController extends Controller
{
    public function index(): View
    {
        $surveys = Survey::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with(['category', 'questions'])
            ->withCount('questions', 'responses')
            ->latest()
            ->paginate(12);

        return view('surveys.index', compact('surveys'));
    }

    public function show(Survey $survey): View
    {
        if (! $survey->is_active || $survey->start_date > now() || $survey->end_date < now()) {
            abort(404, 'Survey tidak tersedia');
        }

        $survey->load(['category', 'questions.likertScale', 'questions.options']);

        // Check if user already submitted
        $hasResponded = false;
        if (Auth::check() && ! $survey->is_anonymous) {
            $hasResponded = Response::where('survey_id', $survey->id)
                ->where('user_id', Auth::id())
                ->where('is_completed', true)
                ->exists();
        }

        return view('surveys.show', compact('survey', 'hasResponded'));
    }

    public function start(Survey $survey): RedirectResponse|View
    {
        if (! $survey->is_active || $survey->start_date > now() || $survey->end_date < now()) {
            abort(404, 'Survey tidak tersedia');
        }

        // Check if user already has an active response
        $activeResponse = null;
        if (Auth::check() && ! $survey->is_anonymous) {
            $activeResponse = Response::where('survey_id', $survey->id)
                ->where('user_id', Auth::id())
                ->where('is_completed', false)
                ->first();
        }

        if (! $activeResponse) {
            $activeResponse = Response::create([
                'survey_id' => $survey->id,
                'user_id' => Auth::check() && ! $survey->is_anonymous ? Auth::id() : null,
                'respondent_name' => $survey->is_anonymous ? null : (Auth::check() ? Auth::user()->name : null),
                'started_at' => now(),
                'is_completed' => false,
            ]);
        }

        $survey->load(['questions.likertScale', 'questions.options']);

        return view('surveys.fill', compact('survey', 'activeResponse'));
    }

    public function submit(Request $request, Survey $survey): RedirectResponse
    {
        if (! $survey->is_active || $survey->start_date > now() || $survey->end_date < now()) {
            abort(404, 'Survey not available');
        }

        $request->validate([
            'response_id' => 'required|exists:responses,id',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
        ]);

        $response = Response::findOrFail($request->input('response_id'));

        // Validate response belongs to survey
        if ($response->survey_id !== $survey->id) {
            abort(403);
        }

        // Validate user ownership if not anonymous
        if (! $survey->is_anonymous && Auth::check() && $response->user_id !== Auth::id()) {
            abort(403);
        }

        // Save answers
        foreach ($request->input('answers', []) as $answerData) {
            if (! isset($answerData['question_id'])) {
                continue;
            }

            $question = Question::findOrFail($answerData['question_id']);

            // Validate question belongs to survey
            if ($question->survey_id !== $survey->id) {
                continue;
            }

            // Skip if no answer provided (for optional questions)
            $hasAnswer = false;
            if ($question->question_type === 'likert' && isset($answerData['likert_value'])) {
                $hasAnswer = true;
            } elseif ($question->question_type === 'text' && ! empty($answerData['text_value'])) {
                $hasAnswer = true;
            } elseif ($question->question_type === 'multiple_choice' && isset($answerData['selected_option_id'])) {
                $hasAnswer = true;
            }

            if (! $hasAnswer && $question->is_required) {
                continue; // Skip required questions without answers (should be validated by frontend)
            }

            // Delete existing answer for this question
            Answer::where('response_id', $response->id)
                ->where('question_id', $question->id)
                ->delete();

            // Create new answer based on question type
            $answer = new Answer([
                'response_id' => $response->id,
                'question_id' => $question->id,
            ]);

            switch ($question->question_type) {
                case 'likert':
                    $answer->likert_value = $answerData['likert_value'] ?? null;
                    break;
                case 'text':
                    $answer->text_value = $answerData['text_value'] ?? null;
                    break;
                case 'multiple_choice':
                    $answer->selected_option_id = $answerData['selected_option_id'] ?? null;
                    break;
            }

            if ($hasAnswer) {
                $answer->save();
            }
        }

        // Mark response as completed
        $response->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        return redirect()->route('surveys.thank-you', $survey)
            ->with('success', 'Thank you! Your survey has been successfully submitted.');
    }

    public function thankYou(Survey $survey): View
    {
        return view('surveys.thank-you', compact('survey'));
    }

    public function history(): View
    {
        $responses = Response::where('user_id', Auth::id())
            ->where('is_completed', true)
            ->with(['survey.category'])
            ->latest('completed_at')
            ->paginate(10);

        return view('surveys.history', compact('responses'));
    }
}
