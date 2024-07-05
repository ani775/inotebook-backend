<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateApi
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Optionally, you can redirect to a route or return a JSON response
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return $next($request);
    }
}
