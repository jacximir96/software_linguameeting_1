<?php

namespace App\Src\CourseDomain\CoachingForm\Middleware;

use App\Src\UserDomain\Role\Service\RoleChecker;
use Closure;
use Illuminate\Http\Request;

class UserCanHandleCoachinForm
{
    private RoleChecker $checkerRole;

    public function __construct(RoleChecker $checkerRole)
    {

        $this->checkerRole = $checkerRole;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (user()->hasAdminRoles()) {
            return $next($request);
        }

        if ($this->checkerRole->isSomeTeacher(user()->rol())){
            return $next($request);
        }

        abort('403');
    }
}
