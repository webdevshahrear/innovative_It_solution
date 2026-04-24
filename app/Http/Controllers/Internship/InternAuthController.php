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
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'email.unique'    => 'This email is already registered. Please login instead.',
            'password.min'    => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        // Create the user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'intern',
        ]);

        // Link the intern account
        $account->update([
            'user_id'            => $user->id,
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
