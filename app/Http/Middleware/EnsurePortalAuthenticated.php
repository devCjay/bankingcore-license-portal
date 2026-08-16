<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsurePortalAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('license_portal_authenticated')) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
