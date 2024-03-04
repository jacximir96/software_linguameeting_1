<?php

namespace App\Src\UserDomain\User\Middleware;

use App\Src\UserDomain\Role\Service\RoleChecker;
use Closure;
use Illuminate\Http\Request;

class UserIsStudent
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

        $user = $request->student;

        if ($user) {
            if ($this->checkerRole->isStudent($user->rol())) {
                return $next($request);
            }
        }

        $user = user();
        if ($this->checkerRole->isStudent($user->rol())) {
            return $next($request);
        }

        abort('404');
    }
}
