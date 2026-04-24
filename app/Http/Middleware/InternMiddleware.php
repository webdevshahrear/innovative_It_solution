<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InternMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access the intern dashboard.');
        }

        if (auth()->user()->role !== 'intern') {
            abort(403, 'Access denied. Intern account required.');
        }

        $account = auth()->user()->internAccount;

        if (!$account || $account->status !== 'active') {
            auth()->logout();
            return redirect()->route('internship.landing')
                ->with('error', 'Your intern account is not active. Please contact support.');
        }

        return $next($request);
    }
}
