<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RespondentController extends Controller
{
    public function index(): View
    {
        // Get all users who have the role 'user', counting their completed survey responses
        $respondents = User::where('role', 'user')
            ->withCount(['responses' => function ($query) {
                $query->where('is_completed', true);
            }])
            ->latest()
            ->paginate(15);

        return view('dashboard.respondents.index', compact('respondents'));
    }

    public function show(User $respondent): View
    {
        // We ensure we only show profiles of users with role 'user'
        if ($respondent->role !== 'user') {
            abort(404, 'Respondent not found.');
        }

        // Load responses and their associated survey details
        $respondent->load(['responses' => function ($query) {
            $query->where('is_completed', true)
                  ->with('survey.category')
                  ->latest('completed_at');
        }]);

        return view('dashboard.respondents.show', compact('respondent'));
    }
}
