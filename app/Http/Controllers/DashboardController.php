<?php

namespace App\Http\Controllers;

use App\Models\LikertScale;
use App\Models\Question;
use App\Models\Response;
use App\Models\Survey;
use App\Models\SurveyCategory;

class DashboardController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $stats = [
            'surveys' => Survey::count(),
            'categories' => SurveyCategory::count(),
            'likert_scales' => LikertScale::count(),
            'questions' => Question::count(),
            'responses' => Response::count(),
            'active_surveys' => Survey::where('is_active', true)->count(),
        ];

        $recentSurveys = Survey::with('category', 'creator')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentSurveys'));
    }
}
