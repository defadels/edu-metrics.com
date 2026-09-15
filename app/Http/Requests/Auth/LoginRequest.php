<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $login = $this->input('login') ?? $this->input('email');

        if ($login !== null) {
            $this->merge([
                'login' => trim((string) $login),
                'email' => trim((string) $login),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login = (string) ($this->input('login') ?? $this->input('email'));
        $password = (string) $this->input('password');

        // Find candidate users matching email, nim, or name (username)
        $users = User::where(function ($query) use ($login) {
            $query->where('email', $login)
                ->orWhere('nim', $login)
                ->orWhere('name', $login);
        })->get();

        $authenticatedUser = null;
        foreach ($users as $candidate) {
            if (Hash::check($password, $candidate->password)) {
                $authenticatedUser = $candidate;
                break;
            }
        }

        if (! $authenticatedUser) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
                'email' => trans('auth.failed'),
            ]);
        }

        Auth::login($authenticatedUser, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        $message = trans('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]);

        throw ValidationException::withMessages([
            'login' => $message,
            'email' => $message,
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        $login = (string) ($this->input('login') ?? $this->input('email'));

        return Str::transliterate(Str::lower($login).'|'.$this->ip());
    }
}
