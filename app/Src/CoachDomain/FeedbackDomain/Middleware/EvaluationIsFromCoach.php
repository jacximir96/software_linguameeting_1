<?php

namespace App\Src\CoachDomain\FeedbackDomain\Middleware;

use App\Src\CoachDomain\FeedbackDomain\ManagerEvaluationFile\Model\ManagerEvaluationFile;
use Closure;
use Illuminate\Http\Request;

class EvaluationIsFromCoach
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $file = $request->file;

        if ($file instanceof ManagerEvaluationFile) {

            $evaluation = $file->evaluation;

            if ($evaluation->coachIsOwner(user())) {
                return $next($request);
            }
        }

        abort(403);
    }
}
