<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MentorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access the mentor panel.');
        }

        if (!in_array(auth()->user()->role, ['mentor', 'admin'])) {
            abort(403, 'Access denied. Mentor account required.');
        }

        return $next($request);
    }
}
