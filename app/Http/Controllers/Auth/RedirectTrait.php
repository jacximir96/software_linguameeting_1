<?php


namespace App\Http\Controllers\Auth;


trait RedirectTrait
{

    protected function redirectTo (){

        if (user()->isCoach()){
            return route('get.coach.dashboard');
        }
        elseif(user()->isStudent()){
            return route('get.student.dashboard');
        }
        elseif(user()->isInstructor()){
            return route('get.instructor.dashboard');
        }
        elseif(user()->isAdmin()){
            return route('get.admin.dashboard.index');
        }

        return $this->redirectTo;
    }

}
