<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role == 'SuperAdmin') {
            return $next($request);
        }

        abort(403);
    }
}
