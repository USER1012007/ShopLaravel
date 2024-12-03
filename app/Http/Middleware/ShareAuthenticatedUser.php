<?php

namespace App\Http\Middleware;
use Inertia\Inertia;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShareAuthenticatedUser
{
    public function handle(Request $request, Closure $next)
    {
        Inertia::share([
            'auth' => [
                'user' => auth()->user(),
            ],
        ]);

        return $next($request);
    }
}
