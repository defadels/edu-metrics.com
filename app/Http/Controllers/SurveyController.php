<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Models\Survey;
use App\Models\SurveyCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SurveyController extends Controller
{
    public function index(): View
    {
        $surveys = Survey::with('category', 'creator')
            ->withCount('questions', 'responses')
            ->latest()
            ->paginate(15);

        return view('dashboard.surveys.index', compact('surveys'));
    }

    public function create(): View
    {
        $categories = SurveyCategory::where('is_active', true)->get();

        return view('dashboard.surveys.create', compact('categories'));
    }

    public function store(StoreSurveyRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        Survey::create($data);

        return redirect()->route('dashboard.surveys.index')
            ->with('success', 'Survey berhasil dibuat.');
    }

    public function show(Survey $survey): View
    {
        $survey->load(['category', 'creator', 'questions.likertScale', 'questions.options']);

        return view('dashboard.surveys.show', compact('survey'));
    }

    public function edit(Survey $survey): View
    {
        $categories = SurveyCategory::where('is_active', true)->get();

        return view('dashboard.surveys.edit', compact('survey', 'categories'));
    }

    public function update(UpdateSurveyRequest $request, Survey $survey): RedirectResponse
    {
        $survey->update($request->validated());

        return redirect()->route('dashboard.surveys.index')
            ->with('success', 'Survey berhasil diperbarui.');
    }

    public function destroy(Survey $survey): RedirectResponse
    {
        $survey->delete();

        return redirect()->route('dashboard.surveys.index')
            ->with('success', 'Survey berhasil dihapus.');
    }
}
