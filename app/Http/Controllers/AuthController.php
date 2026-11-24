<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivityLog;
use App\Services\BusinessRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('app.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', strtolower(trim($credentials['email'])))->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => __('auth.failed'),
            ])->onlyInput('email');
        }

        if ($user->status === 'suspended') {
            return back()->withErrors([
                'email' => __('auth.account_suspended'),
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Update user locale session
        session(['locale' => $user->locale ?? 'en']);

        UserActivityLog::record('login', 'User signed in', $user->id, $user->current_business_id);

        if ($user->is_super_admin && !$user->current_business_id) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('app.dashboard'));
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('app.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request, BusinessRegistrationService $registrationService)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'business_name' => ['required', 'string', 'max:255'],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'registration_number' => ['nullable', 'string', 'max:50'],
            'tin' => ['nullable', 'string', 'max:50'],
            'vat_number' => ['nullable', 'string', 'max:50'],
            'is_vat_registered' => ['nullable', 'boolean'],
            'city' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'invoice_locale' => ['nullable', 'in:en,si,ta'],
        ]);

        $result = $registrationService->register($validated);

        Auth::login($result['user']);
        $request->session()->regenerate();

        return redirect()->route('app.dashboard')
            ->with('success', __('app.trial_banner_title'));
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            UserActivityLog::record('logout', 'User signed out', Auth::id(), Auth::user()->current_business_id);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
}
