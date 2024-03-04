<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionCoachIsOwner
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
        if (user()->hasAdminRoles()) {
            return $next($request);
        }

        if (user()->isCoach()) {
            if ($request->session->coachIsOwner(user())) {
                return $next($request);
            }
        }

        abort(403);
    }
}
