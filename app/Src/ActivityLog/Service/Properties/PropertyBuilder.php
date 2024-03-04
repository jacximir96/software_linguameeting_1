<?php
namespace App\Src\ActivityLog\Service\Properties;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Model\Makeup;
use Carbon\Carbon;
use App\Src\UserDomain\User\Model\User as UserModel;

class PropertyBuilder
{



    public static function buildMakeup (Makeup $makeup):\App\Src\ActivityLog\Service\Properties\Makeup{
        return new \App\Src\ActivityLog\Service\Properties\Makeup($makeup);
    }

    public static function buildEnrollmentSessionWithMakeup (EnrollmentSession $enrollmentSession):EnrollmentSessionWithMakeup{
        return new EnrollmentSessionWithMakeup($enrollmentSession);
    }




    public static function buildDatetime (Carbon $moment):Datetime{
        return new Datetime($moment);
    }

    public static function buildEnrollment (Enrollment $enrollment):\App\Src\ActivityLog\Service\Properties\Enrollment{
        return new \App\Src\ActivityLog\Service\Properties\Enrollment($enrollment);
    }

    public static function buildEnrollmentSession (EnrollmentSession $enrollmentSession):EnrollmentSessionWithMakeup{
        return new EnrollmentSessionWithMakeup($enrollmentSession);
    }

    public static function buildIp (string $ip):IpAddress{
        return new IpAddress($ip);
    }

    public static function buildUser (UserModel $user):User{
        return new User($user);
    }

    public static function buildSection (\App\Src\CourseDomain\Section\Model\Section $section):Section{
        return new Section($section);
    }

    public static function buildSession (\App\Src\CourseDomain\SessionDomain\Session\Model\Session $section):Session{
        return new Session($section);
    }
}
