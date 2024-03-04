<?php

namespace App\Src\CourseDomain\CoachingForm\Rule;


use Illuminate\Contracts\Validation\Rule;


class UniversityInstructorRule implements Rule
{
    public function passes($attribute, $value)
    {

        $universities = user()->university;

        foreach ($universities as $university){
            if ($university->id == $value){
                return true;
            }
        }

        return false;
    }

    public function message()
    {
        return 'Selected university is not valid.';
    }
}
