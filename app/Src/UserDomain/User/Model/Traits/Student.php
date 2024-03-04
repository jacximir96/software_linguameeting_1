<?php

namespace App\Src\UserDomain\User\Model\Traits;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;

trait Student
{
    public function enrollmentActive()
    {
        return $this->enrollment()->where('active', 1)->first();
    }

    public function enrollment()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function enrollmentDesc()
    {
        return $this->hasMany(Enrollment::class, 'student_id')->orderBy('id', 'desc');
    }

    public function mustPayForExperiences(): bool
    {

        if ($this->isInstructor()){
            return false;
        }

        foreach ($this->enrollment as $enrollment) {

            if ($enrollment->isActive()) {
                $conversationPackage = $enrollment->section->course->conversationPackage;

                return ! $conversationPackage->hasExperiences();
            }
        }

        return true;
    }
}
