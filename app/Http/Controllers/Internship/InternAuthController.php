<?php

namespace App\Http\Controllers\Internship;

use App\Http\Controllers\Controller;
use App\Models\InternshipAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InternAuthController extends Controller
{
    /**
     * Show intern login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'intern') {
                return redirect()->route('intern.dashboard');
            }
            return redirect()->route('dashboard');
        }
        return view('internship.login');
    }

    /**
     * Handle intern login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Check if user is an intern
            if ($user->role === 'intern') {
                $request->session()->regenerate();
                return redirect()->intended(route('intern.dashboard'));
            }

            // If not an intern, logout and error
            Auth::logout();
            return back()->withErrors([
                'email' => 'Access denied. This portal is for interns only.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show account creation form (post-payment).
     */
    public function showRegister(string $token)
    {
        $account = InternshipAccount::where('registration_token', $token)->firstOrFail();

        // If user already created, redirect to dashboard
        if ($account->user_id && $account->user_id !== 0) {
            return redirect()->route('intern.dashboard')
                ->with('info', 'Account already created. Please login.');
        }

        $application = $account->application;

        return view('internship.register', compact('account', 'application', 'token'));
    }

    /**
     * Create the intern user account.
     */
    public function register(Request $request, string $token)
    {
        $account = InternshipAccount::where('registration_token', $token)->firstOrFail();

        if ($account->user_id && $account->user_id !== 0) {
            return redirect()->route('intern.dashboard');
        }

        $application = $account->application;

        $request->validate([
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.min'    => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        if (User::where('email', $application->email)->exists()) {
            return back()->with('error', 'This email is already registered. Please login instead.');
        }

        // Create the user
        $user = User::create([
            'name'     => $application->full_name,
            'email'    => $application->email,
            'password' => Hash::make($request->password),
            'role'     => 'intern',
        ]);

        // Link the intern account and activate it
        $account->update([
            'user_id'            => $user->id,
            'status'             => 'active', // Ensure the account is active
            'registration_token' => null, // Consume the token
        ]);

        // Update application status
        $application->update(['status' => 'active']);

        // Auto-login
        Auth::login($user);

        return redirect()->route('intern.dashboard')
            ->with('success', '🎉 Welcome to Innovative IT Solutions Internship Program! Your account has been created successfully.');
    }
}
