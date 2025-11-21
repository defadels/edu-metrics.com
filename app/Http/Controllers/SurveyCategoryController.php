<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyCategoryRequest;
use App\Http\Requests\UpdateSurveyCategoryRequest;
use App\Models\SurveyCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SurveyCategoryController extends Controller
{
    public function index(): View
    {
        $categories = SurveyCategory::withCount('surveys')
            ->latest()
            ->paginate(15);

        return view('dashboard.survey-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('dashboard.survey-categories.create');
    }

    public function store(StoreSurveyCategoryRequest $request): RedirectResponse
    {
        SurveyCategory::create($request->validated());

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Kategori survey berhasil dibuat.');
    }

    public function show(SurveyCategory $category): View
    {
        $category->load('surveys');

        return view('dashboard.survey-categories.show', compact('category'));
    }

    public function edit(SurveyCategory $category): View
    {
        return view('dashboard.survey-categories.edit', compact('category'));
    }

    public function update(UpdateSurveyCategoryRequest $request, SurveyCategory $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Kategori survey berhasil diperbarui.');
    }

    public function destroy(SurveyCategory $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Kategori survey berhasil dihapus.');
    }
}
