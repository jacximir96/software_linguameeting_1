<?php
namespace App\Src\StudentDomain\EnrollmentStatus\Service;

use App\Src\StudentDomain\EnrollmentStatus\Model\EnrollmentStatus;


class EnrollmentStatusBuilder
{

    public static function buildChanged ():EnrollmentStatus{
        return EnrollmentStatus::find(EnrollmentStatus::CHANGED_ID);
    }

    public static function buildRefunded ():EnrollmentStatus{
        return EnrollmentStatus::find(EnrollmentStatus::REFUNDED_ID);
    }
}
