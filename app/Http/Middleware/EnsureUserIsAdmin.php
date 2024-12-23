<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{

    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user() || !auth()->user()->hasRole('admin')) {
            return redirect()->route('welcome')->withErrors(['You do not have permission to access this page.']);
        }
        return $next($request);
    }
}
