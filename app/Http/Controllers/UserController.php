<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Search by Name, Email, or NIM
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Filter by Role
        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        // Filter by Program Study
        if ($programStudy = $request->input('program_study')) {
            $query->where('program_study', $programStudy);
        }

        // Summary statistics
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'total_responses' => Response::where('is_completed', true)->count(),
        ];

        $users = $query->withCount([
            'responses as completed_responses_count' => function ($q) {
                $q->where('is_completed', true);
            },
            'createdSurveys',
        ])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $programStudies = User::PROGRAM_STUDIES;
        $roles = User::ROLES;

        return view('dashboard.users.index', compact('users', 'stats', 'programStudies', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $programStudies = User::PROGRAM_STUDIES;
        $roles = User::ROLES;

        return view('dashboard.users.create', compact('programStudies', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:admin,mahasiswa'],
            'nim' => ['nullable', 'string', 'max:50', 'unique:users,nim'],
            'program_study' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'name.required' => 'Full name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'The email format is invalid.',
            'email.unique' => 'This email is already registered.',
            'role.required' => 'An account role must be selected.',
            'nim.unique' => 'This NIM is already used by another user.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nim' => $request->nim ?: null,
            'program_study' => $request->program_study ?: null,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('dashboard.users.index')
            ->with('success', 'The new user was added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $user->loadCount([
            'responses as completed_responses_count' => function ($q) {
                $q->where('is_completed', true);
            },
            'createdSurveys',
        ]);

        if ($user->isMahasiswa()) {
            $user->load([
                'responses' => function ($query) {
                    $query->with('survey.category')->latest('created_at');
                },
            ]);
        } elseif ($user->isAdmin()) {
            $user->load([
                'createdSurveys' => function ($query) {
                    $query->with('category')->withCount('responses')->latest();
                },
            ]);
        }

        return view('dashboard.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $programStudies = User::PROGRAM_STUDIES;
        $roles = User::ROLES;

        return view('dashboard.users.edit', compact('user', 'programStudies', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => ['required', 'in:admin,mahasiswa'],
            'nim' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('users', 'nim')->ignore($user->id),
            ],
            'program_study' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ], [
            'name.required' => 'Full name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'The email format is invalid.',
            'email.unique' => 'This email is already registered.',
            'role.required' => 'An account role must be selected.',
            'nim.unique' => 'This NIM is already used by another user.',
            'password.confirmed' => 'The new password confirmation does not match.',
        ]);

        // Prevent admin from demoting self
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return back()->withInput()->with('error', 'You cannot change the role of your own active account to a non-administrator role.');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'nim' => $request->nim ?: null,
            'program_study' => $request->program_study ?: null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('dashboard.users.index')
            ->with('success', "User '{$user->name}' was updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting the last administrator
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'The last administrator in the system cannot be deleted.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('dashboard.users.index')
            ->with('success', "User '{$userName}' was deleted successfully.");
    }
}
