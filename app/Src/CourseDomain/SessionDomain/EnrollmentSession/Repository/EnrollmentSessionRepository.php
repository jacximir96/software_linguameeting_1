<?php

namespace App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;

class EnrollmentSessionRepository
{
    public static function findTrashed(int $id){
        return EnrollmentSession::withTrashed()->find($id);
    }

    public function obtainByEnrollmentAndSessionOrder(Enrollment $enrollment, SessionOrder $sessionOrder)
    {
        return EnrollmentSession::query()
            ->where('enrollment_id', $enrollment->id)
            ->where('session_order', $sessionOrder->get())
            ->orderBy('id', 'desc')
            ->first();
            //ordenamos de forma descendente...para obtener la última en cualquier caso (por si hubiera makeups (session_id_recovered))
    }

    public function obtainFirstByEnrollment(Enrollment $enrollment)
    {

        return EnrollmentSession::query()
            ->where('enrollment_id', $enrollment->id)
            ->orderBy('day', 'asc')
            ->orderBy('start_time')
            ->first();

    }

    public function obtainRecovered (EnrollmentSession $enrollmentSession){

        return EnrollmentSession::query()
            ->where('session_id_recovered', $enrollmentSession->id)
            ->first();
    }

    public function countMissedWithoutMakeup (Enrollment $enrollment){

        return EnrollmentSession::query()
            ->where('enrollment_id', $enrollment->id)
            ->where('session_status_id', SessionStatus::ID_MISSED)
            ->whereNull('makeup_id')
            ->count();

    }

    public function nextSessionOrder (Enrollment $enrollment):SessionOrder{

        $maxSessionOrder = EnrollmentSession::query()
            ->where('enrollment_id', $enrollment->id)
            ->max('session_order');

        $conversationPackage = $enrollment->course()->conversationPackage;

        if ($maxSessionOrder <= $conversationPackage->obtainSessionSetup()->sessionNumber()->get()){
            //el número máximo entra dentro del número de sesiones del curso => núm. sessiones más 1 (Extra)
            $maxSessionOrder = $conversationPackage->obtainSessionSetup()->sessionNumber()->get() + 1;
        }
        else{
            $maxSessionOrder++;
        }

        return new SessionOrder($maxSessionOrder);
    }

    public function countEnrollmentSessionsFromCourse(Course $course){

        return EnrollmentSession::query()
            ->whereHas('enrollment.section.course', function ($query) use ($course){
                $query->where('id', $course->id);
            })
            ->whereNull('makeup_id')
            ->count();
    }

    public function enrollmentSessionsFromCourseAndCoachingWeek(Course $course, CoachingWeek $coachingWeek){

        return EnrollmentSession::query()
            ->whereHas('enrollment.section.course', function ($query) use ($course){
                $query->where('id', $course->id);
            })
            ->where('coaching_week_id', $coachingWeek->id)
            ->get();
    }

    public function enrollmentSessionBySessionAndStudent (Session $session, User $student){

        return EnrollmentSession::query()
            ->where('session_id', $session->id)
            ->whereHas('enrollment', function ($query) use ($student){
                $query->where('student_id', $student->id);
            })
            ->first();
    }
}
