<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Usage in routes: ->middleware('role:admin') or ->middleware('role:admin,user')
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
