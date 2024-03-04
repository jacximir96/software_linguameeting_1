<?php

namespace App\Src\UserDomain\User\Middleware;

use App\Src\UserDomain\Role\Service\RoleChecker;
use Closure;
use Illuminate\Http\Request;

class UserIsInstructor
{

    private RoleChecker $checkerRole;

    public function __construct (RoleChecker $checkerRole){

        $this->checkerRole = $checkerRole;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $user = $request->instructor;

        if ($user){
            if ($this->checkerRole->isSomeTeacher($user->rol())){
                return $next($request);
            }
        }

        $user = $request->coordinator;
        if ($user){
            if ($this->checkerRole->isSomeTeacher($user->rol())){
                return $next($request);
            }
        }

        $user = $request->course_manager;
        if ($user){
            if ($this->checkerRole->isSomeTeacher($user->rol())){
                return $next($request);
            }
        }

        $user = $request->course_coordinator;
        if ($user){
            if ($this->checkerRole->isSomeTeacher($user->rol())){
                return $next($request);
            }
        }

        $user = $request->teaching_assistant;
        if ($user){
            if ($this->checkerRole->isSomeTeacher($user->rol())){
                return $next($request);
            }
        }

        $user = user();
        if ($user){
            if ($this->checkerRole->isSomeTeacher($user->rol())){
                return $next($request);
            }
        }


        abort('404');
    }
}
