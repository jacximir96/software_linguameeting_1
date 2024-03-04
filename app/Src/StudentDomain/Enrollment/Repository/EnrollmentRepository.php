<?php

namespace App\Src\StudentDomain\Enrollment\Repository;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\Shared\Service\IdCollection;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\EnrollmentStatus\Model\EnrollmentStatus;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EnrollmentRepository
{
    public static function findTrashed(int $id){
        return Enrollment::withTrashed()->find($id);
    }

    public function activeForStudent(User $student)
    {

        return Enrollment::query()
            ->with($this->relationships())
            ->where('student_id', $student->id)
            ->where('status_id', EnrollmentStatus::ACTIVE_ID)
            ->orderBy('id', 'desc')
            ->get();

    }

    public function pastForStudent(User $student)
    {
        $now = Carbon::now();

        return Enrollment::query()
            ->with($this->relationships())
            ->where('student_id', $student->id)
            ->where('status_id','!=', EnrollmentStatus::ACTIVE_ID)
            //->whereHas('section.course', function ($query) use ($now){
            //    $query->where('end_date', '<=', $now->toDateTimeString());
            //})
            ->orderBy('id', 'desc')
            ->get();

    }

    public function obtainForSectionPaginate(Section $section)
    {

        return Enrollment::query()
            ->select('enrollment.*')
            ->join('user', 'enrollment.student_id', '=', 'user.id')
            ->with($this->relationships())
            ->where('section_id', $section->id)
            ->orderBy('user.lastname', 'asc')
            ->orderBy('user.name', 'asc')
            ->paginate(20);
    }

    public function obtainForCoursePaginate(Course $course)
    {

        return Enrollment::query()
            ->select('enrollment.*')
            ->join('section', 'enrollment.section_id', '=', 'section.id')
            ->join('user', 'enrollment.student_id', '=', 'user.id')
            ->with($this->relationships())
            ->whereHas('section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->orderBy('section.name', 'asc')
            ->orderBy('user.lastname', 'asc')
            ->orderBy('user.name', 'asc')
            ->paginate(20);
    }

    public function countEnrollmentsByCourses (IdCollection $idCollection){

        return Enrollment::query()
            ->whereHas('section', function ($query) use ($idCollection) {
                $query->whereIn('course_id', $idCollection->toArray());
            })
            ->count();

    }

    public function obtainOnlyIdsFromCourse(Course $course)
    {

        return Enrollment::query()
            ->select('enrollment.id', 'enrollment.student_id')
            ->join('section', 'enrollment.section_id', '=', 'section.id')
            ->whereHas('section', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->get();
    }

    public function relationships(): array
    {
        return [
            'section',
            'section.course',
            'section.course.coachingWeek',
            'section.course.conversationPackage',
            'status',
            'user',
        ];
    }

    public function paymentRelationships(): array
    {

        return [
            'paymentDetail',
            'paymentDetail.payment',
            'paymentDetail.payment.methodPayment',
        ];

    }

    public function relationshipsWithSession(): array
    {

        $relationships = $this->relationships();

        $paymentRelationships = $this->paymentRelationships();

        $sessionRelationships = [
            'enrollmentSession',
            'enrollmentSession.session',
            'enrollmentSession.session.coach',
            'enrollmentSession.session.coach.coachInfo',
            'enrollmentSession.session.coachSessionStatus',
            //'enrollmentSession.session.coachSchedule',

            'enrollmentSession.coachingWeek',
            'enrollmentSession.feedback',
            'enrollmentSession.feedback.participationType',
            'enrollmentSession.feedback.preparedClassType',
            'enrollmentSession.feedback.puntualityType',
            'enrollmentSession.extraSession',
            'enrollmentSession.makeup',
            'enrollmentSession.recovered',
            'enrollmentSession.status',

        ];

        return array_merge($relationships, $sessionRelationships, $paymentRelationships);
    }
}
