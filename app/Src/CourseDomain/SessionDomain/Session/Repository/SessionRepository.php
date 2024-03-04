<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Repository;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus;
use App\Src\TimeDomain\Date\Service\Period;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class SessionRepository
{

    public static function findTrashed(int $id){
        return Session::withTrashed()->find($id);
    }

    public function obtainForPeriod(Period $period)
    {

        return Session::query()
            ->with($this->relations())
            ->filterPeriod($period->get())
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

    }

    public function obtainForCourseInPeriod(Course $course, CarbonPeriod $period)
    {

        return Session::query()
            ->with($this->relations())
            ->where('course_id', $course->id)
            ->filterPeriod($period)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

    }

    //$period en UTC
    public function obtainSessionForCoachInPeriod(User $coach, CarbonPeriod $period)
    {

        return Session::query()
            ->with($this->relations())
            ->where('coach_id', $coach->id)
            ->whereNotNull('course_id')
            ->filterPeriod($period)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
    }

    public function obtainSessionForSalary(User $coach, CarbonPeriod $period)
    {

        return Session::query()
            ->with($this->relations())
            ->where('coach_id', $coach->id)
            ->where('coach_session_status_id', SessionStatus::ID_ATTENDANCE)
            ->has('enrollmentSession')
            ->whereNotNull('course_id')
            ->filterPeriod($period)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
    }

    public function countPedingSessionsForCoach(User $coach): int
    {

        $now = Carbon::now();

        return Session::query()
            ->where('coach_id', $coach->id)
            ->filterGreater($now)
            ->count();

    }

    public function numSessionsCoachWithCourse (User $coach, Course $course):int{

        return Session::query()
            ->where('coach_id', $coach->id)
            ->where('course_id', $course->id)
            ->count();
    }

    public function obtainSessionByCoachCourseAndDate (User $coach, Course $course, Carbon $date ){

        return Session::query()
            ->where('coach_id', $coach->id)
            ->where('course_id', $course->id)
            ->where('day', $date->toDateString())
            ->where('start_time', $date->toDateTimeString())
            ->first();
    }

    public function numSessionsCoachWithUniversity (User $coach, University $university):int{

        return Session::query()
            ->where('coach_id', $coach->id)
            ->whereHas('course', function ($query) use($university){
                return $query->where('university_id', $university->id);
            })
            ->count();

    }

    public function obtainSessionForStudentInPeriod(User $student, CarbonPeriod $period)
    {

        return Session::query()
            ->with($this->relations())
            ->whereHas('enrollmentSession.enrollment', function ($query) use ($student){
                $query->where('student_id', '=', $student->id);
            })
            ->filterPeriod($period)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
    }

    public function relations(): array
    {

        return [
            'coach',
            'coach.coachInfo',
            'coachSchedule',
            'coachSessionStatus',
            'course',
            'course.university',
            'enrollmentSession',
            'enrollmentSession.coachingWeek',
            'enrollmentSession.coachingWeek.assignment',
            'enrollmentSession.coachingWeek.assignment.guide',
            'enrollmentSession.coachingWeek.assignment.chapter',
            'enrollmentSession.coachingWeek.assignment.file',
            'enrollmentSession.enrollment',
            'enrollmentSession.enrollment.accommodation',
            'enrollmentSession.enrollment.section',
            'enrollmentSession.enrollment.section.course',
            'enrollmentSession.recovered',
            'replacedCoach',
            'replacedCoach.replacedCoach',
            'replacedCoach.newCoach',
        ];
    }
}
