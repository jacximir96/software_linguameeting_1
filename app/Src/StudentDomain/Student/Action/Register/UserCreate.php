<?php

namespace App\Src\StudentDomain\Student\Action\Register;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\StudentDomain\Student\Request\StudentRegisterPersonalDataRequest;
use App\Src\UserDomain\User\Model\User;

trait UserCreate
{
    protected function createStudent(StudentRegisterPersonalDataRequest $request, Section $section): User
    {

        $university = $section->course->university;

        $student = new User();

        $student->name = $this->request->first_name;
        $student->lastname = $this->request->last_name;
        $student->email = $this->request->email;
        $student->active = true;
        $student->country_id = $university->country_id;
        $student->timezone_id = $university->timezone_id;

        if ($this->request->filled('password')) {
            $student->password = $this->request->password;
        }

        $student->save();

        return $student;
    }
}
