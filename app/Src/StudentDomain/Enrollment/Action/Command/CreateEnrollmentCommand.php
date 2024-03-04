<?php

namespace App\Src\StudentDomain\Enrollment\Action\Command;

use App\Src\CourseDomain\Section\Model\Section;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\EnrollmentStatus\Model\EnrollmentStatus;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class CreateEnrollmentCommand
{
    public function handle(User $student, Section $section): Enrollment
    {

        $now = Carbon::now();

        $enrollment = new Enrollment();
        $enrollment->student_id = $student->id;
        $enrollment->section_id = $section->id;
        $enrollment->active = 1;
        $enrollment->status_id = EnrollmentStatus::ACTIVE_ID;
        $enrollment->status_at = $now;

        $enrollment->save();

        return $enrollment;
    }
}
