<?php

namespace App\Src\InstructorDomain\Instructor\Action;

use App\Src\InstructorDomain\Instructor\Request\FullInstructorRequest;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class InstructorProcessRequest
{
    public function handle(FullInstructorRequest $request, User $instructor): User
    {
        $instructor->name = $request->name;
        $instructor->lastname = $request->lastname;
        $instructor->email = $request->email;
        $instructor->country_id = $request->country_id;
        $instructor->timezone_id = $request->timezone_id;
        $instructor->active = $request->active;
        $instructor->internal_comment = $request->internal_comment ?? '';

        if ($request->has('email_verified')){

            $emailVerified = (bool)$request->email_verified;

            if ( ! $emailVerified){
                $instructor->email_verified_at = null;
            }
            else{

                if ( ! $instructor->hasEmailVerified()){
                    $instructor->email_verified_at = Carbon::now();
                }
            }
        }

        if ($request->filled('password')) {
            $instructor->password = $request->password;
        }

        return $instructor;
    }
}
