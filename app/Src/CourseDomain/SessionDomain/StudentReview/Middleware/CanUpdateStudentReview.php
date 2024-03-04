<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReview\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanUpdateStudentReview
{
    public function handle(Request $request, Closure $next)
    {

        if (user()->hasAdminRoles()) {
            return $next($request);
        }

        if (user()->isCoach()) {

            if ($this->coachCanUpdate($request)) {
                return $next($request);
            }
        }

        abort(403);
    }

    private function coachCanUpdate(Request $request): bool
    {

        //create
        $enrollmentSession = $request->enrollmentSession;
        if ($enrollmentSession) {
            return $enrollmentSession->session->coachIsOwner(user());
        }

        //update
        $sessionFeedback = $request->sessionFeedback;
        if ($sessionFeedback) {
            return $sessionFeedback->enrollmentSession->session->coachIsOwner(user());
        }

        return false;
    }
}
