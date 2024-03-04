<?php

namespace App\Src\ExperienceDomain\Experience\Middleware;

use Closure;
use Illuminate\Http\Request;

class CreatePrivateTipMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $experience = $request->experience;

        if ($experience->isDonatePrivate()) {
            return $next($request);
        }

        flash(trans('experience.tip.error.no_can_donate_private'))->error();

        return redirect()->route('feedback-modal');
    }
}
