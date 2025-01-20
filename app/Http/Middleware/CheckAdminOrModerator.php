<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminOrModerator
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator'))) {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}
