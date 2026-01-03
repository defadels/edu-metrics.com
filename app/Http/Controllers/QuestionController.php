<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\LikertScale;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        $questions = Question::with('survey', 'likertScale')
            ->latest()
            ->paginate(15);

        return view('dashboard.questions.index', compact('questions'));
    }

    public function create(Request $request): View
    {
        $surveys = Survey::where('is_active', true)->get();
        $likertScales = LikertScale::all();
        $selectedSurvey = $request->get('survey_id');

        return view('dashboard.questions.create', compact('surveys', 'likertScales', 'selectedSurvey'));
    }

    public function store(StoreQuestionRequest $request): RedirectResponse
    {
        Question::create($request->validated());

        return redirect()->route('dashboard.questions.index')
            ->with('success', 'Question created successfully.');
    }

    public function show(Question $question): View
    {
        $question->load(['survey', 'likertScale', 'options']);

        return view('dashboard.questions.show', compact('question'));
    }

    public function edit(Question $question): View
    {
        $surveys = Survey::where('is_active', true)->get();
        $likertScales = LikertScale::all();
        $question->load('options');

        return view('dashboard.questions.edit', compact('question', 'surveys', 'likertScales'));
    }

    public function update(UpdateQuestionRequest $request, Question $question): RedirectResponse
    {
        $question->update($request->validated());

        return redirect()->route('dashboard.questions.index')
            ->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('dashboard.questions.index')
            ->with('success', 'Question deleted successfully.');
    }
}
