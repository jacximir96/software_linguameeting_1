<?php

namespace App\Src\CourseDomain\CoachingForm\Rule;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\UserDomain\Role\Service\RoleChecker;
use Illuminate\Contracts\Validation\Rule;

class CourseInstructorRule implements Rule
{

    public function passes($attribute, $value)
    {

        $course = Course::find($value);

        $universities = user()->university;
return false;
        foreach ($universities as $university){
            if ($university->id == $course->university_id){
                return true;
            }
        }

        return false;
    }

    public function message()
    {
        return 'Selected course is not valid.';
    }
}
