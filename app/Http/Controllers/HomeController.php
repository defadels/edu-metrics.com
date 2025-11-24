<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyCategory;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $activeSurveys = Survey::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with('category')
            ->latest()
            ->limit(6)
            ->get();

        $categories = SurveyCategory::where('is_active', true)
            ->withCount('surveys')
            ->get();

        $stats = [
            'total_surveys' => Survey::where('is_active', true)->count(),
            'active_surveys' => Survey::where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count(),
            'categories' => SurveyCategory::where('is_active', true)->count(),
        ];

        return view('home', compact('activeSurveys', 'categories', 'stats'));
    }
}
